<?php

namespace App\Http\Controllers;

use App\Models\AdminInvoice;
use App\Models\AkunLevel1;
use App\Models\Anggota;
use App\Models\Desa;
use App\Models\JenisProdukPinjaman;
use App\Models\JenisSimpanan;
use App\Models\Kecamatan;
use App\Models\PinjamanAnggota;
use App\Models\PinjamanIndividu;
use App\Models\PinjamanKelompok;
use App\Models\RealAngsuran;
use App\Models\Rekening;
use App\Models\RencanaAngsuran;
use App\Models\Saldo;
use App\Models\Simpanan;
use App\Models\Transaksi;
use App\Utils\Keuangan;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Cookie;
use DB;
use Session;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        if (Session::get('pesan')) {
            // $this->piutang();
            $this->sync(Session::get('lokasi'));
        }

        $tgl_pakai = $kec->tgl_pakai;
        $tgl = date('Y-m-d');
        $jumlah = 1 + (date("Y", strtotime($tgl)) - date("Y", strtotime($tgl_pakai))) * 12;
        $jumlah += date("m", strtotime($tgl)) - date("m", strtotime($tgl_pakai));
        $data['jumlah'] = Rekening::count() + $jumlah;
        $data['request'] = '?tahun=' . date('Y', strtotime($tgl_pakai)) . '&bulan=' . date('m');

        $pinj_anggota = PinjamanAnggota::where([
            ['status', 'A'],
            ['tgl_cair', '<=', $tgl]
        ])->count();

        $data['pinjaman_anggota'] = $pinj_anggota;
        $tb = 'pinjaman_anggota_' . Session::get('lokasi');
        $pinj = PinjamanAnggota::select([
            DB::raw("(SELECT count(*) FROM $tb WHERE status='P') as p"),
            DB::raw("(SELECT count(*) FROM $tb WHERE status='V') as v"),
            DB::raw("(SELECT count(*) FROM $tb WHERE status='W') as w"),
        ])->first();

        $data['proposal'] = 0;
        $data['verifikasi'] = 0;
        $data['waiting'] = 0;
        if ($pinj) {
            $data['proposal'] = $pinj->p;
            $data['verifikasi'] = $pinj->v;
            $data['waiting'] = $pinj->w;
        }

        // Tambahan: Data pinjaman berdasarkan jenis produk
        $jenis_pp = JenisProdukPinjaman::where(function ($query) {
                $query->where('lokasi', '0')
                    ->where('kecuali', 'NOT LIKE', '%#' . session('lokasi') . '#%');
            })
            ->orWhere(function ($query) {
                $query->where('lokasi', session('lokasi'))
                    ->where('kecuali', 'NOT LIKE', '%#' . session('lokasi') . '#%');
            })
            ->orderBy('kode', 'asc')
            ->get();

        $data['pinjaman_labels'] = [];
        $data['pinjaman_data'] = [];

        foreach ($jenis_pp as $jenis) {
            $count = PinjamanAnggota::where('jenis_pp', $jenis->kode)
                        ->where('status', 'A')
                        ->count();
        
            $data['pinjaman_labels'][] = $jenis->nama_jpp;
            $data['pinjaman_data'][] = $count;
        }

        // simpanan
        $tgl_hari_ini = Carbon::now();
        $tgl_angg = 15;
        
        $tgl_hitung = $tgl_hari_ini->day > $tgl_angg
            ? $tgl_hari_ini->copy()->day($tgl_angg)
            : $tgl_hari_ini->copy()->subMonth()->day($tgl_angg);

        // Buat urutan bulan mundur 12 bulan ke belakang
        $bulan_angka = collect(range(1, 12))->map(function ($i) use ($tgl_hitung) {
            return $tgl_hitung->copy()->addMonths($i)->month;
        });

        // Ambil semua jenis simpanan yang berlaku untuk kecamatan
        $js = JenisSimpanan::where(function ($query) use ($kec) {
            $query->where('lokasi', '0')
                ->orWhere(function ($query) use ($kec) {
                    $query->where('kecuali', 'NOT LIKE', "%-{$kec['id']}-%")
                          ->where('lokasi', 'LIKE', "%-{$kec['id']}-%");
                });
        })->get();

        // Warna default untuk jenis simpanan (urutan penting)
        $colors = ['#2ca8ff', '#7c3aed', '#4adf83', '#ed3a7c', '#0f0b06'];

        $data['simp_set'] = [];

        foreach ($js as $index => $jenis) {
            $dataa = [];

            foreach ($bulan_angka as $bln) {
                $thn = $tgl_hari_ini->year;
                if ($bln >= $tgl_hari_ini->month) {
                    $thn = $tgl_hari_ini->copy()->subYear()->year;
                }

                $awal = Carbon::createFromDate($thn, $bln, 1)->startOfMonth();
                $akhir = $awal->copy()->endOfMonth();
                $tgl_kondisi = $awal->copy()->subMonth()->day($tgl_angg);

                $query = Simpanan::where('jenis_simpanan', $jenis->id)
                    ->where('status', 'A')
                    ->where('tgl_buka', '<', $akhir)
                    ->with('realSimpananTerbesar');

                if ($jenis->id == 2) {
                    $jumlah = $query->get()->filter(function ($item) use ($tgl_kondisi) {
                        return optional($item->realSimpananTerbesar)->tgl_transaksi > $tgl_kondisi;
                    })->count();
                } else {
                    $jumlah = $query->count();
                }

                $dataa[] = $jumlah;
            }

            $data['simp_set'][] = [
                'label' => $jenis->nama_js,
                'data' => $dataa,
                'borderColor' => $colors[$index % count($colors)],
                'pointBackgroundColor' => $colors[$index % count($colors)],
                'pointBorderColor' => $colors[$index % count($colors)],
                'fill' => true,
                'backgroundColor' => $colors[$index % count($colors)].'1D',
                'tension' => 0.4,
                'borderWidth' => 2,
            ];
        }
        $data['simp_labels'] = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan_ini = now()->subMonths($i);
            $data['simp_labels'][] = (int) $bulan_ini->format('n'); // 1 - 12

            if ($i === 0) {
                // Bulan ini → gunakan now()
                $tanggal_hitung_per_bulan[] = now();
            } else {
                // Akhir bulan tersebut
                $tanggal_hitung_per_bulan[] = $bulan_ini->endOfMonth();
            }
        }


        $unpaidInvoice = AdminInvoice::where([
            ['lokasi', Session::get('lokasi')],
            ['status', 'UNPAID']
        ])
        ->where('tgl_lunas', '<=', $today)->count();
        $data['jumlah_unpaid'] = $unpaidInvoice;
        $data['user'] = auth()->user();
        $data['saldo'] = $this->_saldo($tgl);
        $data['jumlah_invoice'] = AdminInvoice::where('lokasi', 'LIKE', Session::get('lokasi') . '%')
            ->where('status', 'UNPAID')
            ->sum('jumlah');


        $data['api'] = env('APP_API', 'https://api-whatsapp.siupk.net');
        $data['title'] = "Dashboard";
        $data['nama_lkm'] = $kec->nama_kec;
        return view('dashboard.index')->with($data);
    }

    public function pinjaman()
    {
        $status = request()->get('status');
        if ($status == 'P') {
            $tgl = 'tgl_proposal';
            $alokasi = 'proposal';
        } else if ($status == 'V') {
            $tgl = 'tgl_verifikasi';
            $alokasi = 'verifikasi';
        } else if ($status == 'W') {
            $tgl = 'tgl_tunggu';
            $alokasi = 'alokasi';
        } else {
            $tgl = 'tgl_cair';
            $alokasi = 'alokasi';
        }

        $table = '';

        $no = 1;
        $pinjaman = PinjamanAnggota::where('status', $status)->with('anggota', 'jpp', 'sts', 'saldo')
            ->orderBy($tgl, 'ASC')->get();
        foreach ($pinjaman as $pinj_anggota) {
            $status = $pinj_anggota->sts->warna_status;

            $table .= '<tr>';
            if ($pinj_anggota->status == 'A') {
                $table .= '<td align="center">' . $no . '</td>';
                $table .= '<td class="text-start d-flex justify-content-between"><span class="badge bg-' . $status . '">' . $pinj_anggota->id . '</span></td>';
                $table .= '<td align="center">' . Tanggal::tglIndo($pinj_anggota->tgl_cair) . '</td>';
                $table .= '<td class="text-start d-flex justify-content-between">' . $pinj_anggota->anggota->nik . '&nbsp;' . $pinj_anggota->anggota->namadepan . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->jpp->nama_jpp . '</td>';
                $table .= '<td align="right">' . number_format($pinj_anggota->alokasi) . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->nama_barang . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->catatan_verifikasi . '</td>';
                if ($pinj_anggota->saldo) {
                    $table .= '<td align="right">' . number_format($pinj_anggota->saldo->saldo_pokok) . '</td>';
                } else {
                    $table .= '<td align="right">' . number_format(0) . '</td>';
                }
                $table .= '<td align="center">' . $pinj_anggota->pinjaman_anggota_count . '</td>';
            } else {
                $table .= '<td align="center">' . $no . '</td>';
                $table .= '<td class="text-start d-flex justify-content-between"><span class="badge bg-' . $status . '">' . $pinj_anggota->id . '</span></td>';
                $table .= '<td align="center">' . Tanggal::tglIndo($pinj_anggota->$tgl) . '</td>';
                $table .= '<td class="text-start d-flex justify-content-between">' . $pinj_anggota->anggota->nik . '&nbsp;' . $pinj_anggota->anggota->namadepan . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->jpp->nama_jpp . '</td>';
                $table .= '<td align="right">' . number_format($pinj_anggota->$alokasi) . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->nama_barang . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->catatan_verifikasi . '</td>';
                $table .= '<td align="center">' . $pinj_anggota->pinjaman_anggota_count . '</td>';
            }
            $table .= '</tr>';

            $no++;
        }

        return response()->json([
            'success' => true,
            'table' => $table
        ]);
    }

    public function pemanfaat()
    {
        $status = request()->get('status');
        if ($status == 'P') {
            $tgl = 'tgl_proposal';
            $alokasi = 'proposal';
        } else if ($status == 'V') {
            $tgl = 'tgl_verifikasi';
            $alokasi = 'verifikasi';
        } else if ($status == 'W') {
            $tgl = 'tgl_tunggu';
            $alokasi = 'alokasi';
        } else {
            $tgl = 'tgl_cair';
            $alokasi = 'alokasi';
        }

        $table = '';

        $no = 1;
        $pinjaman = PinjamanAnggota::where([
            ['status', $status],
            ['jenis_pinjaman', 'I']
        ])->with([
            'anggota',
            'anggota.d',
            'anggota.d.sebutan_desa'
        ])->orderBy('tgl_cair', 'ASC')->get();
        foreach ($pinjaman as $pinj_anggota) {
            $nama_desa = '';
            if ($pinj_anggota->anggota->d) {
                $nama_desa = $pinj_anggota->anggota->d->sebutan_desa->sebutan_desa . ' ' . $pinj_anggota->anggota->d->nama_desa;
            }
            $table .= '<tr>';

            $table .= '<td align="center">' . $no . '</td>';
            $table .= '<td align="center">' . $pinj_anggota->anggota->nik . '</td>';
            $table .= '<td>' . $pinj_anggota->anggota->namadepan . '</td>';
            $table .= '<td>' . $nama_desa . ' ' . $pinj_anggota->anggota->alamat . '</td>';
            $table .= '<td>' .  $pinj_anggota->jangka . '/bulanan' . '</td>';
            $table .= '<td align="center">' . Tanggal::tglIndo($pinj_anggota->$tgl) . '</td>';
            $table .= '<td align="right">' . number_format($pinj_anggota->$alokasi) . '</td>';

            $table .= '</tr>';

            $no++;
        }

        return response()->json([
            'success' => true,
            'table' => $table
        ]);
    }

    public function piutang()
    {
        $thn = date('Y');
        $thn_lalu = ($thn - 1) . "-12-31";
        $thn_awal = $thn . "-01-01";

        $year = date('Y');
        $month = date('m');
        $day = date('d', strtotime('-1 days', strtotime(date('Y-m-d'))));

        $transaksi = Transaksi::where('tgl_transaksi', date('Y-m-d'))
            ->whereRaw("(rekening_debit='1.1.03.04' AND rekening_kredit='4.1.01.01' OR rekening_debit='1.1.03.05' AND rekening_kredit='4.1.01.02' OR rekening_debit='1.1.03.06' AND rekening_kredit='4.1.01.03')");

        if ($transaksi->count() <= 0) {
            $pinjaman_Anggota = PinjamanAnggota::where('status', 'A')->whereDay('tgl_cair', $day)->with('anggota')->get();
            foreach ($pinjaman_Anggota as $pinj_anggota) {
                $real = RealAngsuran::where([
                    ['loan_id', $pinj_anggota->id],
                    ['tgl_transaksi', '<=', $year . '-' . $month . '-' . $day]
                ])->orderBy('tgl_transaksi', 'DESC')->orderBy('id', 'DESC');

                if ($real->count() > 0) {
                    $real_ang = $real->first();
                    $sum_jasa = $real_ang->sum_jasa;
                } else {
                    $sum_jasa = 0;
                }

                $ra = RencanaAngsuran::where([
                    ['loan_id', $pinj_anggota->id],
                    ['jatuh_tempo', '<=', $year . '-' . $month . '-' . $day],
                    ['angsuran_ke', '!=', '0']
                ])->orderBy('id', 'DESC');

                if ($pinj_anggota->jenis_pp == '1') {
                    $piutang = '1.1.03.04';
                    $pendapatan = '4.1.01.01';
                }

                if ($pinj_anggota->jenis_pp == '2') {
                    $piutang = '1.1.03.05';
                    $pendapatan = '4.1.01.02';
                }

                if ($pinj_anggota->jenis_pp == '3') {
                    $piutang = '1.1.03.06';
                    $pendapatan = '4.1.01.03';
                }

                if ($ra->count() > 0) {
                    $rencana = $ra->first();

                    $target_jasa = $rencana->target_jasa;
                    $nunggak_jasa = $target_jasa - $sum_jasa;

                    $insert = [
                        'tgl_transaksi' => date('Y-m-d'),
                        'rekening_debit' => $piutang,
                        'rekening_kredit' => $pendapatan,
                        'idtp' => 0,
                        'id_pinj' => $pinj_anggota->id,
                        'id_pinj_i' => 0,
                        'keterangan_transaksi' => 'Hutang jasa ' . $pinj_anggota->anggota->namadepan . '(' . $pinj_anggota->id . ') angsuran ke ' . $rencana->angsuran_ke,
                        'relasi' => $pinj_anggota->anggota->namadepan,
                        'jumlah' => $nunggak_jasa,
                        'urutan' => 0,
                        'id_user' => auth()->user()->id,
                    ];

                    if ($nunggak_jasa > 0) {
                        Transaksi::create($insert);
                    }
                }
            }
        }

        echo '<script>window.close()</script>';
    }

    private function _piutang()
    {
        $thn = date('Y');
        $thn_lalu = ($thn - 1) . "-12-31";
        $thn_awal = $thn . "-01-01";

        $piutang_jasa = [];
        $piutang_jasa['1.1.03.04'] = 0;
        $piutang_jasa['1.1.03.05'] = 0;
        $piutang_jasa['1.1.03.06'] = 0;

        $piutang_jasa['4.1.01.01'] = 0;
        $piutang_jasa['4.1.01.02'] = 0;
        $piutang_jasa['4.1.01.03'] = 0;

        $pinjaman_Anggota = PinjamanAnggota::where('status', 'A')->orderBy('tgl_proposal', 'ASC')->get();
        foreach ($pinjaman_Anggota as $pinj_anggota) {

            if ($pinj_anggota->jenis_pp == '1') {
                $piutang = '1.1.03.04';
                $pendapatan = '4.1.01.01';
            }

            if ($pinj_anggota->jenis_pp == '2') {
                $piutang = '1.1.03.05';
                $pendapatan = '4.1.01.02';
            }

            if ($pinj_anggota->jenis_pp == '3') {
                $piutang = '1.1.03.06';
                $pendapatan = '4.1.01.03';
            }

            $ra = RencanaAngsuran::where([
                ['loan_id', '=', $pinj_anggota->id],
                ['jatuh_tempo', '<=', $thn_lalu],
                ['angsuran_ke', '!=', '0']
            ])->orderBy('jatuh_tempo', 'DESC');

            $real = RealAngsuran::where([
                ['loan_id', '=', $pinj_anggota->id],
                ['tgl_transaksi', '<=', $thn_lalu]
            ])->orderBy('tgl_transaksi', 'DESC');

            if ($real->count() > 0) {
                $real_ang = $real->first();
                $sum_jasa = $real_ang->sum_jasa;
            } else {
                $sum_jasa = 0;
            }

            if ($ra->count() > 0) {
                $rencana = $ra->first();

                $piutang_jasa[$piutang] += ($rencana->target_jasa - $sum_jasa);
                $piutang_jasa[$pendapatan] += ($rencana->target_jasa - $sum_jasa);
            }
        }

        foreach ($piutang_jasa as $key => $val) {
            $rek = Rekening::where('kode_akun', $key)->first();

            if (Keuangan::startWith($key, '4.1.01')) {
                $update = [
                    'tbk' . (date('Y') - 1) => $rek->tbk2022 + $val
                ];

                $kd_rek = $rek->tbk2022;
            } else {
                $update = [
                    'tb' . (date('Y') - 1) => $rek->tb_2022 + $val
                ];
                $kd_rek = $rek->tb2022;
            }

            if ($kd_rek < $val) {
                Rekening::where('kode_akun', $key)->update($update);
            }
        }
    }

    public function jatuhTempo(Request $request)
    {
        $tgl = Tanggal::tglNasional($request->tgl);

        $jatuh_tempo = '00';
        $pinjaman = PinjamanAnggota::where('status', 'A')->whereDay('tgl_cair', date('d', strtotime($tgl)))->with([
            'target' => function ($query) use ($tgl) {
                $query->where([
                    ['jatuh_tempo', $tgl],
                    ['angsuran_ke', '!=', '0']
                ]);
            },
            'saldo' => function ($query) use ($tgl) {
                $query->where('tgl_transaksi', '<=', $tgl);
            },
            'anggota',
            'anggota.d'
        ])->get();

        $table = '';
        $no = 1;
        foreach ($pinjaman as $pinj_anggota) {
            if ($pinj_anggota->target) {
                $sum_pokok = 0;
                $sum_jasa = 0;

                if ($pinj_anggota->saldo) {
                    $sum_pokok = $pinj_anggota->saldo->sum_pokok;
                    $sum_jasa = $pinj_anggota->saldo->sum_jasa;
                }

                $nunggak_pokok = $pinj_anggota->target->target_pokok - $sum_pokok;
                $nunggak_jasa = $pinj_anggota->target->target_jasa - $sum_jasa;
                $total_pokok_jasa = $nunggak_pokok + $nunggak_jasa;

                if ($nunggak_pokok > 0 || $nunggak_jasa > 0) {
                    $jatuh_tempo++;
                    $table .= '<tr>';
                    $table .= '<td align="center">' . $no++ . '</td>';
                    $table .= '<td align="center">' . $pinj_anggota->id . '</td>';
                    $table .= '<td>' . $pinj_anggota->anggota->namadepan . '[' . $pinj_anggota->anggota->d->nama_desa . '] - ' . '</td>';
                    $table .= '<td>' . Tanggal::tglIndo($pinj_anggota->tgl_cair) . '</td>';
                    $table .= '<td align="right">' . number_format($nunggak_pokok) . '</td>';
                    $table .= '<td align="right">' . number_format($nunggak_jasa) . '</td>';
                    $table .= '<td align="right">' . number_format($total_pokok_jasa) . '</td>';
                    $table .= '<td align="center">' . $pinj_anggota->catatan_verifikasi . '</td>';
                    $table .= '</tr>';
                }
            }
        }

        return response()->json([
            'success' => true,
            'jatuh_tempo' => $jatuh_tempo,
            'hari_ini' => $table
        ]);
    }

    public function nunggak(Request $request)
    {
        $tgl = Tanggal::tglNasional($request->tgl);
        $pinjaman = PinjamanAnggota::where('status', 'A')->whereDay('tgl_cair', '<=', $tgl)->with([
            'target' => function ($query) use ($tgl) {
                $query->where([
                    ['jatuh_tempo', '<=', $tgl],
                    ['angsuran_ke', '!=', '0']
                ]);
            },
            'saldo' => function ($query) use ($tgl) {
                $query->where('tgl_transaksi', '<=', $tgl);
            },
            'anggota',
            'anggota.d'
        ])->orderBy('tgl_cair', 'ASC')->orderBy('id', 'ASC')->get();

        $nunggak = "00";
        $table = '';
        $no = 1;
        foreach ($pinjaman as $pinj_anggota) {
            $real_pokok = 0;
            $real_jasa = 0;
            $sum_pokok = 0;
            $sum_jasa = 0;
            $saldo_pokok = $pinj_anggota->alokasi;
            $saldo_jasa = $pinj_anggota->pros_jasa == 0 ? 0 : $pinj_anggota->alokasi * ($pinj_anggota->pros_jasa / 100);
            if ($pinj_anggota->saldo) {
                $real_pokok = $pinj_anggota->saldo->realisasi_pokok;
                $real_jasa = $pinj_anggota->saldo->realisasi_jasa;
                $sum_pokok = $pinj_anggota->saldo->sum_pokok;
                $sum_jasa = $pinj_anggota->saldo->sum_jasa;
                $saldo_pokok = $pinj_anggota->saldo->saldo_pokok;
                $saldo_jasa = $pinj_anggota->saldo->saldo_jasa;
            }

            $target_pokok = 0;
            $target_jasa = 0;
            if ($pinj_anggota->target) {
                $target_pokok = $pinj_anggota->target->target_pokok;
                $target_jasa = $pinj_anggota->target->target_jasa;
            }

            $tunggakan_pokok = $target_pokok - $sum_pokok;
            if ($tunggakan_pokok < 0) {
                $tunggakan_pokok = 0;
            }
            $tunggakan_jasa = $target_jasa - $sum_jasa;
            if ($tunggakan_jasa < 0) {
                $tunggakan_jasa = 0;
            }
            $totaltunggakan_pokok_jasa = $tunggakan_pokok + $tunggakan_jasa;

            if ($tunggakan_pokok != 0 || $tunggakan_jasa != 0) {
                $nunggak++;
                $table .= '<tr>';

                $table .= '<td align="center">' . $no++ . '</td>';
                $table .= '<td align="centar">' . $pinj_anggota->id . '</td>';
                $table .= '<td align="centar">' . Tanggal::tglIndo($pinj_anggota->tgl_cair) . '</td>';
                $table .= '<td align="centar">' . $pinj_anggota->anggota->namadepan . '</td>';
                $table .= '<td align="centar">' . $pinj_anggota->anggota->d->nama_desa . '</td>';
                $table .= '<td align="right">' . number_format($pinj_anggota->alokasi) . '</td>';
                $table .= '<td align="right">' . number_format($tunggakan_pokok) . '</td>';
                $table .= '<td align="right">' . number_format($tunggakan_jasa) . '</td>';
                $table .= '<td align="right">' . number_format($totaltunggakan_pokok_jasa) . '</td>';
                $table .= '<td align="centar">' . $pinj_anggota->catatan_verifikasi . '</td>';
                $table .= '</tr>';
            }
        }

        return response()->json([
            'success' => true,
            'nunggak' => $nunggak,
            'table' => $table
        ]);
    }

    public function tagihan(Request $request)
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $pesan_wa = json_decode($kec->whatsapp, true);

        $tanggal = Tanggal::tglNasional($request->tgl_tagihan);
        $tgl_bayar = Tanggal::tglNasional($request->tgl_pembayaran);
        $pesan = $pesan_wa['tagihan'];

        $pesan = strtr($pesan, [
            '{Tanggal Jatuh Tempo}' => $request->tgl_tagihan,
            '{Tanggal Bayar}' => $request->tgl_pembayaran,
            '{User Login}' => auth()->user()->namadepan . ' ' . auth()->user()->namabelakang,
            '{Telpon}' => auth()->user()->hp
        ]);

        $pinjaman = PinjamanAnggota::where('status', 'A')->whereDay('tgl_cair', date('d', strtotime($tanggal)))->with([
            'target' => function ($query) use ($tanggal) {
                $query->where([
                    ['jatuh_tempo', $tanggal],
                    ['angsuran_ke', '!=', '0']
                ]);
            },
            'saldo' => function ($query) use ($tanggal) {
                $query->where('tgl_transaksi', '<=', $tanggal);
            },
            'anggota',
            'anggota.d',
            'anggota.d.sebutan_desa'
        ])->get();

        return response()->json([
            'success' => true,
            'tagihan' => view('dashboard.partials.tagihan')->with(compact('pinjaman', 'pesan'))->render()
        ]);
    }

    public function lineChart(Request $request)
    {
        $tgl = Tanggal::tglNasional($request->tgl);
    }

    public function setting(Request $request)
    {
        // Cookie
    }

    public function sync($lokasi)
    {
        $tahun = date('Y');
        $bulan = date('m');
        $kec = Kecamatan::where('id', Session::get('lokasi'))->with('desa')->first();

        if (Saldo::where([['kode_akun', 'LIKE', '%' . $kec->kd_kec . '%']])->count() <= 0) {
            $saldo_desa = [];
            foreach ($kec->desa as $desa) {
                $saldo_desa[] = [
                    'id' => $desa->kd_desa . $tahun . 0,
                    'kode_akun' => $desa->kode_desa,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];
            }

            $saldo_desa[] = [
                'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 1,
                'kode_akun' => $kec->kd_kec,
                'tahun' => $tahun,
                'bulan' => 0,
                'debit' => 0,
                'kredit' => 0
            ];
            $saldo_desa[] = [
                'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 2,
                'kode_akun' => $kec->kd_kec,
                'tahun' => $tahun,
                'bulan' => 0,
                'debit' => 0,
                'kredit' => 0
            ];
            $saldo_desa[] = [
                'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 3,
                'kode_akun' => $kec->kd_kec,
                'tahun' => $tahun,
                'bulan' => 0,
                'debit' => 0,
                'kredit' => 0
            ];
            $saldo_desa[] = [
                'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 4,
                'kode_akun' => $kec->kd_kec,
                'tahun' => $tahun,
                'bulan' => 0,
                'debit' => 0,
                'kredit' => 0
            ];
            $saldo_desa[] = [
                'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 5,
                'kode_akun' => $kec->kd_kec,
                'tahun' => $tahun,
                'bulan' => 0,
                'debit' => 0,
                'kredit' => 0
            ];
            $saldo_desa[] = [
                'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 6,
                'kode_akun' => $kec->kd_kec,
                'tahun' => $tahun,
                'bulan' => 0,
                'debit' => 0,
                'kredit' => 0
            ];

            Saldo::insert($saldo_desa);
        }

        $date = $tahun . '-' . $bulan . '-01';

        $saldo = Saldo::where([
            ['tahun', $tahun],
            ['bulan', $bulan]
        ])->with([
            'saldo' => function ($query) use ($tahun, $bulan) {
                $bulan = (($bulan - 1) < 1) ? 1 : $bulan - 1;

                $query->where([
                    ['tahun', $tahun],
                    ['bulan', $bulan]
                ]);
            }
        ])->orderBy('kode_akun', 'ASC')->get();

        $data_id = [];
        $insert = [];
        foreach ($saldo as $s) {
            $debit = 0;
            $kredit = 0;
            $debit_lalu = 0;
            $kredit_lalu = 0;

            if ($s->debit > 0) {
                $debit = $s->debit;
            }

            if ($s->kredit > 0) {
                $kredit = $s->kredit;
            }

            if ($s->saldo) {
                if ($s->saldo->debit > 0) {
                    $debit_lalu = $s->saldo->debit;
                }

                if ($s->saldo->kredit > 0) {
                    $kredit_lalu = $s->saldo->kredit;
                }
            }

            if ($debit < $debit_lalu || $kredit < $kredit_lalu) {
                $id = str_replace('.', '', $s->kode_akun) . $tahun . str_pad($bulan, 2, "0", STR_PAD_LEFT);
                $insert[] = [
                    'id' => $id,
                    'kode_akun' => $s->kode_akun,
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'debit' => $debit_lalu,
                    'kredit' => $kredit_lalu
                ];

                $data_id[] = $id;
            }
        }

        if (count($insert) > 0) {
            Saldo::whereIn('id', $data_id)->delete();
            $query = Saldo::insert($insert);

            $update = Saldo::where([
                ['tahun', $tahun],
                ['bulan', '>', $bulan]
            ])->update([
                'debit' => 0,
                'kredit' => 0
            ]);
        }
    }

    private function _saldo($tgl)
    {
        $data = [
            '4' => [
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
                '9' => 0,
                '10' => 0,
                '11' => 0,
                '12' => 0,
            ],
            '5' => [
                '1' => 0,
                '2' => 0,
                '3' => 0,
                '4' => 0,
                '5' => 0,
                '6' => 0,
                '7' => 0,
                '8' => 0,
                '9' => 0,
                '10' => 0,
                '11' => 0,
                '12' => 0,
            ],
        ];

        $akun1 = AkunLevel1::where('lev1', '>=', '4')->with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.rek',
            'akun2.akun3.rek.kom_saldo' => function ($query) use ($tgl) {
                $tahun = date('Y', strtotime($tgl));
                $query->where([
                    ['tahun', $tahun],
                    ['bulan', '!=', '0'],
                    ['bulan', '!=', '13']
                ])->orderBy('kode_akun', 'ASC')->orderBy('bulan', 'ASC');
            },
        ])->get();

        foreach ($akun1 as $lev1) {
            $kom_saldo[$lev1->lev1] = $data[$lev1->lev1];
            foreach ($lev1->akun2 as $lev2) {
                foreach ($lev2->akun3 as $lev3) {
                    foreach ($lev3->rek as $rek) {
                        foreach ($rek->kom_saldo as $saldo) {
                            if ($lev1->lev1 == '5') {
                                $_saldo = $saldo->debit - $saldo->kredit;
                            } else {
                                $_saldo = $saldo->kredit - $saldo->debit;
                            }

                            $kom_saldo[$lev1->lev1][$saldo->bulan] += $_saldo;
                            if ($saldo->bulan > 1) {
                                if ($kom_saldo[$lev1->lev1][$saldo->bulan] < $kom_saldo[$lev1->lev1][$saldo->bulan - 1]) {
                                    $kom_saldo[$lev1->lev1][$saldo->bulan] = $kom_saldo[$lev1->lev1][$saldo->bulan - 1];
                                }
                            }
                        }
                    }
                }
            }
        }

        $kom_saldo['surplus'] = [
            '1' => $kom_saldo['4']['1'] - $kom_saldo['5']['1'],
            '2' => $kom_saldo['4']['2'] - $kom_saldo['5']['2'],
            '3' => $kom_saldo['4']['3'] - $kom_saldo['5']['3'],
            '4' => $kom_saldo['4']['4'] - $kom_saldo['5']['4'],
            '5' => $kom_saldo['4']['5'] - $kom_saldo['5']['5'],
            '6' => $kom_saldo['4']['6'] - $kom_saldo['5']['6'],
            '7' => $kom_saldo['4']['7'] - $kom_saldo['5']['7'],
            '8' => $kom_saldo['4']['8'] - $kom_saldo['5']['8'],
            '9' => $kom_saldo['4']['9'] - $kom_saldo['5']['9'],
            '10' => $kom_saldo['4']['10'] - $kom_saldo['5']['10'],
            '11' => $kom_saldo['4']['11'] - $kom_saldo['5']['11'],
            '12' => $kom_saldo['4']['12'] - $kom_saldo['5']['12'],
        ];

        return $kom_saldo;
    }

    public function unpaid()
    {
        $invoice = AdminInvoice::where([
            ['lokasi', Session::get('lokasi')],
            ['status', 'UNPAID']
        ])->orderBy('tgl_invoice', 'DESC');

        $jumlah = 0;
        if ($invoice->count() > 0) {
            $jumlah = $invoice->count();
            $inv = $invoice->first();
        }

        return response()->json([
            'success' => true,
            'invoice' => $jumlah
        ]);
    }

    public function simpanSaldo()
    {
        $tahun = request()->get('tahun') ?: date('Y');
        $bulan = request()->get('bulan') ?: date('m');
        $kode_akun = request()->get('kode_akun') ?: '0';

        $kec = Kecamatan::where('id', Session::get('lokasi'))->with('desa')->first();

        $data_id = [];
        $saldo = [];
        if ($bulan == '00') {

            if (Saldo::where([
                ['kode_akun', 'LIKE', '%' . $kec->kd_kec . '%'],
                ['tahun', $tahun]
            ])->count() <= 0) {
                $saldo_desa = [];
                foreach ($kec->desa as $desa) {
                    $saldo_desa[] = [
                        'id' => $desa->kd_desa . $tahun . 0,
                        'kode_akun' => $desa->kode_desa,
                        'tahun' => $tahun,
                        'bulan' => 0,
                        'debit' => 0,
                        'kredit' => 0
                    ];
                }

                $saldo_desa[] = [
                    'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 1,
                    'kode_akun' => $kec->kd_kec,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];
                $saldo_desa[] = [
                    'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 2,
                    'kode_akun' => $kec->kd_kec,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];
                $saldo_desa[] = [
                    'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 3,
                    'kode_akun' => $kec->kd_kec,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];
                $saldo_desa[] = [
                    'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 4,
                    'kode_akun' => $kec->kd_kec,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];
                $saldo_desa[] = [
                    'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 5,
                    'kode_akun' => $kec->kd_kec,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];
                $saldo_desa[] = [
                    'id' => str_replace('.', '', $kec->kd_kec) . $tahun . 0 . 6,
                    'kode_akun' => $kec->kd_kec,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => 0,
                    'kredit' => 0
                ];

                Saldo::insert($saldo_desa);
            }

            $tahun_tb = $tahun - 1;
            $tb = 'tb' . $tahun_tb;
            $tbk = 'tbk' . $tahun_tb;

            $rekening = Rekening::orderBy('kode_akun', 'ASC')->get();
            foreach ($rekening as $rek) {
                $saldo_debit = $rek->$tb;
                $saldo_kredit = $rek->$tbk;

                $id = str_replace('.', '', $rek->kode_akun) . $tahun . "00";
                $saldo[] = [
                    'id' => $id,
                    'kode_akun' => $rek->kode_akun,
                    'tahun' => $tahun,
                    'bulan' => 0,
                    'debit' => $saldo_debit,
                    'kredit' => $saldo_kredit
                ];

                $data_id[] = $id;
            }
        } else {
            $date = $tahun . '-' . $bulan . '-01';
            $tgl_kondisi = date('Y-m-t', strtotime($date));
            $rekening = Rekening::withSum([
                'trx_debit' => function ($query) use ($tgl_kondisi, $tahun) {
                    $query->whereBetween('tgl_transaksi', [$tahun . '-01-01', $tgl_kondisi]);
                }
            ], 'jumlah')->withSum([
                'trx_kredit' => function ($query) use ($tgl_kondisi, $tahun) {
                    $query->whereBetween('tgl_transaksi', [$tahun . '-01-01', $tgl_kondisi]);
                }
            ], 'jumlah')->orderBy('kode_akun', 'ASC');
            if ($kode_akun != '0') {
                $kode = explode(',', $kode_akun);
                $rekening = $rekening->whereIn('kode_akun', $kode);
            }

            $rekening = $rekening->get();

            foreach ($rekening as $rek) {
                $id = str_replace('.', '', $rek->kode_akun) . $tahun . str_pad($bulan, 2, "0", STR_PAD_LEFT);
                $saldo[] = [
                    'id' => $id,
                    'kode_akun' => $rek->kode_akun,
                    'tahun' => $tahun,
                    'bulan' => intval($bulan),
                    'debit' => $rek->trx_debit_sum_jumlah,
                    'kredit' => $rek->trx_kredit_sum_jumlah
                ];

                $data_id[] = $id;
            }
        }

        if ($bulan < 1) {
            $jumlah = Saldo::where([
                ['tahun', $tahun],
                ['bulan', '0']
            ])->whereRaw('LENGTH(kode_akun)=9')->count();

            if ($jumlah <= '0') {
                Saldo::whereIn('id', $data_id)->delete();
                $query = Saldo::insert($saldo);
            }
        } else {
            Saldo::whereIn('id', $data_id)->delete();
            $query = Saldo::insert($saldo);
        }

        $link = request()->url('');
        $query = request()->query();

        if (isset($query['bulan'])) {
            $query['bulan'] += 1;
        } else {
            $query['bulan'] = date('m') + 1;
        }
        if (!isset($query['tahun'])) {
            $query['tahun'] = date('Y');
        }

        $query['bulan'] = str_pad($query['bulan'], 2, '0', STR_PAD_LEFT);
        $next = $link . '?' . http_build_query($query);

        if (($kode_akun != '0' && $bulan >= date('m'))) {
            echo '<script>window.opener.postMessage("closed", "*"); window.close();</script>';
            exit;
        }

        if ($query['bulan'] < 13) {
            echo '<a href="' . $next . '" id="next"></a><script>document.querySelector("#next").click()</script>';
            exit;
        } else {
            echo '<script>window.opener.postMessage("closed", "*"); window.close();</script>';
            exit;
        }
    }
}

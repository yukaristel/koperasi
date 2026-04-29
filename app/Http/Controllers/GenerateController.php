<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PinjamanAnggota;
use App\Models\PinjamanIndividu;
use App\Models\PinjamanKelompok;
use App\Models\RealAngsuran;
use App\Models\RealAngsuranI;
use App\Models\RencanaAngsuran;
use App\Models\RencanaAngsuranI;
use App\Utils\Keuangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use URL;

class GenerateController extends Controller
{
    // =========================================================================
    // COA Koperasi — $RRODUX2 (siupk_koperasi)
    // =========================================================================
    //
    // jenis_pp = 1  → Anggota
    //   Pokok   : 1.1.03.01  (Pinjaman yang Diberikan — Anggota)
    //   Jasa    : 4.1.01.01  (Pendapatan Jasa Pinjaman — Anggota)
    //   Denda   : 4.1.02.01  (Pendapatan Denda Pinjaman — Anggota)
    //
    // jenis_pp = 2  → Pinjaman Koperasi Lain  (diperlakukan seperti Non-Anggota)
    // jenis_pp = 3  → Non-Anggota
    //   Pokok   : 1.1.03.02  (Pinjaman yang Diberikan — Non-Anggota)
    //   Jasa    : 4.2.01.01  (Pendapatan Jasa Pinjaman — Non-Anggota)
    //   Denda   : 4.2.02.01  (Pendapatan Denda Pinjaman — Non-Anggota)
    //
    // =========================================================================

    /**
     * Ambil prefix rekening berdasarkan jenis_pp pinjaman.
     * Mengembalikan array ['pokok', 'jasa', 'denda']
     */
    private function getRekeningSuffix(int $jenis_pp): array
    {
        if ($jenis_pp == 1) {
            // Anggota
            return [
                'pokok' => '1.1.03.01',
                'jasa'  => '4.1.01.01',
                'denda' => '4.1.02.01',
            ];
        }

        // jenis_pp == 2 (Koperasi Lain) & jenis_pp == 3 (Non-Anggota)
        return [
            'pokok' => '1.1.03.02',
            'jasa'  => '4.2.01.01',
            'denda' => '4.2.02.01',
        ];
    }

    // =========================================================================
    // Routes
    // =========================================================================

    public function index()
    {
        $kec = Kecamatan::where('web_kec', explode('//', URL::to('/'))[1])
            ->orWhere('web_alternatif', explode('//', URL::to('/'))[1])
            ->first();

        Session::put('lokasi', $kec->id);

        $logo = '/assets/img/icon/favicon.png';
        if ($kec->logo) {
            $logo = '/storage/logo/' . $kec->logo;
        }

        return view('generate.index')->with(compact('logo'));
    }

    public function individu()
    {
        $kec      = Kecamatan::where('id', Session::get('lokasi'))->first();
        $database = env('DB_DATABASE', 'siupk_koperasi');
        $table    = 'pinjaman_anggota_' . Session::get('lokasi');

        $strukturTabel = \DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = '$database'
            ORDER BY ORDINAL_POSITION;
        ");

        $struktur = array_map(fn($kolom) => $kolom->COLUMN_NAME, $strukturTabel);

        return response()->json([
            'view' => view('generate.partials.individu')->with(compact('struktur', 'kec'))->render()
        ]);
    }

    public function kelompok()
    {
        $database = env('DB_DATABASE', 'siupk_koperasi');
        $table    = 'pinjaman_kelompok_' . Session::get('lokasi');

        $strukturTabel = \DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA = '$database'
            ORDER BY ORDINAL_POSITION;
        ");

        $struktur = array_map(fn($kolom) => $kolom->COLUMN_NAME, $strukturTabel);

        return response()->json([
            'view' => view('generate.partials.kelompok')->with(compact('struktur'))->render()
        ]);
    }

    // =========================================================================
    // Generate utama
    // =========================================================================

    public function generate(Request $request)
    {
        $real    = [];
        $rencana = [];
        $offset  = (int) $request->input('offset', 0);
        $is_pinkel = ($request->pinjaman == 'kelompok');
        $kec    = Kecamatan::where('id', Session::get('lokasi'))->first();

        // ------------------------------------------------------------------
        // Bangun kondisi WHERE dari request
        // ------------------------------------------------------------------
        $where       = [];
        $whereIn     = [];
        $whereNotIn  = [];

        foreach ($request->all() as $key => $val) {
            if (in_array($key, ['_token', 'pinjaman', 'offset'])) {
                continue;
            }

            $opt   = '=';
            $value = $val;

            if (is_array($val)) {
                $opt   = $val['operator'];
                $value = $val['value'];

                if (!$value) continue;

                if ($opt == 'IN') {
                    foreach (explode(',', $value) as $v) {
                        $whereIn[$key][] = $v;
                    }
                    continue;
                }

                if ($opt == 'NOT IN') {
                    foreach (explode(',', $value) as $v) {
                        $whereNotIn[$key][] = $v;
                    }
                    continue;
                }
            }

            $where[] = [$key, $opt, $value];
        }

        // ------------------------------------------------------------------
        // Query pinjaman
        // ------------------------------------------------------------------
        $limit = 30;

        if ($is_pinkel) {
            $query = PinjamanKelompok::where($where)->with([
                'sis_pokok',
                'sis_jasa',
                'trx' => fn($q) => $q->where('idtp', '!=', '0'),
                'trx.tr_idtp',
                'kelompok',
                'kelompok.d',
            ]);
        } else {
            $query = PinjamanIndividu::where($where)->with([
                'sis_pokok',
                'sis_jasa',
                'trx' => fn($q) => $q->where('idtp', '!=', '0'),
                'trx.tr_idtp',
                'anggota',
                'anggota.d',
            ]);
        }

        foreach ($whereIn as $key => $value) {
            $query = $query->whereIn($key, $value);
        }
        foreach ($whereNotIn as $key => $value) {
            $query = $query->whereNotIn($key, $value);
        }

        $pinjaman = $query->limit($limit)->offset($offset)->orderBy('id', 'ASC')->get();

        // ------------------------------------------------------------------
        // Loop setiap pinjaman
        // ------------------------------------------------------------------
        $data_id_pinj = [];
        $data_id_real = [];

        foreach ($pinjaman as $pinj) {
            $data_id_pinj[] = $pinj->id;

            // ----------------------------------------------------------------
            // Tentukan rekening COA berdasarkan jenis_pp
            // jenis_pp: 1 = Anggota, 2 = Koperasi Lain, 3 = Non-Anggota
            // ----------------------------------------------------------------
            $jenis_pp = (int) ($pinj->jenis_pp ?? 1);
            $rek      = $this->getRekeningSuffix($jenis_pp);

            // ----------------------------------------------------------------
            // Tentukan alokasi & tanggal cair berdasarkan status
            // Kolom koperasi: data_proposal  = "tgl#alokasi#jangka#pros_jasa#..."
            //                 data_verifikasi = "tgl#alokasi#..."
            //                 data_waiting    = "tgl#id_petugas"
            //                 tgl_cair        = kolom langsung
            // ----------------------------------------------------------------
            if ($pinj->status == 'P') {
                // Proposal — ambil dari data_proposal
                $parts    = explode('#', $pinj->data_proposal ?? '');
                $tgl_cair = $parts[0] ?? $pinj->tgl_cair;
                $alokasi  = (int) ($parts[1] ?? $pinj->alokasi);
            } elseif ($pinj->status == 'V') {
                // Verifikasi — ambil dari data_verifikasi
                $parts    = explode('#', $pinj->data_verifikasi ?? '');
                $tgl_cair = $parts[0] ?? $pinj->tgl_cair;
                $alokasi  = (int) ($parts[1] ?? $pinj->alokasi);
            } elseif ($pinj->status == 'W') {
                // Waiting — ambil tgl dari data_waiting, alokasi dari alokasi
                $parts    = explode('#', $pinj->data_waiting ?? '');
                $tgl_cair = $parts[0] ?? $pinj->tgl_cair;
                $alokasi  = (int) $pinj->alokasi;

                if (!$tgl_cair || $tgl_cair == '0000-00-00') {
                    $tgl_cair = $pinj->tgl_cair;
                }
            } else {
                // L (Lunas) / aktif — pakai tgl_cair langsung
                $alokasi  = (int) $pinj->alokasi;
                $tgl_cair = $pinj->tgl_cair;

                if (!$tgl_cair || $tgl_cair == '0000-00-00') {
                    $parts    = explode('#', $pinj->data_waiting ?? '');
                    $tgl_cair = $parts[0] ?? date('Y-m-d');
                }
            }

            $jenis_jasa = $pinj->jenis_jasa;
            $jangka     = (int) $pinj->jangka;
            $sa_pokok   = (int) $pinj->sistem_angsuran;
            $sa_jasa    = (int) $pinj->sa_jasa;
            $pros_jasa  = (float) $pinj->pros_jasa;

            // ----------------------------------------------------------------
            // Jadwal angsuran — index & jumlah angsuran
            // ----------------------------------------------------------------
            $index           = 1;
            $jumlah_angsuran = $jangka;

            if ($kec->jdwl_angsuran == '1') {
                $index           = 0;
                $jumlah_angsuran = $jangka - 1;
                $tgl_cair        = date('Y-m-d', strtotime('0 month', strtotime($tgl_cair)));
            }

            $simpan_tgl = $tgl_cair;

            // Desa/kelompok untuk jadwal angsuran desa
            $desa = $is_pinkel
                ? ($pinj->kelompok->d ?? null)
                : ($pinj->anggota->d  ?? null);

            $tgl_angsur    = $tgl_cair;
            $tanggal_cair  = date('d', strtotime($tgl_cair));

            if ($desa && $desa->jadwal_angsuran_desa > 0) {
                $angsuran_desa = $desa->jadwal_angsuran_desa;
                $tgl_pinjaman  = date('Y-m', strtotime($tgl_cair));
                $tgl_cair      = $tgl_pinjaman . '-' . $angsuran_desa;
            }

            if ($kec->batas_angsuran > 0) {
                $batas_tgl_angsuran = $kec->batas_angsuran;
                if ($tanggal_cair >= $batas_tgl_angsuran) {
                    $tgl_cair = date('Y-m-d', strtotime('+1 month', strtotime($tgl_cair)));
                }
            }

            // ----------------------------------------------------------------
            // Sistem pokok & jasa
            // ----------------------------------------------------------------
            $sistem_pokok = ($pinj->sis_pokok) ? $pinj->sis_pokok->sistem : '1';
            $sistem_jasa  = ($pinj->sis_jasa)  ? $pinj->sis_jasa->sistem  : '1';

            // Hitung tempo
            if ($sa_pokok == 11) {
                $tempo_pokok = $jangka - 24 / $sistem_pokok;
            } elseif ($sa_pokok == 14) {
                $tempo_pokok = $jangka - 3  / $sistem_pokok;
            } elseif ($sa_pokok == 15) {
                $tempo_pokok = $jangka - 2  / $sistem_pokok;
            } elseif ($sa_pokok == 20) {
                $tempo_pokok = $jangka - 12 / $sistem_pokok;
            } else {
                $tempo_pokok = floor($jangka / $sistem_pokok);
            }

            if ($sa_jasa == 11) {
                $tempo_jasa = $jangka - 24 / $sistem_jasa;
            } elseif ($sa_jasa == 14) {
                $tempo_jasa = $jangka - 3  / $sistem_jasa;
            } elseif ($sa_jasa == 15) {
                $tempo_jasa = $jangka - 2  / $sistem_jasa;
            } elseif ($sa_jasa == 20) {
                $tempo_jasa = $jangka - 12 / $sistem_jasa;
            } else {
                $tempo_jasa = floor($jangka / $sistem_jasa);
            }

            // ----------------------------------------------------------------
            // Hitung rencana angsuran (ra) per periode
            // ----------------------------------------------------------------
            $ra                  = [];
            $alokasi_pokok_temp  = $alokasi;
            $sum_angsuran_jasa   = 0;

            if ($jenis_jasa == '3') {
                // --- Anuitas ---
                $bunga_per_bulan = ($pros_jasa / 100) / $jangka;
                $angsuran_total  = Keuangan::pembulatan(
                    ($alokasi * $bunga_per_bulan) / (1 - pow(1 + $bunga_per_bulan, -$jangka)),
                    (string) $kec->pembulatan
                );

                $sisa_pokok = $alokasi;

                for ($j = $index; $j <= $jumlah_angsuran; $j++) {
                    $jasa  = Keuangan::pembulatan($sisa_pokok * $bunga_per_bulan, (string) $kec->pembulatan);
                    $pokok = $angsuran_total - $jasa;

                    if ($j == $jumlah_angsuran) {
                        $pokok          = $sisa_pokok;
                        $angsuran_total = $pokok + $jasa;
                    }

                    $ra[$j]['pokok'] = $pokok;
                    $ra[$j]['jasa']  = $jasa;

                    $sisa_pokok -= $pokok;
                }
            } else {
                // --- Flat / Efektif ---

                // Hitung jasa per periode
                for ($j = $index; $j <= $jumlah_angsuran; $j++) {
                    $sisa_j     = $j % $sistem_jasa;
                    $ke_j       = $j / $sistem_jasa;
                    $alokasi_j  = Keuangan::pembulatan($alokasi_pokok_temp * ($pros_jasa / 100));
                    $wajib_jasa = $alokasi_j / $tempo_jasa;

                    if ($kec->pembulatan != '5000') {
                        $wajib_jasa = Keuangan::pembulatan($wajib_jasa, (string) $kec->pembulatan);
                    }

                    if ($sisa_j == 0 && $ke_j != $tempo_jasa && ($sum_angsuran_jasa + $wajib_jasa) < $alokasi_j) {
                        $angsuran_jasa = $wajib_jasa;
                    } elseif ($sisa_j == 0 && ($ke_j == $tempo_jasa || ($sum_angsuran_jasa + $wajib_jasa) >= $alokasi_j)) {
                        $angsuran_jasa = $alokasi_j - $sum_angsuran_jasa;
                    } else {
                        $angsuran_jasa = 0;
                    }

                    $sum_angsuran_jasa   += $angsuran_jasa;
                    $ra[$j]['jasa']       = $angsuran_jasa;
                }

                // Hitung pokok per periode
                $sum_angsuran_pokok = 0;

                for ($i = $index; $i <= $jumlah_angsuran; $i++) {
                    $sisa_i    = $i % $sistem_pokok;
                    $ke_i      = $i / $sistem_pokok;
                    $wajib_pok = Keuangan::pembulatan($alokasi / $tempo_pokok, (string) $kec->pembulatan);

                    if ($sisa_i == 0 && $ke_i != $tempo_pokok && ($sum_angsuran_pokok + $wajib_pok) < $alokasi) {
                        $angsuran_pokok = $wajib_pok;
                    } elseif ($sisa_i == 0 && ($ke_i == $tempo_pokok || ($sum_angsuran_pokok + $wajib_pok) >= $alokasi)) {
                        $angsuran_pokok = $alokasi - $sum_angsuran_pokok;
                    } else {
                        $angsuran_pokok = 0;
                    }

                    $sum_angsuran_pokok += $angsuran_pokok;
                    $ra[$i]['pokok']     = $angsuran_pokok;
                }
            }

            $ra['alokasi'] = $alokasi;

            // ----------------------------------------------------------------
            // Bangun data_rencana (schedule per tanggal jatuh tempo)
            // ----------------------------------------------------------------
            $target_pokok = 0;
            $target_jasa  = 0;
            $data_rencana = [];

            // Baris ke-0 (tanggal cair, angsuran_ke = 0, wajib = 0)
            if ($index == 1) {
                $row0 = [
                    'loan_id'       => $pinj->id,
                    'angsuran_ke'   => 0,
                    'jatuh_tempo'   => $simpan_tgl,
                    'wajib_pokok'   => 0,
                    'wajib_jasa'    => 0,
                    'target_pokok'  => $target_pokok,
                    'target_jasa'   => $target_jasa,
                    'lu'            => date('Y-m-d H:i:s'),
                    'id_user'       => 1,
                ];
                $data_rencana[strtotime($tgl_cair)] = $row0;
                $rencana[] = $row0;
            }

            for ($x = $index; $x <= $jumlah_angsuran; $x++) {
                if ($sa_pokok == 12 || $sa_pokok == 25) {
                    // Mingguan
                    $jatuh_tempo = Carbon::parse($tgl_cair)->addDays($x * 7)->toDateString();
                } else {
                    // Bulanan
                    $jatuh_tempo = Carbon::parse($tgl_cair)->addMonthsNoOverflow($x)->toDateString();
                }

                $pokok = $ra[$x]['pokok'];
                $jasa  = $ra[$x]['jasa'];

                $target_pokok += $pokok;
                $target_jasa  += $jasa;

                $row = [
                    'loan_id'      => $pinj->id,
                    'angsuran_ke'  => $x,
                    'jatuh_tempo'  => $jatuh_tempo,
                    'wajib_pokok'  => $pokok,
                    'wajib_jasa'   => $jasa,
                    'target_pokok' => $target_pokok,
                    'target_jasa'  => $target_jasa,
                    'lu'           => date('Y-m-d H:i:s'),
                    'id_user'      => 1,
                ];

                $data_rencana[strtotime($jatuh_tempo)] = $row;
                $rencana[] = $row;
            }

            // ----------------------------------------------------------------
            // Bangun data_real dari transaksi yang sudah ada
            // COA koperasi: prefix rekening disesuaikan dengan jenis_pp
            // ----------------------------------------------------------------
            $alokasi_pokok = $alokasi;
            $alokasi_jasa  = $target_jasa;

            $data_idtp = [];
            $sum_pokok = 0;
            $sum_jasa  = 0;

            ksort($data_rencana);

            foreach ($pinj->trx as $trx) {
                // Skip transaksi denda — COA koperasi: 4.1.02.01 (Anggota) / 4.2.02.01 (Non-Anggota)
                if (Keuangan::startWith($trx->rekening_kredit, $rek['denda'])) continue;
                if (in_array($trx->idtp, $data_idtp)) continue;

                $tgl_transaksi   = $trx->tgl_transaksi;
                $realisasi_pokok = 0;
                $realisasi_jasa  = 0;

                foreach ($trx->tr_idtp as $idtp) {
                    // Filter hanya transaksi milik pinjaman ini
                    if ($is_pinkel) {
                        if ($idtp->id_pinj   != $pinj->id) continue;
                    } else {
                        if ($idtp->id_pinj_i != $pinj->id) continue;
                    }

                    // --------------------------------------------------------
                    // Deteksi pokok: rekening_kredit = 1.1.03.01 (Anggota)
                    //                               atau 1.1.03.02 (Non-Anggota)
                    // --------------------------------------------------------
                    if (Keuangan::startWith($idtp->rekening_kredit, $rek['pokok'])) {
                        $realisasi_pokok  = intval($idtp->jumlah);
                        $sum_pokok       += $realisasi_pokok;
                        $alokasi_pokok   -= $realisasi_pokok;
                    }

                    // --------------------------------------------------------
                    // Deteksi jasa: rekening_kredit = 4.1.01.01 (Anggota)
                    //                             atau 4.2.01.01 (Non-Anggota)
                    // --------------------------------------------------------
                    if (Keuangan::startWith($idtp->rekening_kredit, $rek['jasa'])) {
                        $realisasi_jasa  = intval($idtp->jumlah);
                        $sum_jasa       += $realisasi_jasa;
                        $alokasi_jasa   -= $realisasi_jasa;
                    }
                }

                // Cari rencana angsuran yang relevan untuk transaksi ini
                $ra_aktif      = [];
                $time_transaksi = strtotime($tgl_transaksi);

                foreach ($data_rencana as $key => $value) {
                    if ($key <= $time_transaksi) {
                        $ra_aktif = $value;
                    }
                }

                $tp = $ra_aktif ? $ra_aktif['target_pokok'] : 0;
                $tj = $ra_aktif ? $ra_aktif['target_jasa']  : 0;

                $tunggakan_pokok = max(0, $tp - $sum_pokok);
                $tunggakan_jasa  = max(0, $tj - $sum_jasa);

                $real[$trx->idtp] = [
                    'id'              => $trx->idtp,
                    'loan_id'         => $pinj->id,
                    'tgl_transaksi'   => $tgl_transaksi,
                    'realisasi_pokok' => $realisasi_pokok,
                    'realisasi_jasa'  => $realisasi_jasa,
                    'sum_pokok'       => $sum_pokok,
                    'sum_jasa'        => $sum_jasa,
                    'saldo_pokok'     => $alokasi_pokok,
                    'saldo_jasa'      => $alokasi_jasa,
                    'tunggakan_pokok' => $tunggakan_pokok,
                    'tunggakan_jasa'  => $tunggakan_jasa,
                    'lu'              => date('Y-m-d H:i:s'),
                    'id_user'         => 1,
                ];

                $data_id_real[] = $trx->idtp;
                $data_idtp[]    = $trx->idtp;
            }
        } // end foreach pinjaman

        // ------------------------------------------------------------------
        // Simpan ke database — hapus lama, insert baru
        // ------------------------------------------------------------------
        if ($is_pinkel) {
            RencanaAngsuran::whereIn('loan_id', $data_id_pinj)->delete();
            RealAngsuran::whereIn('loan_id', $data_id_pinj)->delete();

            if (!empty($rencana)) RencanaAngsuran::insert($rencana);
            if (!empty($real))    RealAngsuran::insert($real);
        } else {
            RencanaAngsuranI::whereIn('loan_id', $data_id_pinj)->delete();
            RealAngsuranI::whereIn('loan_id', $data_id_pinj)->delete();

            if (!empty($rencana)) RencanaAngsuranI::insert($rencana);
            if (!empty($real))    RealAngsuranI::insert($real);
        }

        // Kembalikan JSON — AJAX di index.blade.php yang menangani looping batch
        // { count: N } → jika N >= limit, JS akan kirim batch berikutnya
        return response()->json([
            'count'   => count($data_id_pinj),
            'offset'  => $offset + $limit,
            'ids'     => $data_id_pinj,
        ]);
    }
}

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
use Illuminate\Http\Request;
use Session;
use URL;

class GenerateController extends Controller
{
    private const ID_KEC = 1;
    public function index()
    {
        // Handle URL lokal
        if (request()->server('SERVER_NAME') === '127.0.0.1' || request()->server('SERVER_NAME') === 'localhost') {
                    $kec = Kecamatan::where('id', self::ID_KEC)->with('kabupaten')->first();
                    //$pus = Rekap::where('id', 1)->first();return redirect('/rekap');
        } else {
            $kec = Kecamatan::where('web_kec', explode('//', request()->url(''))[1])
                ->orWhere('web_alternatif', explode('//', request()->url(''))[1])
                ->first();
        }

        Session::put('lokasi', $kec->id);

        $logo = '/assets/img/icon/favicon.png';
        if ($kec->logo) {
            $logo = '/storage/logo/' . $kec->logo;
        }

        return view('generate.index')->with(compact('logo'));
    }

    public function individu()
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $database = env('DB_DATABASE', 'siupk_lkm');
        $table = 'pinjaman_anggota_' . Session::get('lokasi');

        $strukturTabel = \DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA='$database'
            ORDER BY ORDINAL_POSITION;
        ");

        $struktur = array_map(function ($kolom) {
            return $kolom->COLUMN_NAME;
        }, $strukturTabel);

        return response()->json([
            'view' => view('generate.partials.individu')->with(compact('struktur', 'kec'))->render()
        ]);
    }

    public function kelompok()
    {
        $database = env('DB_DATABASE', 'siupk_lkm');
        $table = 'pinjaman_kelompok_' . Session::get('lokasi');

        $strukturTabel = \DB::select("
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '$table' AND TABLE_SCHEMA='$database'
            ORDER BY ORDINAL_POSITION;
        ");

        $struktur = array_map(function ($kolom) {
            return $kolom->COLUMN_NAME;
        }, $strukturTabel);

        return response()->json([
            'view' => view('generate.partials.kelompok')->with(compact('struktur'))->render()
        ]);
    }

    public function generate(Request $request, $offset = 0)
    {
        $real = [];
        $rencana = [];
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();

        $where = [];
        $whereIn = [];
        $whereNotIn = [];
        foreach ($request->all() as $key => $val) {
            if ($key == '_token' || $key == 'pinjaman') continue;

            $opt = '=';
            $value = $val;
            if (is_array($val)) {
                $opt = $val['operator'];
                $value = $val['value'];
                if (!$value) continue;

                $values = explode(',', $value);
                if ($opt == 'IN') {
                    $whereIn[$key] = $values;
                    continue;
                }

                if ($opt == 'NOT IN') {
                    $whereNotIn[$key] = $values;
                    continue;
                }
            }

            $where[] = [$key, $opt, $value];
        }

        $limit = 30;
        $pinjaman = PinjamanIndividu::where($where)->with([
            'sis_pokok',
            'sis_jasa',
            'trx' => function ($query) {
                $query->where('idtp', '!=', '0');
            },
            'trx.tr_idtp',
            'anggota',
            'anggota.d'
        ]);

        foreach ($whereIn as $key => $value) {
            $pinjaman = $pinjaman->whereIn($key, $value);
        }

        foreach ($whereNotIn as $key => $value) {
            $pinjaman = $pinjaman->whereNotIn($key, $value);
        }

        $pinjaman = $pinjaman->limit($limit)->offset($offset)->orderBy('id', 'ASC')->get();

        $data_id_pinj = [];
        $data_id_real = [];
        
        foreach ($pinjaman as $pinkel) {
            $data_id_pinj[] = $pinkel->id;

            if ($pinkel->status == 'P') {
                $alokasi = $pinkel->proposal;
                $tgl_cair = $pinkel->tgl_proposal;
            } elseif ($pinkel->status == 'V') {
                $alokasi = $pinkel->verifikasi;
                $tgl_cair = $pinkel->tgl_verifikasi;
            } else {
                $alokasi = $pinkel->alokasi;
                $tgl_cair = $pinkel->tgl_cair != "0000-00-00" ? $pinkel->tgl_cair : $pinkel->tgl_tunggu;
            }

            $jenis_jasa = $pinkel->jenis_jasa;
            $jangka = $pinkel->jangka;
            $sa_pokok = $pinkel->sistem_angsuran;
            $sa_jasa = $pinkel->sa_jasa;
            $pros_jasa = $pinkel->pros_jasa;

            $index = 1;
            $jumlah_angsuran = $jangka + 1;
            if ($kec->jdwl_angsuran == '1') {
                $index = 0;
                $jumlah_angsuran = $jangka;
            }

            $simpan_tgl = $tgl_cair;
            $desa = $pinkel->anggota->d ?? null;

            $tanggal_cair = date('d', strtotime($tgl_cair));
            if ($desa && $desa->jadwal_angsuran_desa > 0) {
                $tgl_pinjaman = date('Y-m', strtotime($tgl_cair));
                $tgl_cair = $tgl_pinjaman . '-' . $desa->jadwal_angsuran_desa;
            }

            if ($kec->batas_angsuran > 0 && $tanggal_cair >= $kec->batas_angsuran) {
                $tgl_cair = date('Y-m-d', strtotime('+1 month', strtotime($tgl_cair)));
            }

            $sistem_pokok = $pinkel->sis_pokok->sistem ?? 1;
            $sistem_jasa = $pinkel->sis_jasa->sistem ?? 1;

            $tempo_pokok = floor($jangka / $sistem_pokok);
            if ($sa_pokok == 11) $tempo_pokok = ($jangka - 24) / $sistem_pokok;
            elseif ($sa_pokok == 14) $tempo_pokok = ($jangka - 3) / $sistem_pokok;
            elseif ($sa_pokok == 15) $tempo_pokok = ($jangka - 2) / $sistem_pokok;
            elseif ($sa_pokok == 20) $tempo_pokok = ($jangka - 12) / $sistem_pokok;

            $tempo_jasa = floor($jangka / $sistem_jasa);
            if ($sa_jasa == 11) $tempo_jasa = ($jangka - 24) / $sistem_jasa;
            elseif ($sa_jasa == 14) $tempo_jasa = ($jangka - 3) / $sistem_jasa;
            elseif ($sa_jasa == 15) $tempo_jasa = ($jangka - 2) / $sistem_jasa;
            elseif ($sa_jasa == 20) $tempo_jasa = ($jangka - 12) / $sistem_jasa;

            $alokasi_pokok = $alokasi;
            $ra = [];

            for ($i = $index; $i < $jumlah_angsuran; $i++) {
                $ke = $i / $sistem_pokok;
                $sisa = $i % $sistem_pokok;

                $wajib_pokok = Keuangan::pembulatan($alokasi / $tempo_pokok, (string) $kec->pembulatan);
                $sum_pokok = $wajib_pokok * ($tempo_pokok - 1);

                $ra[$i]['pokok'] = ($sisa == 0 && $ke == $tempo_pokok) ? $alokasi - $sum_pokok : ($sisa == 0 ? $wajib_pokok : 0);
            }
            if (!is_numeric($alokasi_pokok) || !is_numeric($pros_jasa)) {
                dd([
                    'loan_id' => $pinkel->id,
                    'alokasi_pokok' => $alokasi_pokok,
                    'pros_jasa' => $pros_jasa,
                    'status' => $pinkel->status,
                    'tgl_cair' => $pinkel->tgl_cair ?? $pinkel->tgl_tunggu,
                ]);
            }

            $alokasi_jasa = $alokasi_pokok * ($pros_jasa / 100);
            for ($j = $index; $j < $jumlah_angsuran; $j++) {
                $ke = $j / $sistem_jasa;
                $sisa = $j % $sistem_jasa;

                $wajib_jasa = Keuangan::pembulatan($alokasi_jasa / $tempo_jasa, (string) $kec->pembulatan);
                $sum_jasa = $wajib_jasa * ($tempo_jasa - 1);

                $ra[$j]['jasa'] = ($sisa == 0 && $ke == $tempo_jasa) ? $alokasi_jasa - $sum_jasa : ($sisa == 0 ? $wajib_jasa : 0);
            }

            $ra['alokasi'] = $alokasi;
            $target_pokok = $target_jasa = 0;
            $data_rencana = [];

            if ($index == 1) {
                $data_rencana[strtotime($tgl_cair)] = [
                    'loan_id' => $pinkel->id,
                    'angsuran_ke' => 0,
                    'jatuh_tempo' => $simpan_tgl,
                    'wajib_pokok' => 0,
                    'wajib_jasa' => 0,
                    'target_pokok' => $target_pokok,
                    'target_jasa' => $target_jasa,
                    'lu' => now(),
                    'id_user' => 1
                ];
                $rencana[] = $data_rencana[strtotime($tgl_cair)];
            }

            for ($x = $index; $x < $jumlah_angsuran; $x++) {
                $penambahan = ($sa_pokok == 12) ? "+".($x * 7)." days" : "+$x month";
                $bulan_jatuh_tempo = date('Y-m-d', strtotime($penambahan, strtotime($tgl_cair)));
                $jatuh_tempo = date('Y-m-t', strtotime($bulan_jatuh_tempo));
                if (date('d', strtotime($tgl_cair)) < date('d', strtotime($jatuh_tempo))) {
                    $jatuh_tempo = date('Y-m', strtotime($bulan_jatuh_tempo)) . '-' . date('d', strtotime($tgl_cair));
                }

                $pokok = $ra[$x]['pokok'];
                $jasa = $ra[$x]['jasa'];

                $target_pokok += $pokok;
                $target_jasa += $jasa;

                $data_rencana[strtotime($jatuh_tempo)] = [
                    'loan_id' => $pinkel->id,
                    'angsuran_ke' => $x,
                    'jatuh_tempo' => $jatuh_tempo,
                    'wajib_pokok' => $pokok,
                    'wajib_jasa' => $jasa,
                    'target_pokok' => $target_pokok,
                    'target_jasa' => $target_jasa,
                    'lu' => now(),
                    'id_user' => 1
                ];
                $rencana[] = $data_rencana[strtotime($jatuh_tempo)];
            }

            ksort($data_rencana);
            $data_idtp = [];
            $sum_pokok = $sum_jasa = 0;

            foreach ($pinkel->trx as $trx) {
                $poko_kredit = '1.1.03';
                $jasa_kredit = '4.1.01';
                $dend_kredit = '4.1.02';

                if (Keuangan::startWith($trx->rekening_kredit, $dend_kredit)) continue;
                if (in_array($trx->idtp, $data_idtp)) continue;

                $tgl_transaksi = $trx->tgl_transaksi;
                $realisasi_pokok = $realisasi_jasa = 0;

                foreach ($trx->tr_idtp as $idtp) {
                    if ($idtp->id_pinj_i != $pinkel->id) continue;

                    if (Keuangan::startWith($idtp->rekening_kredit, $poko_kredit)) {
                        $realisasi_pokok = intval($idtp->jumlah);
                        $sum_pokok += $realisasi_pokok;
                        $alokasi_pokok -= $realisasi_pokok;
                    }

                    if (Keuangan::startWith($idtp->rekening_kredit, $jasa_kredit)) {
                        $realisasi_jasa = intval($idtp->jumlah);
                        $sum_jasa += $realisasi_jasa;
                        $alokasi_jasa -= $realisasi_jasa;
                    }
                }

                $ra = [];
                $time_transaksi = strtotime($tgl_transaksi);
                foreach ($data_rencana as $key => $value) {
                    if ($key <= $time_transaksi) {
                        $ra = $value;
                    }
                }
                if (!isset($ra['target_pokok'])) {
                    dd([
                        'ra' => $ra,
                        'idtp' => $trx->idtp,
                        'loan_id' => $pinkel->id,
                        'tgl_transaksi' => $tgl_transaksi,
                        'available_keys' => array_keys($ra),
                    ]);
                }

                $tunggakan_pokok = max(0, $ra['target_pokok'] - $sum_pokok);
                $tunggakan_jasa = max(0, $ra['target_jasa'] - $sum_jasa);

                $real[$trx->idtp] = [
                    'id' => $trx->idtp,
                    'loan_id' => $pinkel->id,
                    'tgl_transaksi' => $tgl_transaksi,
                    'realisasi_pokok' => $realisasi_pokok,
                    'realisasi_jasa' => $realisasi_jasa,
                    'sum_pokok' => $sum_pokok,
                    'sum_jasa' => $sum_jasa,
                    'saldo_pokok' => $alokasi_pokok,
                    'saldo_jasa' => $alokasi_jasa,
                    'tunggakan_pokok' => $tunggakan_pokok,
                    'tunggakan_jasa' => $tunggakan_jasa,
                    'lu' => now(),
                    'id_user' => 1,
                ];

                $data_id_real[] = $trx->idtp;
                $data_idtp[] = $trx->idtp;
            }
        }


        RencanaAngsuranI::whereIn('loan_id', $data_id_pinj)->delete();
        RealAngsuranI::whereIn('loan_id', $data_id_pinj)->delete();

        RencanaAngsuranI::insert($rencana);
        RealAngsuranI::insert($real);

        $data = $request->all();
        $offset += $limit;

        return view('generate.generate')->with(compact('data_id_pinj', 'data', 'offset', 'limit'));
    }

}

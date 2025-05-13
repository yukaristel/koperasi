<?php

namespace App\Http\Controllers\Rekap;

use App\Http\Controllers\Controller;
use App\Models\JenisLaporan;
use App\Models\Rekap;
use App\Models\Kecamatan;
use App\Models\Rekening;
use App\Models\Wilayah;
use App\Utils\Keuangan;
use Illuminate\Http\Request;
use Session;

class RekapController extends Controller
{
    public function index()
    {
        $keuangan = new Keuangan;
        $tahun = date('Y');
        $bulan = date('m');

        $id = Session::get('id_rekap');
        $saldo_kec = [];
                        $rekap = Rekap::where('id', $id)->first();
                        
                        $lokasiIds = array_filter(explode(',', $rekap->lokasi));
                        $kdKecList = Kecamatan::whereIn('id', $lokasiIds)->pluck('kd_kec');
                        $kecamatan = Kecamatan::whereIn('kd_kec', $kdKecList)
                                        ->select('id', 'kd_kec as kode', 'nama_kec as nama')
                                        ->orderBy('nama_kec', 'ASC')
                                        ->get();

        foreach ($kecamatan as $wl) {
            $saldo_kec[$wl->kode] = [
                'nama' => $wl->nama,
                'kode' => $wl->kode,
                'laba_rugi' => [
                    'pendapatan' => 0,
                    'biaya' => 0,
                ],
                'surplus' => 0,
                'used_dbm' => false
            ];
            if ($wl->kec) {
                Session::put('lokasi', $wl->kec->id);
                $laba_rugi = Rekening::where('lev1', '>=', '4')->with([
                    'kom_saldo' => function ($query) use ($tahun, $bulan) {
                        $query->where('tahun', $tahun)->where(function ($query) use ($bulan) {
                            $query->where('bulan', '0')->orwhere('bulan', $bulan);
                        });
                    },
                    'saldo' => function ($query) use ($tahun, $bulan) {
                        $query->where([
                            ['tahun', $tahun],
                            ['bulan', ($bulan - 1)]
                        ]);
                    }
                ])->orderBy('kode_akun', 'ASC')->get();

                $pendapatan = 0;
                $biaya = 0;
                foreach ($laba_rugi as $lb) {
                    $saldo = $keuangan->komSaldo($lb);
                    if ($lb->lev1 == 5) {
                        $biaya += $saldo;
                    } else {
                        $pendapatan += $saldo;
                    }
                }

                $saldo_kec[$wl->kode]['laba_rugi'] = [
                    'pendapatan' => $pendapatan,
                    'biaya' => $biaya,
                ];

                $saldo_kec[$wl->kode]['surplus'] = $pendapatan - $biaya;
                $saldo_kec[$wl->kode]['used_dbm'] = true;
            }
        }
        $title = Session::get('nama_rekap') . ' Page';
        return view('rekap.index')->with(compact('title', 'saldo_kec', 'keuangan'));
    }

    public function tandaTangan()
    {
        $kd_rekap = Session::get('kd_rekap');
        $rekap = Rekap::where('kd_rekap', $kd_rekap)->first();

        $title = 'Pengaturan Tanda Tangan Laporan';
        return view('rekap.tanda_tangan')->with(compact('title', 'rekap'));
    }

    public function simpanTandaTangan(Request $request)
    {
        $data = $request->only([
            'tanda_tangan'
        ]);

        $data['tanda_tangan'] = preg_replace('/<table[^>]*>/', '<table class="p0" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">', $data['tanda_tangan'], 1);
        $data['tanda_tangan'] = preg_replace('/height:\s*[^;]+;?/', '', $data['tanda_tangan']);

        $data['tanda_tangan'] = str_replace('colgroup', 'tr', $data['tanda_tangan']);
        $data['tanda_tangan'] = preg_replace('/<col([^>]*)>/', '<td$1>&nbsp;</td>', $data['tanda_tangan']);

        $kd_rekap = Session::get('kd_rekap');
        $tanda_tangan = Rekap::where('kd_rekap', $kd_rekap)->update([
            'tanda_tangan' => json_encode($data['tanda_tangan'])
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Tanda Tangan Berhasil diperbarui'
        ]);
    }

    public function kecamatan($kd_kec)
    {

        $kec = Kecamatan::where('kd_kec', $kd_kec)->with('kabupaten')->first();
        $laporan = JenisLaporan::where('file', '!=', '0')->orderBy('urut', 'ASC')->get();

        if (!$kec) {
            $kec = Wilayah::where('kode', $kd_kec)->first();

            $title = 'Kecamatan Belum Terdaftar';
            return view('rekap._kecamatan')->with(compact('title', 'kec'));
        }
        
        $kab = $kec->kabupaten;
        $nama_kec = $kec->sebutan_kec . ' ' . $kec->nama_kec;
        if (Keuangan::startWith($kab->nama_kab, 'KOTA') || Keuangan::startWith($kab->nama_kab, 'KAB')) {
            $nama_kec .= ' ' . ucwords(strtolower($kab->nama_kab));
        } else {
            $nama_kec .= ' Kabupaten ' . ucwords(strtolower($kab->nama_kab));
        }

        Session::put('lokasi', $kec->id);
        $title = 'Pelaporan ' . $kec->sebutan_kec . ' ' . $kec->nama_kec;
        return view('rekap.kecamatan')->with(compact('title', 'kec', 'laporan', 'nama_kec'));
    }
    public function laporan()
    {
        $id = Session::get('id_rekap');
        $rekap = Rekap::where('id', $id)->first();
        $title = 'Laporan Rekap';
        $laporan = collect([
            (object)[
                'id' => 1,
                'urut' => 1,
                'nama_laporan' => 'Neraca',
                'file' => 'rekap_neraca',
                'awal_tahun' => 0,
            ],
            (object)[
                'id' => 2,
                'urut' => 2,
                'nama_laporan' => 'Rugi Laba',
                'file' => 'rekap_rb',
                'awal_tahun' => 0,
            ],
        ]);
        
        return view('rekap.laporan')->with(compact('title', 'rekap', 'laporan'));
    }

}

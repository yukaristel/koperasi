<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Keluarga;
use App\Models\RealSimpanan;
use App\Models\RealAngsuranI;
use App\Models\PinjamanAnggota;
use App\Models\PinjamanIndividu;
use App\Models\StatusPinjaman;
use App\Models\Simpanan;
use App\Models\JenisKegiatan;
use App\Models\Usaha;
use App\Utils\Tanggal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Session;
use Yajra\DataTables\DataTables;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $penduduk = Anggota::query()->with([
                'd',
                'd.sebutan_desa',
                'pinjaman' => function ($query) {
                    $query->orderBy('id', 'DESC');
                },
                'pinjaman.sts'
            ])->get();

            return DataTables::of($penduduk)
                ->addColumn('status', function ($row) {
                    $pinjaman = $row->pinjaman;

                    $status = '<span class="badge bg-secondary">n</span>';
                    if ($row->pinjaman) {
                        $status_pinjaman = $pinjaman->status;

                        if ($pinjaman->sts) {
                            $badge = $pinjaman->sts->warna_status;
                            $status = '<span class="badge bg-' . $badge . '">' . $status_pinjaman . '</span>';
                        }
                    }

                    return $status;
                })
                ->editColumn('alamat', function ($row) {
                    return $row->alamat . ' ' . $row->d->sebutan_desa->sebutan_desa . ' ' . $row->d->nama_desa;
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $status_pinjaman = StatusPinjaman::all();

        $title = 'Daftar Penduduk';
        return view('penduduk.index')->with(compact('title', 'status_pinjaman'));
    }

    public function register()
    {
        $title = 'Register Penduduk';
        return view('penduduk.register')->with(compact('title'));
    }

    public function loadForm($nik)
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $tgl = $kec->tgl_anggota;
        $anggota = Anggota::where('nik', $nik)->first();
        $desa = Desa::where('kd_kec', $kec->kd_kec)->get();
        $simpanan_anggota = null;
        $simpanan = null;
        $pinjaman = null;
        $status = 'N'; // default
        $disabled = ''; 

        if ($anggota) {
            $simpanan_anggota = Simpanan::where('nia', $anggota->id)
                ->where('jenis_simpanan', '2')
                ->with(['realSimpananTerbesar'])
                ->first();

            $simpanan = Simpanan::where('nia', $anggota->id)
                ->whereNotIn('jenis_simpanan', [1, 2])
                ->with(['realSimpananTerbesar','js','sts'])
                ->get();

            $pinjaman = PinjamanIndividu::where('nia', $anggota->id)->with([
                'anggota',
                'jpp',
                'sis_pokok',
                'saldo',
                'sts',
            ])->withCount('real_i')->get();

            if ($anggota->status == 0) {
                $status = 'B'; // Blacklist
                $disabled = 'readonly'; 
            }
            if ($simpanan_anggota) {
                $status = 'A'; // Aktif
            }

        }

        $jenis_kegiatan = JenisKegiatan::with('usaha')->get();

        return response()->json([
            'html_kiri' => view('penduduk.partial._isi_kiri', compact('anggota','disabled','desa','jenis_kegiatan','nik'))->render(),
            'html_kanan' => view('penduduk.partial._isi_kanan', compact('anggota', 'simpanan_anggota', 'simpanan', 'pinjaman', 'status', 'tgl', 'disabled','desa'))->render(),
        ]);
    }

    public function cariNik()
    {
        $nik = request()->get('nik');
        $anggota = Anggota::where('nik', $nik)->first();

        $anggota->tgl_lahir = Tanggal::tglIndo($anggota->tgl_lahir);
        return response()->json($anggota);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $desa = Desa::where('kd_kec', 'LIKE', $kec->kd_kab . '%')->with('sebutan_desa')->get();
        $jenis_usaha = Usaha::orderBy('nama_usaha', 'ASC')->get();
        $hubungan = Keluarga::orderBy('id', 'ASC')->get();

        $desa_dipilih = 0;
        $jenis_usaha_dipilih = 0;
        $hubungan_dipilih = 0;
        $jk_dipilih = 0;

        $nik = '';
        $value_tanggal = '';
        if (request()->get('nik')) {
            $anggota = Anggota::where('nik', request()->get('nik'));
            if ($anggota->count() > 0) {
                $data_anggota = $anggota->first();

                $desa_dipilih = $data_anggota->desa;
                $jenis_usaha_dipilih = $data_anggota->usaha;
                $hubungan_dipilih = $data_anggota->hubungan;
                $jk_dipilih = $data_anggota->jk;

                $data_anggota->tgl_lahir = Tanggal::tglIndo($data_anggota->tgl_lahir);
                return view('penduduk.edit')->with(compact('desa_dipilih', 'desa', 'jenis_usaha', 'jenis_usaha_dipilih', 'hubungan', 'hubungan_dipilih', 'jk_dipilih', 'data_anggota'));
            }

            $nik = request()->get('nik');
            $kk = substr($nik, 0, 6);
            $tanggal = substr($nik, 6, 2);
            $bulan = substr($nik, 8, 2);
            $tahun = substr($nik, 10, 2);
            if ($tanggal >= 40) {
                $tgl = $tanggal - 40;
                $jk_dipilih = 'P';
            } else {
                $tgl = $tanggal;
                $jk_dipilih = 'L';
            }
        }

        return view('penduduk.create')->with(compact('desa_dipilih', 'desa', 'jenis_usaha', 'jenis_usaha_dipilih', 'hubungan', 'hubungan_dipilih', 'nik', 'jk_dipilih', 'value_tanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        $data = $request->only([
            'nik',
            'namadepan',
            'nama_panggilan',
            'jk',
            'tempat_lahir',
            'tgl_lahir',
            'desa',
            'alamat',
            'domisili',
            'hp',
            'jenis_usaha',
            'keterangan_usaha',
            'agama',
            'status_pernikahan',
            'tempat_kerja',
            'pendidikan',
            'no_kk',
            'nama_ibu',
            'nik_penjamin',
            'hubungan_penjamin',
            'nama_penjamin'
        ]);



        $rules = [
            'nik' => 'required|unique:anggota_' . Session::get('lokasi') . ',nik|min:16|max:16',
            'namadepan' => 'required',
            'nama_panggilan' => 'required',
            'desa' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'hp' => 'required',
            'pendidikan' => 'required',
            'alamat' => 'required',
            'domisili' => 'required',
            'no_kk' => 'required',
            'jenis_usaha' => 'required',
            'nik_penjamin' => 'required|max:16',
            'nama_ibu' => 'required',
            'tempat_kerja' => 'required'
        ];

        if (strlen($request->no_kk) >= 16) {
            if ($kec->hak_kredit == 1) {
                $rules['no_kk'] = 'required|unique:anggota_' . Session::get('lokasi') . ',kk';
            }
        }


        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_MOVED_PERMANENTLY);
        }

        $insert = [
            'nik' => $request->nik,
            'namadepan' => $request->namadepan,
            'nama_panggilan' => $request->nama_panggilan,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => Tanggal::tglNasional($request->tgl_lahir),
            'alamat' => $request->alamat,
            'domisi' => $request->domisili,
            'desa' => $request->desa,
            'lokasi' => Session::get('lokasi'),
            'hp' => $request->hp,
            'pendidikan' => $request->pendidikan,
            'kk' => $request->no_kk,
            'nik_penjamin' => $request->nik_penjamin,
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'penjamin' => $request->nama_penjamin,
            'hubungan' => $request->hubungan,
            'nama_ibu' => $request->nama_ibu,
            'tempat_kerja' => $request->tempat_kerja,
            'usaha' => $request->jenis_usaha,
            'foto' => '1',
            'terdaftar' => date('Y-m-d'),
            'status' => '1',
            'petugas' => auth()->user()->id,
        ];

        $penduduk = Anggota::create($insert);
        $nik = $request->nik;
        $tgl = $kec->tgl_anggota;
        $anggota = Anggota::where('nik', $nik)->first();
        $desa = Desa::where('kd_kec', $kec->kd_kec)->get();
        $simpanan_anggota = null;
        $simpanan = null;
        $pinjaman = null;
        $status = 'N'; // default
        $disabled = ''; 

        if ($anggota) {
            $simpanan_anggota = Simpanan::where('nia', $anggota->id)
                ->where('jenis_simpanan', '2')
                ->with(['realSimpananTerbesar'])
                ->first();

            $simpanan = Simpanan::where('nia', $anggota->id)
                ->whereNotIn('jenis_simpanan', [1, 2])
                ->with(['realSimpananTerbesar','js','sts'])
                ->get();

            $pinjaman = PinjamanIndividu::where('nia', $anggota->id)->with([
                'anggota',
                'jpp',
                'sis_pokok',
                'saldo',
                'sts',
            ])->withCount('real_i')->get();

            if ($anggota->status == 0) {
                $status = 'B'; // Blacklist
                $disabled = 'readonly'; 
            }
            if ($simpanan_anggota) {
                $status = 'A'; // Aktif
            }

        }
        
        $jenis_kegiatan = JenisKegiatan::with('usaha')->get();

        return response()->json([
            'html_kiri' => view('penduduk.partial._isi_kiri', compact('anggota','disabled','desa','jenis_kegiatan','nik'))->render(),
            'html_kanan' => view('penduduk.partial._isi_kanan', compact('anggota', 'simpanan_anggota', 'simpanan', 'pinjaman', 'status', 'tgl', 'disabled','desa'))->render(),
            'success' => true,
            'msg' => 'Penduduk dengan nama ' . $insert['namadepan'] . ' berhasil disimpan'
        ], Response::HTTP_ACCEPTED);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Anggota $penduduk)
    {
        $kec = Kecamatan::where('id', Session::get('lokasi'))->first();
        // $desa = Desa::where('kd_kec', $kec->kd_kec)->with('sebutan_desa')->get();
        $desa = Desa::where('kd_kec', 'LIKE', $kec->kd_kab . '%')->with('sebutan_desa')->get();
        $jenis_usaha = Usaha::orderBy('nama_usaha', 'ASC')->get();
        $hubungan = Keluarga::orderBy('id', 'ASC')->get();

        $penduduk = $penduduk->with([
            'pinjaman_anggota',
            'pinjaman_anggota.kelompok',
            'pinjaman_anggota.pinkel',
            'pinjaman_anggota.pinkel.sts',
            'pinjaman_anggota.pinkel.angsuran_pokok',
        ])->where('id', $penduduk->id)->first();

        $desa_dipilih = $penduduk->desa;
        $jenis_usaha_dipilih = $penduduk->usaha;
        $hubungan_dipilih = $penduduk->hubungan;
        $jk_dipilih = $penduduk->jk;
        $penduduk->tgl_lahir = Tanggal::tglIndo($penduduk->tgl_lahir);

        $title = ucwords($penduduk->namadepan);
        return view('penduduk.detail')->with(compact('penduduk', 'title', 'desa_dipilih', 'desa', 'jenis_usaha', 'jenis_usaha_dipilih', 'hubungan', 'hubungan_dipilih', 'jk_dipilih'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $penduduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $penduduk)
    {
        $data = $request->only([
            'nia',
            'nik',
            'namadepan',
            'nama_panggilan',
            'jk',
            'tempat_lahir',
            'tgl_lahir',
            'desa',
            'alamat',
            'domisili',
            'hp',
            'jenis_usaha',
            'keterangan_usaha',
            'tempat_kerja',
            'pendidikan',
            'agama',
            'status_pernikahan',
            'no_kk',
            'nama_ibu',
            'nik_penjamin',
            'hubungan_penjamin',
            'nama_penjamin'
        ]);

        $rules = [
            'namadepan' => 'required',
            'jk' => 'required',
            'desa' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
            'jenis_usaha' => 'required',
            'nik_penjamin' => 'required',
            'nama_penjamin' => 'required',
            'hubungan_penjamin' => 'required',
            'nama_ibu' => 'required'
        ];

        $validate = Validator::make($data, $rules);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        
        $data = $request->only([
            'nia',
            'nik',
            'namadepan',
            'nama_panggilan',
            'jk',
            'tempat_lahir',
            'tgl_lahir',
            'desa',
            'alamat',
            'domisili',
            'hp',
            'jenis_usaha',
            'keterangan_usaha',
            'tempat_kerja',
            'pendidikan',
            'agama',
            'status_pernikahan',
            'no_kk',
            'nama_ibu',
            'nik_penjamin',
            'hubungan_penjamin',
            'nama_penjamin'
        ]);
        $update = [
            'nik' => $request->nik,
            'namadepan' => $request->namadepan,
            'nama_panggilan' => $request->nama_panggilan,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => Tanggal::tglNasional($request->tgl_lahir),
            'alamat' => $request->alamat,
            'domisi' => $request->domisili,
            'desa' => $request->desa,
            'lokasi' => Session::get('lokasi'),
            'hp' => $request->no_telp,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'status_pernikahan' => $request->status_pernikahan,
            'kk' => $request->no_kk,
            'nik_penjamin' => $request->nik_penjamin,
            'penjamin' => $request->nama_penjamin,
            'hubungan' => $request->hubungan_penjamin,
            'nama_ibu' => $request->nama_ibu,
            'tempat_kerja' => $request->tempat_kerja,
            'usaha' => $request->jenis_usaha,
            'keterangan_usaha' => $request->keterangan_usaha,
            'foto' => '1',
            'terdaftar' => date('Y-m-d'),
            'status' => '1',
            'petugas' => auth()->user()->id,
        ];

        $pend = Anggota::where('nik', $request->nik)->update($update);
        return response()->json([
            'success' => true,
            'msg' => 'Penduduk dengan nama ' . $update['namadepan'] . ' berhasil disimpan'
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $penduduk)
    {
        //
    }

    public function blokir(Request $request, Anggota $nik)
    {
        $status = $request->status;
        Anggota::where('id', $nik->id)->update([
            'status' => $status
        ]);

        $msg = 'Penduduk atas nama ' . $nik->namadepan . ' telah diblokir dan tidak akan bisa mengajukan pinjaman lagi';
        if ($status != '0') {
            $msg = 'Penduduk atas nama ' . $nik->namadepan . ' telah dilepas dari blokirannya dan dapat mengajukan pinjaman lagi';
        }

        return response()->json([
            'success' => true,
            'msg' => $msg
        ]);
    }

    public function detailAnggota($id)
    {
        $nia = PinjamanIndividu::where('id', $id)->with([
            'anggota',
            'anggota.d',
            'jpp',
            'sis_pokok',
            'target' => function ($query) {
                $query->where('angsuran_ke', '1');
            }
        ])->firstOrFail();

        return [
            'label' => 'Detail Pemanfaat Atas Nama ' . $nia->anggota->namadepan,
            'view' => view('penduduk.detail_individu')->with(compact('nia'))->render()
        ];
    }
}

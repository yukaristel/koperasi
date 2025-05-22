@php
            $sum_ekuitas    =0;
            $sum_liabilitas =0;
@endphp

@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>NERACA</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="3"></td>
        </tr>
        <tr style="background: #000; color: #fff;">
            <td width="10%">Kode</td>
            <td width="70%">Nama Akun</td>
            <td align="right" width="20%">Saldo</td>
        </tr>
        <tr>
            <td colspan="3" height="1"></td>
        </tr>

        @foreach ($akun1 as $lev1)
            @php
                $sum_akun1 = 0;
            @endphp
            <tr style="background: rgb(74, 74, 74); color: #fff;">
                <td height="20" colspan="3" align="center">
                    <b>{{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}</b>
                </td>
            </tr>
            @foreach ($lev1->akun2 as $lev2)
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td>{{ $lev2->kode_akun }}.</td>
                    <td colspan="2">{{ $lev2->nama_akun }}</td>
                </tr>
                @php
                    $akun3 = DB::table('akun_level_3')->where('parent_id', $lev2->id)->get();
                @endphp

@php
    $warna1 = 'rgba(255, 255, 255)';
    $warna2 = 'rgb(230, 230, 230)';
@endphp

@foreach ($akun3 as $lev3)
    @php

        $lokasi_ids = array_map('trim', explode(',', session('rekapan')));
        $tahun = 2025;
        $bulan = ltrim($bulan, '0');

        $total_saldo = 0;
        $per_lokasi_saldo = [];
    @endphp

    @foreach ($lokasi_ids as $lokasi_id)
        @php
            $kecamatan = DB::table('kecamatan')->where('id', $lokasi_id)->first();

            $nama_tabel_rekening = 'rekening_' . $lokasi_id;
            $nama_tabel_saldo = 'saldo_' . $lokasi_id;

            // Ambil semua rekening child di bawah akun3 ini
            $rekening = DB::table($nama_tabel_rekening)
                ->where('parent_id', $lev3->id)
                ->get();

            if ($rekening->isEmpty()) continue;

            // Cek apakah ada rekening kode_akun == 3.2.02.01
            $ada_akun_labarugi = $rekening->contains(function ($rek) {
                return $rek->kode_akun === '3.2.02.01';
            });

            if ($ada_akun_labarugi) {
                // Hitung laba rugi PERSIS seperti versi lama
                $rekening_surplus = DB::table($nama_tabel_rekening)
                    ->where('lev1', '>=', 4)
                    ->get();

                if ($rekening_surplus->isEmpty()) continue;

                $pendapatan = 0;
                $biaya = 0;

                foreach ($rekening_surplus as $sp) {
                    $saldo_ringkas = DB::table($nama_tabel_saldo)
                        ->where('kode_akun', $sp->kode_akun)
                        ->where('tahun', $tahun)
                        ->whereIn('bulan', [0, $bulan])
                        ->selectRaw('
                            SUM(CASE WHEN bulan = 0 THEN debit ELSE 0 END) as awal_debit,
                            SUM(CASE WHEN bulan = 0 THEN kredit ELSE 0 END) as awal_kredit,
                            SUM(CASE WHEN bulan = ? THEN debit ELSE 0 END) as saldo_debit,
                            SUM(CASE WHEN bulan = ? THEN kredit ELSE 0 END) as saldo_kredit
                        ', [$bulan, $bulan])
                        ->first();

                    $awal_debit = $saldo_ringkas->awal_debit ?? 0;
                    $awal_kredit = $saldo_ringkas->awal_kredit ?? 0;
                    $saldo_debit = $saldo_ringkas->saldo_debit ?? 0;
                    $saldo_kredit = $saldo_ringkas->saldo_kredit ?? 0;

                    if ($sp->lev1 == 5) {
                        $saldo_awal = $awal_debit - $awal_kredit;
                        $biaya += $saldo_awal + ($saldo_debit - $saldo_kredit);
                    } else {
                        $saldo_awal = $awal_kredit - $awal_debit;
                        $pendapatan += $saldo_awal + ($saldo_kredit - $saldo_debit);
                    }
                }

                $saldo = $pendapatan - $biaya;

            } else {
                // Hitung normal
                $kode_rekening = $rekening->pluck('kode_akun');

                $saldo_ringkas = DB::table($nama_tabel_saldo)
                    ->whereIn('kode_akun', $kode_rekening)
                    ->where('tahun', $tahun)
                    ->whereIn('bulan', [0, $bulan])
                    ->selectRaw('
                        SUM(CASE WHEN bulan = 0 THEN debit ELSE 0 END) as awal_debit,
                        SUM(CASE WHEN bulan = 0 THEN kredit ELSE 0 END) as awal_kredit,
                        SUM(CASE WHEN bulan = ? THEN debit ELSE 0 END) as saldo_debit,
                        SUM(CASE WHEN bulan = ? THEN kredit ELSE 0 END) as saldo_kredit
                    ', [$bulan, $bulan])
                    ->first();

                $awal_debit = $saldo_ringkas->awal_debit ?? 0;
                $awal_kredit = $saldo_ringkas->awal_kredit ?? 0;
                $saldo_debit = $saldo_ringkas->saldo_debit ?? 0;
                $saldo_kredit = $saldo_ringkas->saldo_kredit ?? 0;

                if ($lev3->lev1 == 1 || $lev3->lev1 == '5') {
                    $saldo_awal = $awal_debit - $awal_kredit;
                    $saldo = $saldo_awal + ($saldo_debit - $saldo_kredit);
                } else {
                    $saldo_awal = $awal_kredit - $awal_debit;
                    $saldo = $saldo_awal + ($saldo_kredit - $saldo_debit);
                }
            }

            // Simpan saldo per lokasi
            $per_lokasi_saldo[] = (object) [
                'nama_kec' => $kecamatan->nama_kec,
                'saldo' => $saldo,
            ];

            $total_saldo += $saldo;
            $sum_akun1 += $total_saldo;

            if($lev3->lev1 == 2){
                $sum_liabilitas += $total_saldo;
            }
            if($lev3->lev1 == 3){
                $sum_ekuitas += $total_saldo;
            }
        @endphp
    @endforeach

    {{-- Baris akun3 utama --}}
    <tr style="background: {{ $warna2 }};">
        <td>{{ $lev3->kode_akun }}.</td>
        <td>{{ $lev3->nama_akun }}</td>
        @if ($total_saldo < 0)
            <td align="right">({{ number_format(abs($total_saldo),2) }})</td>
        @else
            <td align="right">{{ number_format($total_saldo,2) }}</td>
        @endif
    </tr>

    {{-- Baris per lokasi --}}
    @foreach ($per_lokasi_saldo as $lokasi)
        @php
            $bg = ($loop->iteration % 2 == 1) ? $warna1 : $warna2;
        @endphp
        <tr style="background: {{ $bg }};">
            <td></td>
            <td>{{ $lev3->nama_akun }} di {{ $lokasi->nama_kec }}</td>
            @if ($lokasi->saldo < 0)
                <td align="right">({{ number_format(abs($lokasi->saldo),2) }})</td>
            @else
                <td align="right">{{ number_format($lokasi->saldo,2) }}</td>
            @endif
        </tr>
    @endforeach
@endforeach



            @endforeach
            <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                <td height="15" colspan="2" align="left">
                    <b>Jumlah {{ $lev1->nama_akun }}</b>
                </td>
                <td align="right">{{ number_format($sum_akun1, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" height="1"></td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" style="padding: 0px !important;">
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                    style="font-size: 11px;">
                    <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                        <td height="15" width="80%" align="left">
                            <b>Jumlah Liabilitas + Ekuitas </b>
                        </td>
                        <td align="right" width="20%">{{ number_format($sum_liabilitas+$sum_ekuitas, 2) }}</td>
                    </tr>
                </table>

                <div style="margin-top: 16px;"></div>
                
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                    style="font-size: 11px;">
                    <tr>
                        <td width="50%" align="center">
                            <strong>Diperiksa Oleh : </strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Ardiansyah Asdar STP.MM</u></p>
                            Ketua Dewan Pengawas
                        </td>
                        <td width="50%" align="center">
                            <strong>Dilaporkan Oleh : </strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Basuki</u></p>
                            Manajer
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <p>&nbsp;</p>
                            <strong>Mengetahui/Menyetujui : </strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Eko Susanto</u></p>
                            Ketua Koperasi
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection

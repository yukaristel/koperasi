@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="4" align="center">
                <div style="font-size: 18px;">
                    <b>NERACA</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" height="3"></td>
        </tr>
        <tr style="background: #000; color: #fff;">
            <td width="10%">Kode</td>
            <td width="45%">Nama Akun</td>
            <td align="center" width="15%">Saldo Awal Tahun</td>
            <td align="center" width="15%">Saldo s.d. {{$th}}</td>
        </tr>
        <tr>
            <td colspan="4" height="1"></td>
        </tr>

        @foreach ($akun1 as $lev1)
            @php
                $sum_akun1 = 0;
            @endphp

            <tr style="background: rgb(74, 74, 74); color: #fff;">
                <td height="20" colspan="4" align="center">
                    <b>{{ $lev1->kode_akun }}. {{ $lev1->nama_akun }}</b>
                </td>
            </tr>

            @foreach ($lev1->akun2 as $lev2)
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td>{{ $lev2->kode_akun }}.</td>
                    <td colspan="3">{{ $lev2->nama_akun }}</td>
                </tr>

                @foreach ($lev2->akun3 as $lev3)
                    @php
                        $sum_saldo_awal = 0;
                        $sum_total_saldo = 0;

                        $daftarKecamatan = [];
                        foreach ($kecamatan as $kec) {
                            $saldo_awal = 0;
                            $total_saldo = 0;

                            $kode_akun3 = $lev3->kode_akun;
                            if ($kode_akun3 == '3.2.02.00') {
                                $total_saldo += $laba_rugi[$kec->id];
                            } else {
                                foreach ($akun3[$kec->id][$kode_akun3]->rek as $rek) {
                                    $saldo = $keuangan->getSaldo($rek);
                                    $saldo_awal += $saldo['saldo_awal'];
                                    $total_saldo += $saldo['saldo_berjalan'];
                                }
                            }

                            $daftarKecamatan[$kec->id] = [
                                'nama_akun' => $lev3->nama_akun . ' ' . $kec->nama_kec,
                                'saldo_awal' => $saldo_awal,
                                'total_saldo' => $total_saldo,
                            ];

                            $sum_saldo_awal += $saldo_awal;
                            $sum_total_saldo += $total_saldo;
                        }

                        if ($lev1->lev1 == '1') {
                            $debit += $sum_total_saldo;
                        } else {
                            $kredit += $sum_total_saldo;
                        }

                        $sum_akun1 += $sum_total_saldo;
                    @endphp

                    <tr style="background: rgb(230, 230, 230);">
                        <td>{{ $lev3->kode_akun }}.</td>
                        <td>{{ $lev3->nama_akun }}</td>
                        @if ($sum_saldo_awal < 0)
                            <td align="right">({{ number_format($sum_saldo_awal * -1, 2) }})</td>
                        @else
                            <td align="right">{{ number_format($sum_saldo_awal, 2) }}</td>
                        @endif

                        @if ($sum_total_saldo < 0)
                            <td align="right">({{ number_format($sum_total_saldo * -1, 2) }})</td>
                        @else
                            <td align="right">{{ number_format($sum_total_saldo, 2) }}</td>
                        @endif
                    </tr>

                    @foreach ($daftarKecamatan as $lokasi)
                        <tr>
                            <td></td>
                            <td>{{ $lokasi['nama_akun'] }}</td>
                            @if ($lokasi['saldo_awal'] < 0)
                                <td align="right">({{ number_format($lokasi['saldo_awal'] * -1, 2) }})</td>
                            @else
                                <td align="right">{{ number_format($lokasi['saldo_awal'], 2) }}</td>
                            @endif

                            @if ($lokasi['total_saldo'] < 0)
                                <td align="right">({{ number_format($lokasi['total_saldo'] * -1, 2) }})</td>
                            @else
                                <td align="right">{{ number_format($lokasi['total_saldo'], 2) }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            @endforeach

            <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                <td height="15" colspan="3" align="left">
                    <b>Jumlah {{ $lev1->nama_akun }}</b>
                </td>
                <td align="right">{{ number_format($sum_akun1, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" height="1"></td>
            </tr>
        @endforeach



        <tr>
            <td colspan="4" style="padding: 0px !important;">
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                    <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                        <td height="15" colspan="3" align="left">
                            <b>Jumlah Liabilitas + Ekuitas </b>
                        </td>
                        <td align="right">{{ number_format($kredit, 2) }}</td>
                    </tr>
                </table><br><br><br>
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                    <tr>
                        <td width="50%" align="center">
                            <strong>Diperiksa Oleh:</strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Ardiansyah Asdar STP.MM</u></p>
                            Ketua Dewan Pengawas
                        </td>
                        <td width="50%" align="center">
                            <strong>Dilaporkan Oleh:</strong>
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
                            <strong>Mengetahui/Menyetujui:</strong>
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

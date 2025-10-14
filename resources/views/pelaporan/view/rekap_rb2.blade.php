@extends('pelaporan.layout.base')

@section('content')
    @php
        $total_saldo1 = 0;
        $total_saldo_bulan_lalu1 = 0;

        $total_saldo2 = 0;
        $total_saldo_bulan_lalu2 = 0;
    @endphp

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="4" align="center">
                <div style="font-size: 18px;">
                    <b>LAPORAN LABA RUGI</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" height="5"></td>
        </tr>
        <tr style="background: rgb(232, 232, 232); font-weight: bold; font-size: 12px;">
            <td align="center" width="55%" height="16">Rekening</td>
            <td align="center" width="15%">s.d. {{ $header_lalu }}</td>
            <td align="center" width="15%">{{ $header_sekarang }}</td>
            <td align="center" width="15%">s.d. {{ $header_sekarang }}</td>
        </tr>
        <tr style="background: rgb(200, 200, 200); font-weight: bold; text-transform: uppercase;">
            <td colspan="4" height="14">4. Pendapatan</td>
        </tr>

        @foreach ($laba_rugi[0]['pendapatan'] as $key_pendapatan => $p)
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td colspan="4" height="14">{{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
            </tr>

            @php
                $jumlah_bulan_lalu = 0;
                $jumlah_saldo = 0;
            @endphp
            @foreach ($p['rek'] as $key_rek => $rek)
                @php
                    $bg = 'rgb(230, 230, 230)';
                    if ($loop->iteration % 2 == 0) {
                        $bg = 'rgb(255, 255, 255)';
                    }

                    $sum_bulan_lalu = 0;
                    $sum_saldo = 0;
                    foreach ($kecamatan as $kec) {
                        $pendapatan = $laba_rugi[$kec->id]['pendapatan'][$key_pendapatan]['rek'][$key_rek];
                        $sum_bulan_lalu += $pendapatan['saldo_bln_lalu'];
                        $sum_saldo += $pendapatan['saldo'];
                    }

                    $jumlah_bulan_lalu += $sum_bulan_lalu;
                    $jumlah_saldo += $sum_saldo;

                    $total_saldo_bulan_lalu1 += $sum_bulan_lalu;
                    $total_saldo1 += $sum_saldo;
                @endphp

                <tr style="background: {{ $bg }}">
                    <td align="left">{{ $rek['kode_akun'] }}. {{ $rek['nama_akun'] }}</td>
                    <td align="right">{{ number_format($sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo - $sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo, 2) }}</td>
                </tr>
            @endforeach

            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td align="left" height="14">Jumlah {{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
                <td align="right">{{ number_format($jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo - $jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo, 2) }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4" height="2"></td>
        </tr>
        <tr style="background: rgb(200, 200, 200); font-weight: bold; text-transform: uppercase;">
            <td colspan="4" height="14">5. Beban</td>
        </tr>

        @foreach ($laba_rugi[0]['beban'] as $key_beban => $p)
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td colspan="4" height="14">{{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
            </tr>

            @php
                $jumlah_bulan_lalu = 0;
                $jumlah_saldo = 0;
            @endphp
            @foreach ($p['rek'] as $key_rek => $rek)
                @php
                    $bg = 'rgb(230, 230, 230)';
                    if ($loop->iteration % 2 == 0) {
                        $bg = 'rgb(255, 255, 255)';
                    }

                    $sum_bulan_lalu = 0;
                    $sum_saldo = 0;
                    foreach ($kecamatan as $kec) {
                        $beban = $laba_rugi[$kec->id]['beban'][$key_beban]['rek'][$key_rek];
                        $sum_bulan_lalu += $beban['saldo_bln_lalu'];
                        $sum_saldo += $beban['saldo'];
                    }

                    $jumlah_bulan_lalu += $sum_bulan_lalu;
                    $jumlah_saldo += $sum_saldo;

                    $total_saldo_bulan_lalu1 -= $sum_bulan_lalu;
                    $total_saldo1 -= $sum_saldo;
                @endphp

                <tr style="background: {{ $bg }}">
                    <td align="left">{{ $rek['kode_akun'] }}. {{ $rek['nama_akun'] }}</td>
                    <td align="right">{{ number_format($sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo - $sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo, 2) }}</td>
                </tr>
            @endforeach

            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td align="left" height="14">Jumlah {{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
                <td align="right">{{ number_format($jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo - $jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo, 2) }}</td>
            </tr>
        @endforeach

        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
            <td align="left">A. Laba Rugi OPERASIONAL (Kode Akun 4.1 - 5.1 - 5.2) </td>
            <td align="right">{{ number_format($total_saldo_bulan_lalu1, 2) }}</td>
            <td align="right">{{ number_format($total_saldo1 - $total_saldo_bulan_lalu1, 2) }}</td>
            <td align="right">{{ number_format($total_saldo1, 2) }}</td>
        </tr>

        @foreach ($laba_rugi[0]['pendapatan_non_ops'] as $key_pendapatan_non_ops => $p)
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td colspan="4" height="14">{{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
            </tr>

            @php
                $jumlah_bulan_lalu = 0;
                $jumlah_saldo = 0;
            @endphp
            @foreach ($p['rek'] as $key_rek => $rek)
                @php
                    $bg = 'rgb(230, 230, 230)';
                    if ($loop->iteration % 2 == 0) {
                        $bg = 'rgb(255, 255, 255)';
                    }

                    $sum_bulan_lalu = 0;
                    $sum_saldo = 0;
                    foreach ($kecamatan as $kec) {
                        $pendapatan_non_ops =
                            $laba_rugi[$kec->id]['pendapatan_non_ops'][$key_pendapatan_non_ops]['rek'][$key_rek];
                        $sum_bulan_lalu += $pendapatan_non_ops['saldo_bln_lalu'];
                        $sum_saldo += $pendapatan_non_ops['saldo'];
                    }

                    $jumlah_bulan_lalu += $sum_bulan_lalu;
                    $jumlah_saldo += $sum_saldo;

                    $total_saldo_bulan_lalu2 += $sum_bulan_lalu;
                    $total_saldo2 += $sum_saldo;
                @endphp

                <tr style="background: {{ $bg }}">
                    <td align="left">{{ $rek['kode_akun'] }}. {{ $rek['nama_akun'] }}</td>
                    <td align="right">{{ number_format($sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo - $sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo, 2) }}</td>
                </tr>
            @endforeach

            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td align="left" height="14">Jumlah {{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
                <td align="right">{{ number_format($jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo - $jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo, 2) }}</td>
            </tr>
        @endforeach

        @foreach ($laba_rugi[0]['beban_non_ops'] as $key_beban_non_ops => $p)
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td colspan="4" height="14">{{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
            </tr>

            @php
                $jumlah_bulan_lalu = 0;
                $jumlah_saldo = 0;
            @endphp
            @foreach ($p['rek'] as $key_rek => $rek)
                @php
                    $bg = 'rgb(230, 230, 230)';
                    if ($loop->iteration % 2 == 0) {
                        $bg = 'rgb(255, 255, 255)';
                    }

                    $sum_bulan_lalu = 0;
                    $sum_saldo = 0;
                    foreach ($kecamatan as $kec) {
                        $beban_non_ops = $laba_rugi[$kec->id]['beban_non_ops'][$key_beban_non_ops]['rek'][$key_rek];
                        $sum_bulan_lalu += $beban_non_ops['saldo_bln_lalu'];
                        $sum_saldo += $beban_non_ops['saldo'];
                    }

                    $jumlah_bulan_lalu += $sum_bulan_lalu;
                    $jumlah_saldo += $sum_saldo;

                    $total_saldo_bulan_lalu2 -= $sum_bulan_lalu;
                    $total_saldo2 -= $sum_saldo;
                @endphp

                <tr style="background: {{ $bg }}">
                    <td align="left">{{ $rek['kode_akun'] }}. {{ $rek['nama_akun'] }}</td>
                    <td align="right">{{ number_format($sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo - $sum_bulan_lalu, 2) }}</td>
                    <td align="right">{{ number_format($sum_saldo, 2) }}</td>
                </tr>
            @endforeach

            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td align="left" height="14">Jumlah {{ $p['kode_akun'] }}. {{ $p['nama_akun'] }}</td>
                <td align="right">{{ number_format($jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo - $jumlah_bulan_lalu, 2) }}</td>
                <td align="right">{{ number_format($jumlah_saldo, 2) }}</td>
            </tr>
        @endforeach

        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
            <td align="left">B. Laba Rugi OPERASIONAL (Kode Akun 4.2 - 5.3) </td>
            <td align="right">{{ number_format($total_saldo_bulan_lalu2, 2) }}</td>
            <td align="right">{{ number_format($total_saldo2 - $total_saldo_bulan_lalu2, 2) }}</td>
            <td align="right">{{ number_format($total_saldo2, 2) }}</td>
        </tr>

        <tr>
            <td colspan="4" height="2"></td>
        </tr>

        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
            <td align="left">C. Laba Rugi Sebelum Taksiran Pajak (A + B) </td>
            <td align="right">{{ number_format($total_saldo_bulan_lalu1 + $total_saldo_bulan_lalu2, 2) }}</td>
            <td align="right">
                {{ number_format($total_saldo1 - $total_saldo_bulan_lalu1 + ($total_saldo2 - $total_saldo_bulan_lalu2), 2) }}
            </td>
            <td align="right">{{ number_format($total_saldo1 + $total_saldo2, 2) }}</td>
        </tr>

        <tr>
            <td colspan="4" height="2"></td>
        </tr>

        <tr style="background: rgb(150, 150, 150); font-weight: bold;">
            <td colspan="4" height="14">5.4 Beban Pajak</td>
        </tr>

        @php
            $sum_pph_bulan_lalu = 0;
            $sum_pph = 0;
            foreach ($kecamatan as $kec) {
                $saldo_pph = $pph[$kec->id];
                $sum_pph_bulan_lalu += $saldo_pph['bulan_lalu'];
                $sum_pph += $saldo_pph['sekarang'];
            }
        @endphp

        <tr style="background: rgb(230, 230, 230)">
            <td align="left">5.5.01.01. Taksiran PPh (0.5%) </td>
            <td align="right">{{ number_format($sum_pph_bulan_lalu, 2) }}</td>
            <td align="right">{{ number_format($sum_pph - $sum_pph_bulan_lalu, 2) }}</td>
            <td align="right">{{ number_format($sum_pph, 2) }}</td>
        </tr>

        <tr>
            <td colspan="4" height="2"></td>
        </tr>
        
        <tr>
            <td colspan="4" style="padding: 0px !important;">
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
            <td width="55%" align="left">C. Laba Rugi Setelah Taksiran Pajak (A + B) </td>
            <td width="15%" align="right">
                {{ number_format($total_saldo_bulan_lalu1 + $total_saldo_bulan_lalu2 - $sum_pph_bulan_lalu, 2) }}</td>
            <td width="15%" align="right">
                {{ number_format($total_saldo1 - $total_saldo_bulan_lalu1 + ($total_saldo2 - $total_saldo_bulan_lalu2) - ($sum_pph - $sum_pph_bulan_lalu), 2) }}
            </td>
            <td width="15%" align="right">{{ number_format($total_saldo1 + $total_saldo2 - $sum_pph, 2) }}
            </td>
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

@extends('pelaporan.layout.base')

@section('content')
    @php
        $saldoA = 0; // A = Operasional
        $saldoA_lalu = 0;

        $saldoB = 0; // B = Non Operasional
        $saldoB_lalu = 0;

        $taksiran = 0;
        $taksiran_lalu = 0;

        $saldo1 = 0;
        $saldo_bln_lalu1 = 0;

        $saldo2 = 0;
        $saldo_bln_lalu2 = 0;
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
        @php
            $kelompok_judul = [
                '4.1' => '4. Pendapatan',
                '5.1' => '5. Beban',
                '5.2' => '5. Beban',
                '4.2' => '4. Pendapatan Non Operasional',
                '4.3' => '4. Pendapatan Non Operasional',
                '5.3' => '5. Beban Non Operasional',
            ];

            $kelompok_urutan = [
                '4.1' => '4. Pendapatan',
                '5.1' => '5. Beban',
                '4.2' => '4. Pendapatan Non Operasional',
                '5.3' => '5. Beban Non Operasional',
            ];

            $sudah_tampil = []; // untuk memastikan judul kelompok tidak muncul 2x
        @endphp

        @foreach ($rekap as $kode => $p)
            @php
                $judul = $kelompok_judul[$kode] ?? '';
            @endphp
            @if ($judul && !in_array($judul, $sudah_tampil))
                <tr style="background: rgb(200, 200, 200); font-weight: bold; text-transform: uppercase;">
                    <td colspan="4" height="14">{{ $judul }}</td>
                </tr>
                @php
                    $sudah_tampil[] = $judul;
                @endphp
            @endif
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td colspan="4" height="14">{{$kode}}. {{ $p['nama'] }}</td>
            </tr>
            @php
                $jum_bulan_lalu = 0;
                $jum_saldo = 0;
            @endphp
                
                @foreach ($p['akun3'] as $kode1 => $p1)
                    @foreach ($p1['rekap'] as $kode2 => $p2)
                    @php
                $total_bln_lalu = 0;
                $total_saldo = 0;
                        $a = 1;
                    @endphp
                        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
                            <td colspan="4" height="14">{{$kode2}}. {{ $p2['nama'] }}</td>
                        </tr>
                            @foreach ($p2['lokasi'] as $p3)
                @php
                    $a+=1;
                    $bg = 'rgb(230, 230, 230)';
                    if ($a % 2 == 0) {
                        $bg = 'rgb(255, 255, 255)';
                    }
                            $total_bln_lalu += $p3['saldo_bln_lalu'];
                            $total_saldo += $p3['saldo'];
                        @endphp
                        <tr style="background: {{ $bg }};">
                            <td height="14">&nbsp;&nbsp;&nbsp; {{ $p2['nama'] }} di {{ $p3['nama_kec'] }}</td>
                            <td align="right">{{ number_format($p3['saldo_bln_lalu'], 2) }}</td>
                            <td align="right">{{ number_format($p3['saldo'] - $p3['saldo_bln_lalu'], 2) }}</td>
                            <td align="right">{{ number_format($p3['saldo'], 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach

            {{-- Jumlah per $kode --}}
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td align="left" height="14">Jumlah {{ $kode }}. {{ $p['nama'] }}</td>
                <td align="right">{{ number_format($total_bln_lalu, 2) }}</td>
                <td align="right">{{ number_format($total_saldo - $total_bln_lalu, 2) }}</td>
                <td align="right">{{ number_format($total_saldo, 2) }}</td>
            </tr>

            {{-- Akumulasi A/B --}}
            @php
                if (in_array($kode, ['4.1', '5.1', '5.2'])) {
                    $saldoA += $total_saldo;
                    $saldoA_lalu += $total_bln_lalu;
                } elseif (in_array($kode, ['4.2', '4.3', '5.3'])) {
                    $saldoB += $total_saldo;
                    $saldoB_lalu += $total_bln_lalu;
                } elseif (in_array($kode, ['5.4'])) {
                    $taksiran += $total_saldo;
                    $taksiran_lalu += $total_bln_lalu;
                }
            @endphp
        @endforeach

        {{-- Laba Rugi Operasional (A) --}}
        <tr style="background: rgb(225, 225, 225); font-weight: bold;">
            <td align="left" height="16">A. Laba Rugi Operasional</td>
            <td align="right">{{ number_format($saldoA_lalu, 2) }}</td>
            <td align="right">{{ number_format($saldoA - $saldoA_lalu, 2) }}</td>
            <td align="right">{{ number_format($saldoA, 2) }}</td>
        </tr>

        {{-- Laba Rugi Non Operasional (B) --}}
        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
            <td align="left" height="16">B. Laba Rugi Non Operasional</td>
            <td align="right">{{ number_format($saldoB_lalu, 2) }}</td>
            <td align="right">{{ number_format($saldoB - $saldoB_lalu, 2) }}</td>
            <td align="right">{{ number_format($saldoB, 2) }}</td>
        </tr>

        {{-- Laba Sebelum Pajak (C = A + B) --}}
        @php
            $totalC = $saldoA + $saldoB;
            $totalC_lalu = $saldoA_lalu + $saldoB_lalu;
        @endphp
        <tr style="background: rgb(250, 250, 250); font-weight: bold;">
            <td align="left" height="16">C. Laba Rugi Sebelum Taksiran Pajak (A + B)</td>
            <td align="right">{{ number_format($totalC_lalu, 2) }}</td>
            <td align="right">{{ number_format($totalC - $totalC_lalu, 2) }}</td>
            <td align="right">{{ number_format($totalC, 2) }}</td>
        </tr>

        {{-- Laba Setelah Pajak (sama dengan C) --}}
        <tr style="background: rgb(175, 175, 175); font-weight: bold;">
            <td align="left" height="16">C. Laba Rugi Setelah Taksiran Pajak (A + B)</td>
            <td align="right">{{ number_format($totalC_lalu-$taksiran_lalu, 2) }}</td>
            <td align="right">{{ number_format(($totalC - $taksiran) - ($totalC_lalu-$taksiran_lalu), 2) }}</td>
            <td align="right">{{ number_format($totalC - $taksiran, 2) }}</td>
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
@endsection

@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>ARUS KAS</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>

    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr style="background: rgb(200, 200, 200)">
            <th colspan="2">Nama Akun</th>
            <th>Jumlah</th>
        </tr>

        @php
            $nomor = 0;
            $kenaikanPenurunanKas = 0;
        @endphp
        @foreach ($arus_kas as $ak)
            @php
                $dot = substr($ak['nama_akun'], 1, 1);
                if ($dot == '.') {
                    $bg = '150, 150, 150';
                } else {
                    $bg = '128, 128, 128';
                }

                $nomor++;
            @endphp

            <tr>
                <td colspan="3" height="3"></td>
            </tr>
            <tr style="background: rgb(74, 74, 74); color: #fff; font-weight: bold;">
                <td width="5%" align="center"></td>
                <td width="80%">{{ $ak['nama_akun'] }}</td>
                <td width="15%" align="right">
                    @if ($nomor == 1)
                        {{ number_format($saldo_bulan_lalu, 2) }}
                    @endif

                    @if (str_contains($ak['nama_akun'], 'KENAIKAN'))
                        {{ number_format($kenaikanPenurunanKas, 2) }}
                    @endif

                    @if (str_contains($ak['nama_akun'], 'SALDO AKHIR'))
                        {{ number_format($saldo_bulan_lalu + $kenaikanPenurunanKas, 2) }}
                    @endif
                </td>
            </tr>

            @foreach ($ak['child'] as $child)
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td align="center"></td>
                    <td>{{ $child['nama_akun'] }}</td>
                    <td align="right">
                        @if (str_contains($child['nama_akun'], 'A-B'))
                            {{ number_format($child['saldo'], 2) }}
                            @php
                                $kenaikanPenurunanKas += $child['saldo'];
                            @endphp
                        @endif
                    </td>
                </tr>

                @foreach ($child['child'] as $subchild)
                    @php
                        $bg = 'rgb(230, 230, 230)';
                        if ($loop->iteration % 2 == 0) {
                            $bg = 'rgba(255, 255, 255)';
                        }

                        $style = 'background: ' . $bg . ';';
                        $endChild = end($child['child']);
                        if ($endChild['nomor'] == $subchild['nomor']) {
                            $style .= 'font-weight: bold;';
                        }
                    @endphp
                    <tr style="{!! $subchild['child'] ? 'background: rgb(167, 167, 167); font-weight: bold;' : $style !!}">
                        <td align="center"></td>
                        <td>{{ $subchild['nama_akun'] }}</td>
                        <td align="right">
                            @if ($endChild['nomor'] == $subchild['nomor'] && !$subchild['child'])
                                {{ number_format($child['saldo'], 2) }}
                            @else
                                {{ $subchild['child'] ? '' : number_format($subchild['saldo'], 2) }}
                            @endif
                        </td>
                    </tr>

                    @foreach ($subchild['child'] as $lastchild)
                        @php
                            $bg = 'rgb(230, 230, 230)';
                            if ($loop->iteration % 2 == 0) {
                                $bg = 'rgba(255, 255, 255)';
                            }

                            $style = 'background: ' . $bg . ';';
                            $endChild = end($subchild['child']);
                            if ($endChild['nomor'] == $lastchild['nomor']) {
                                $style .= 'font-weight: bold;';
                            }
                        @endphp
                        <tr style="{{ $style }}">
                            <td align="center"></td>
                            <td>{{ $lastchild['nama_akun'] }}</td>
                            <td align="right">
                                @if ($endChild['nomor'] == $lastchild['nomor'])
                                    {{ number_format($subchild['saldo'], 2) }}
                                @else
                                    {{ number_format($lastchild['saldo'], 2) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </table>
@endsection

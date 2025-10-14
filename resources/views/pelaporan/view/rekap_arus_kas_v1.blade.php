@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>REKAP ARUS KAS</b>
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
            @foreach ($kecamatan as $kec)
                <th width="15%">
                    {{ ucwords(trim(str_replace('cabang', '', strtolower($kec->nama_kec)))) }}
                </th>
            @endforeach
        </tr>

        @php
            $nomor = 0;
            foreach ($kecamatan as $kec) {
                $kenaikanPenurunanKas[$kec->id] = 0;
            }
        @endphp
        @foreach ($arus_kas[0] as $ak_key => $ak)
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
                <td>{{ $ak['nama_akun'] }}</td>
                @foreach ($kecamatan as $kec)
                    <td>
                        @if ($nomor == 1)
                            {{ number_format($saldo_bulan_lalu[$kec->id], 2) }}
                        @endif

                        @if (str_contains($ak['nama_akun'], 'KENAIKAN'))
                            {{ number_format($kenaikanPenurunanKas[$kec->id], 2) }}
                        @endif

                        @if (str_contains($ak['nama_akun'], 'SALDO AKHIR'))
                            {{ number_format($saldo_bulan_lalu[$kec->id] + $kenaikanPenurunanKas[$kec->id], 2) }}
                        @endif
                    </td>
                @endforeach
            </tr>

            @foreach ($ak['child'] as $child_key => $child)
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td align="center"></td>
                    <td>{{ $child['nama_akun'] }}</td>
                    @foreach ($kecamatan as $kec)
                        @php
                            $childKec = $arus_kas[$kec->id][$ak_key]['child'][$child_key];
                        @endphp
                        <td>
                            @if (str_contains($child['nama_akun'], 'A-B'))
                                {{ number_format($childKec['saldo'], 2) }}
                                @php
                                    $kenaikanPenurunanKas[$kec->id] += $childKec['saldo'];
                                @endphp
                            @endif
                        </td>
                    @endforeach
                </tr>

                @foreach ($child['child'] as $subchild_key => $subchild)
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
                        @foreach ($kecamatan as $kec)
                            @php
                                $childKec = $arus_kas[$kec->id][$ak_key]['child'][$child_key];
                                $subchildKec =
                                    $arus_kas[$kec->id][$ak_key]['child'][$child_key]['child'][$subchild_key];
                            @endphp
                            <td>
                                @if ($endChild['nomor'] == $subchild['nomor'] && !$subchild['child'])
                                    {{ number_format($childKec['saldo'], 2) }}
                                @else
                                    {{ $subchild['child'] ? '' : number_format($subchildKec['saldo'], 2) }}
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    @foreach ($subchild['child'] as $lastchild_key => $lastchild)
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
                            @foreach ($kecamatan as $kec)
                                @php
                                    $subchildKec =
                                        $arus_kas[$kec->id][$ak_key]['child'][$child_key]['child'][$subchild_key];
                                    $lastchildKec =
                                        $arus_kas[$kec->id][$ak_key]['child'][$child_key]['child'][$subchild_key][
                                            'child'
                                        ][$lastchild_key];
                                @endphp
                                <td>
                                    @if ($endChild['nomor'] == $lastchild['nomor'])
                                        {{ number_format($subchildKec['saldo'], 2) }}
                                    @else
                                        {{ number_format($lastchildKec['saldo'], 2) }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </table>
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;page-break-inside: avoid; break-inside: avoid;">
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
@endsection

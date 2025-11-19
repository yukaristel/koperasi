@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>LAPORAN PERUBAHAN MODAL</b>
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

    <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr style="background: rgb(74, 74, 74); color: #fff;">
            <th width="5%" height="20">No</th>
            <th width="55%">Rekening Modal</th>
            <th width="20%">&nbsp;</th>
            <th width="20%">&nbsp;</th>
        </tr>

        @php
            $group = '';
            $section = '';

            $nomor = 1;
            $jumlah_saldo = 0;
        @endphp
        @foreach ($rekening as $rek)
            @php
                $section = explode(' ', $rek->nama_akun)[0];
            @endphp

            @if ($loop->iteration > 1 && $section != $group && $group != '')
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td align="right" colspan="3" height="15">
                        <b>Jumlah</b>
                    </td>
                    <td align="right">
                        <b>{{ number_format($jumlah_saldo, 2) }}</b>
                    </td>
                </tr>

                @php
                    $nomor = 1;
                    $jumlah_saldo = 0;
                @endphp
            @endif

            @php
                if ($rek->kode_akun == '3.2.02.01') {
                    $saldo = $keuangan->laba_rugi($tgl_kondisi);
                } else {
                    $saldo = $keuangan->komSaldo($rek);
                }

                $jumlah_saldo += $saldo;

                $bg = 'rgb(230, 230, 230)';
                if ($loop->iteration % 2 == 0) {
                    $bg = 'rgba(255, 255, 255)';
                }
            @endphp
            <tr style="background: {{ $bg }};">
                <td align="center">{{ $nomor++ }}</td>
                <td>{{ $rek->nama_akun }}</td>
                <td align="right">{{ number_format($saldo, 2) }}</td>
                <td>&nbsp;</td>
            </tr>

            @php
                $group = $section;
            @endphp
        @endforeach

        <tr style="background: rgb(167, 167, 167); font-weight: bold;">
            <td align="right" colspan="3" height="15">
                <b>Jumlah</b>
            </td>
            <td align="right">
                <b>{{ number_format($jumlah_saldo, 2) }}</b>
            </td>
        </tr>

        @php
            $nomor = 1;
            $jumlah_saldo = 0;
        @endphp
        @foreach ($rekening2 as $rek)
            @php
                if ($rek->kode_akun == '3.2.02.01') {
                    $saldo = $keuangan->laba_rugi($tgl_kondisi);
                } else {
                    $saldo = $keuangan->komSaldo($rek);
                }

                $jumlah_saldo += $saldo;
                $bg = 'rgb(230, 230, 230)';
                if ($loop->iteration % 2 == 0) {
                    $bg = 'rgba(255, 255, 255)';
                }
            @endphp
            <tr style="background: {{ $bg }};">
                <td align="center">{{ $nomor++ }}</td>
                <td>{{ $rek->nama_akun }}</td>
                <td align="right">{{ number_format($saldo, 2) }}</td>
                <td>&nbsp;</td>
            </tr>
        @endforeach
        <tr style="background: rgb(167, 167, 167); font-weight: bold;">
            <td align="right" colspan="3" height="15">
                <b>Jumlah</b>
            </td>
            <td align="right">
                <b>{{ number_format($jumlah_saldo, 2) }}</b>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <div style="margin-top: 16px;"></div>
                {!! json_decode(str_replace('{tanggal}', $tanggal_kondisi, $kec->ttd->tanda_tangan_pelaporan), true) !!}
            </td>
        </tr>
    </table>
@endsection

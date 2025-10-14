@php
    use App\Utils\Tanggal;
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10pt;">
        <tr class="b">
            <td colspan="3" align="center">
                <div style="font-size: 20pt;">
                    <b>CHECK LIST</b>
                </div>
                <div style="font-size: 18pt;">
                    KELENGKAPAN PROPOSAL {{ strtoupper($pinkel->jpp->nama_jpp) }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>

    </table>

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10pt;">
        <tr>
            <td width="100">Kode Nasabah</td>
            <td width="5">:</td>
            <td style="font-weight: bold;">{{ $pinkel->anggota->nik }}</td>

            <td width="80">&nbsp;</td>

            <td width="100">Tanggal</td>
            <td width="5">:</td>
            <td style="font-weight: bold;">{{ Tanggal::tglLatin($pinkel->tgl_proposal) }}</td>
        </tr>

        <tr>
            <td>Nama Nasabah</td>
            <td width="5">:</td>
            <td style="font-weight: bold;">{{ $pinkel->anggota->namadepan }}</td>

            <td>&nbsp;</td>

            <td>Panggilan Nasabah</td>
            <td width="5">:</td>
            <td style="font-weight: bold;">{{ $pinkel->anggota->namadepan }}</td>
        </tr>

        <tr>
            <td>Desa/Kelurahan</td>
            <td width="5">:</td>
            <td style="font-weight: bold;">{{ $pinkel->anggota->d->desa }}</td>

            <td>&nbsp;</td>

            <td>Telpon</td>
            <td width="5">:</td>
            <td style="font-weight: bold;">{{ $pinkel->anggota->hp }}</td>
        </tr>
    </table>

    <table border="1" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10pt; margin-top: 11pt;">
        <tr style="background: rgb(232,232,232);">
            <th rowspan="2" width="10">No</th>
            <th rowspan="2">Nama Dokumen</th>
            <th colspan="3">Status</th>
            <th rowspan="2" width="150">Catatan</th>
        </tr>
        <tr style="background: rgb(232,232,232);">
            <th width="30">C</th>
            <th width="30">K</th>
            <th width="30">TA</th>
        </tr>

        @foreach ($data as $dt => $v)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td>{{ $v }}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6">
                <b>Catatan :</b>
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
        </tr>
    </table>
    <div style="font-size: 8pt; margin-bottom: 16pt;">Keterangan: C = Cukup | K = Kurang | TA = Tidak Ada</div>

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10pt; margin-top: 11pt;">
        <tr>
            <td width="60%"></td>
            <td width="40%" align="center">Diperika tanggal, ___________________</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="center">Diperiksa Oleh</td>
        </tr>
        <tr>
            <td colspan="2" height="40">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="center"><b>_____________________</b></td>
        </tr>
    </table>
@endsection

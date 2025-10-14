@php
    use App\Utils\Tanggal;
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11pt;">
        <tr class="b">
            <td colspan="3" align="center">
                <div style="font-size: 18pt;">
                    <b>FORMULIR PERMOHONAN KREDIT BARANG</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11pt; text-align: justify;">
        <tr>
            <td colspan="3">Yang bertanda tangan di bawah ini,</td>
        </tr>
        <tr>
            <td width="100">Nama Nasabah</td>
            <td width="5" align="right">:</td>
            <td>{{ $pinkel->anggota->namadepan }}</td>
        </tr>
        <tr>
            <td>Tempat, Tgl. lahir</td>
            <td align="right">:</td>
            <td>{{ $pinkel->anggota->tempat_lahir }}
                {{ Tanggal::tglLatin($pinkel->anggota->tgl_lahir) }}
            </td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td align="right">:</td>
            <td>{{ $pinkel->anggota->alamat }} {{ $pinkel->anggota->d->sebutan_desa->sebutan_desa }}
                {{ $pinkel->anggota->d->desa }} {{ $kec->sebutan_kec }} {{ $kec->nama_kec }}
                {{ $nama_kabupaten }} </td>
        </tr>
        <tr>
            <td width="100">Status Perkawinan</td>
            <td width="5" align="right">:</td>
            <td>{{ $pinkel->anggota->status_pernikahan }}</td>
        </tr>
        <tr>
            <td>Nama Penjamin</td>
            <td align="right">:</td>
            <td>{{ $pinkel->anggota->penjamin }}</td>
        </tr>
        <tr>
            <td>Alamat / Tempat Bekerja </td>
            <td align="right">:</td>
            <td>{{ $pinkel->anggota->tempat_kerja }}</td>
        </tr>
        <tr>
            <td>Gaji/Penghasilan </td>
            <td align="right">:</td>
            <td>Rp. ____________________/bulan </td>
        </tr>
        <tr>
            <td>Biaya Hidup </td>
            <td align="right">:</td>
            <td>Rp. ____________________/bulan </td>
        </tr>
        <tr>
            <td>Jenis barang kredit </td>
            <td align="right">:</td>
            <td>{{ $pinkel->nama_barang }}</td>
        </tr>
        <tr>
            <td>Type</td>
            <td align="right">:</td>
            <td>{{ $pinkel->jpp->nama_jpp }} </td>
        </tr>
        <tr>
            <td>Lama/Durasi kredit </td>
            <td align="right">:</td>
            <td>{{ $pinkel->jangka }} bulan </td>
        </tr>
    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11pt;">
        <tr>
            <td colspan="3" height="20">&nbsp;</td>
        </tr>
        <tr>
            <td width="33%">&nbsp;</td>
            <td width="33%">&nbsp;</td>
            <td width="33%" align="center">{{ $nama_kab }}, {{ Tanggal::tglLatin($pinkel->tgl_proposal) }}</td>
        </tr>
        <tr>
            <td align="center">Mengetahui,<br>
                Suami/Istri</td>
            <td align="center">&nbsp;</td>
            <td align="center">Hormat kami,<br>
                Yang Mengajukan</td>
        </tr>
        <tr>
            <td colspan="3" height="50">&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                <b>____________________</b>
            </td>
            <td align="center">
                <b>&nbsp;</b>
            </td>
            <td align="center">
                <b>____________________</b>
            </td>
        </tr>
    </table>
@endsection

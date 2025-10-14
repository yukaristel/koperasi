@php
    use App\Utils\Tanggal;
    $jaminan  = json_decode($pinkel->jaminan, true);
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')

<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">        
      <tr>
        <td height="50" colspan="3" class="bottom">
          <p align="center" class="style6" style="font-size: 18pt; font-weight: bold;">SURAT PERNYATAAN PENGGUNAAN AGUNAN<br>PIHAK KETIGA</p>
        </td>
      </tr>      
      <tr>
        <td height="10" colspan="3" class="style9"></td>
      </tr>
      <tr>
        <td height="10" colspan="3" class="style9">Yang bertanda tangan dibawah ini,</td>
      </tr>
      <tr>
        <td width="5">&nbsp;</td>
        <td height="10" class="style9">Nama Lengkap </td>
        <td class="style27" >: ________________________________</td>
      </tr>
      <tr>
        <td width="5">&nbsp;</td>
        <td height="10" class="style9">NIK</td>
        <td class="style27">: ________________________________</td>
      </tr>
      <tr>
        <td width="5">&nbsp;</td>
        <td width="20%" height="10" class="style9">Alamat</td>
        <td width="42%" class="style27">: ________________________________</td>
      </tr>
	    <tr>
        <td width="5">&nbsp;</td>
        <td height="10" class="style9">Nomor HP</td>
        <td class="style27">: ________________________________</td>
      </tr>
            <tr>
              <td  height="10" colspan="3" class="style9">Dengan penuh kesadaran dan tanpa adanya tekanan dari pihak manapun, saya menyatakan bahwa saya mengizinkan serta tidak keberatan apabila: </td>
            </tr>
      @if ($jaminan['jenis_jaminan'] == '1')
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nomor Sertifikat</td>
              <td class="style27">: {{($jaminan['nomor_sertifikat'])}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nama Pemilik</td>
              <td class="style27">: {{$jaminan['nama_pemilik']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Alamat</td>
              <td class="style27">: {{$jaminan['alamat']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Luas</td>
              <td class="style27">: {{ $jaminan['luas']}} (m²)</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nilai Jual Tanah</td>
              <td class="style27">: {{$jaminan['nilai_jual_tanah']}}</td>
            </tr>
      @elseif ($jaminan['jenis_jaminan'] == '2')
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nomor</td>
              <td class="style27">: {{($jaminan['nomor'])}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nama Pemilik</td>
              <td class="style27">: {{$jaminan['nama_pemilik']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nopol</td>
              <td class="style27">: {{$jaminan['nopol']}}</td>
            </tr>
            <tr> 
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nilai Jual Kendaraan</td>
              <td class="style27">: {{ $jaminan['nilai_jual_kendaraan']}}</td>
            </tr>
      @elseif ($jaminan['jenis_jaminan'] == '3')
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nomor</td>
              <td class="style27">: {{($jaminan['nomor'])}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nama Pegawai</td>
              <td class="style27">: {{$jaminan['nama_pegawai']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nama Instansi Penerbit</td>
              <td class="style27">: {{$jaminan['nama_kuitansi_penerbit']}}</td>
            </tr>
      @elseif ($jaminan['jenis_jaminan'] == '4')
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nomor Jaminan</td>
              <td class="style27">: {{($jaminan['nama_jaminan'])}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Keterangan</td>
              <td class="style27">: {{$jaminan['keterangan']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nilai Jaminan</td>
              <td class="style27">: {{$jaminan['nilai_jaminan']}}</td>
            </tr>
      @else
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nomor Sertifikat</td>
              <td class="style27">: {{($jaminan['nomor_sertifikat'])}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nama Pemilik</td>
              <td class="style27">: {{$jaminan['nama_pemilik']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Alamat</td>
              <td class="style27">: {{$jaminan['alamat']}}</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Luas</td>
              <td class="style27">: {{ $jaminan['luas']}} (m²)</td>
            </tr>
            <tr>
              <td width="5">&nbsp;</td>
              <td height="10" class="style9">Nilai Jual Tanah</td>
              <td class="style27">: {{$jaminan['nilai_jual_tanah']}}</td>
            </tr>
      @endif
      <tr>
        <td colspan="3" class="style9">Agunan milik saya untuk di pergunakan sebagai jaminan kredit usaha di <strong>{{$kec->nama_lembaga_sort}}</strong> dengan peminjam atas nama </td>
      </tr>
      <tr>
        <td width="5">&nbsp;</td>
        <td height="10" class="style9">Nama Lengkap </td>
        <td class="style27" >: {{$pinkel->anggota->namadepan}}</td>
      </tr>
      <tr>
        <td width="5">&nbsp;</td>
        <td height="10" class="style9">NIK</td>
        <td class="style27">: {{$pinkel->anggota->nik}}</td>
      </tr>
      <tr>
        <td width="5">&nbsp;</td>
        <td width="20%" height="10" class="style9">Alamat</td>
        <td width="42%" class="style27">: {{ $pinkel->anggota->d->nama_desa }}</td>
      </tr>
	    <tr>
        <td width="5">&nbsp;</td>
        <td height="10" class="style9">ID Pinjaman</td>
        <td class="style27">: {{ $pinkel->id }}</td>
      </tr>
            <tr>
              <td  height="10" colspan="3" class="style9"> 
Sampai kredit dinyatakan “LUNAS” oleh <strong>{{$kec->nama_lembaga_sort}}</strong> dan dinyatakan bahwa Barang tersebut tidak sedang dijaminkan/dipindah tangankan pada fihak lain atau dalam sengketa di dalam maupun di luar pengadilan. <br>
Demikian Surat Pernyataan ini saya buat dengan penuh kesadaran dan tanggung jawab, untuk digunakan sebagaimana mestinya.
              </td>
            </tr>
      <br colspan="3">
</table>
<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0" style="width: 97% !important; table-layout: fixed;">
    <tr>
        <td width="50%" height="36" colspan="1" class="style26" style="width: 50% !important;">
             &nbsp;
        </td>
        <td width="50%" class="style26" style="width: 50% !important;">
            <div align="center" class="style9">
                <p>{{$kec->nama_kec}},_______________<br>Yang Membuat Surat Pernyataan</p>
            </div>
        </td>
    </tr>
    <tr>        
        <td width="7"align="center" colspan="-1" class="style9">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p> <br></p>
        </td>
        <td width="7"align="center" class="style9">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>________________________</p>
        </td>
    </tr>
</table>	  

@endsection

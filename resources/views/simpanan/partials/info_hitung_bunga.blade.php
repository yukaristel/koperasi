@php
    use Carbon\Carbon;
@endphp

<span>
    Proses Hitung Bunga ini akan menghitung

        <strong>
        @if ($jb == 1)
            Saldo Terakhir
        @elseif ($jb == 2)
            Saldo Terendah
        @else
            Saldo Rata-Rata
        @endif
        </strong>

    simpanan / tabungan dari tanggal
    <strong>{{ \Carbon\Carbon::parse($tgl_awal)->translatedFormat('j F Y') }}</strong> hingga tanggal 
    <strong>{{ \Carbon\Carbon::parse($tgl_akhir)->translatedFormat('j F Y') }} ({{ $jumlah_hari }} hari)</strong>, 
    jika tanggal kurang sesuai, silakan atur di Pengaturan SOP atau bisa menghubungi TS (<strong>+62 882-0066-44656</strong>)
    <br>
    <br>
    Biarkan CIF kosong untuk memproses semua CIF. Jika hanya ingin memproses beberapa CIF tertentu, silakan masukkan dalam format: <strong>CIF1, CIF2, CIF3</strong>, dan seterusnya. (misal : 1, 2, 4, 34, dsb)
</span>

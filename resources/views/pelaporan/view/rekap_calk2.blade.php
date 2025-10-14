@php
    use App\Utils\Keuangan;
    $keuangan = new Keuangan();
@endphp

@extends('pelaporan.layout.base')

@section('content')
    <style>
        ol,
        ul {
            margin-left: unset;
        }
    </style>

    <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>CATATAN ATAS LAPORAN KEUANGAN</b>
                </div>
                <div style="font-size: 18px; text-transform: uppercase;">
                    <b>KOPERASI ARTHAMARI</b>
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

    <ol style="list-style: upper-alpha;">
        <li>
            <div style="text-transform: uppercase;">Gambaran Umum</div>
            <div style="text-align: justify">
                Lembaga Koperasi Arthamari adalah lembaga ekonomi beranggotakan masyarakat desa yang dibentuk untuk meningkatkan kesejahteraan melalui prinsip gotong royong, kekeluargaan, dan partisipasi bersama.
            </div> <br>
            <div style="text-align: justify">
                Regulasi atau Dasar Hukum  Lembaga Koperasi Arthamari adalah sebagai berikut : 
            </div>
            <ol>
                <li>
                    Undang-Undang Nomor 25 Tahun 1992 tentang Perkoperasian
                </li>
                <li>
                    Peraturan Pemerintah Nomor 4 Tahun 1994 tentang Persyaratan dan Tata cara Pengesahan Akta Pendirian dan Perubahan Anggaran Dasar Koperasi. 
                </li>
                <li>
                    Peraturan Pemerintah Nomor 17 Tahun 1994 tentang Pembubaran Koperasi Oleh Pemerintah.
                </li>
                <li>
                    Peraturan Menteri Koperasi dan UKM Nomor 13 Tahun 2023. 
                </li>
                <li>
                    Peraturan Menteri Koperasi dan UKM Nomor 8 Tahun 2023.
                </li>
                <li>
                    Peraturan Pemerintah Nomor 7 Tahun 2021 tentang Kemudahan, Pelindungan dan Pemberdayaan Koperasi dan Usaha Mikro, Kecil dan Menengah
                </li>
                
                <li>
                    Peraturan Menteri Koperasi dan Usaha Kecil dan Menengah (Permenkop UKM) Nomor 72 Tahun 2017
                    <ol style="list-style: lower-alpha">
                        <li>
                            Permenkop 9 Tahun 2018 adalah Peraturan Menteri Koperasi dan UKM Nomor 9 Tahun 2018
                        </li>
                        <li>
                            Permenkop No. 15 Tahun 2015 adalah Peraturan Menteri Koperasi dan Usaha Kecil dan Menengah tentang Usaha Simpan Pinjam oleh Koperasi.
                        </li>
                        <li>
                            Permenkop No 19 Tahun 2015 tentang Rapat Anggota Tahunan
                        </li>
                        <li>
                            Peraturan Menteri Koperasi dan Usaha Kecil dan Menengah Nomor 9 Tahun 2020 tentang Pengawasan Koperasi
                        </li>
                        <li>
                            Peraturan Menteri Koperasi dan Usaha Kecil dan Menengah Nomor 8 Tahun 2023 (Permenkop 8/2023) mengatur tentang usaha simpan pinjam oleh koperasi.
                        </li>
                        <li>
                            Peraturan Menteri Koperasi dan Usaha Kecil dan Menengah Nomor 2 Tahun 2024 tentang Kebijakan Akuntansi Koperasi
                        </li>
                        <li>
                            Permenkop No. 1 Tahun 2025 tentang "Penyaluran Pinjaman atau Pembiayaan Dana Bergulir kepada Koperasi Percontohan (Mock Up) Koperasi Desa/Kelurahan Merah Putih". 
                        </li>
                    </ol>
                </li>
            </ol>
            <p style="text-align: justify">
                Selanjutnya Lembaga Koperasi Arthamari
                telah resmi mendaftar sebagai lembaga keuangan yang selanjutnya mendapat legalitas dari Kementerian Hukum
                dan HAM.
            </p>
        </li>
        <li style="margin-top: 12px;">
            <div style="text-transform: uppercase;">
                Ikhtisar Kebijakan Akutansi
            </div>
            <ol>
                <li>
                    Pernyataan Kepatuhan
                    <ol style="list-style: lower-alpha;">
                        <li>
                            Laporan keuangan disusun menggunakan Standar Akuntansi Keuangan Perusahaan Jasa Keuangan Mikro,
                            sesuai Permenkop No. 02 Tahun 2024.
                        </li>
                        <li>Dasar Penyusunan laporan keuangan adalah SOP penatausahaan dan SOP laporan Keuangan.</li>
                        <li>
                            Dasar penyusunan laporan keuangan adalah biaya historis dan menggunakan asumsi dasar kas basis.
                            Mata uang penyajian yang digunakan untuk menyusun laporan keuangan ini adalah Rupiah.
                        </li>
                    </ol>
                </li>
                <li>
                    Piutang Usaha
                    <div>
                        Piutang usaha disajikan sebesar jumlah alokasi pencairan piutang ditambah nilai resceduling setelah
                        dikurangi komulatif angsuran pada setiap pinjaman dan nilai penghapusan pinjaman yang diputuskan
                        dalam Rapat Direksi dan/atau Keputusan Direktur.
                    </div>
                </li>
                <li>
                    Aset Tetap dan Inventaris dan Aset tak berwujud
                    <ol style="list-style: lower-alpha">
                        <li>
                            Aset tetap dan Inventaris beserta Aset tak berwujud dicatat sebesar biaya perolehannya pada saat
                            aset tersebut secara hukum mulai dimiliki oleh Koperasi Arthamari.
                        </li>
                        <li>
                            Aset tetap beserta Inventaris disusutkan menggunakan metode garis lurus tanpa nilai residu.
                        </li>
                    </ol>
                </li>
                <li>
                    Pengakuan Pendapatan dan Beban
                    <ol style="list-style: lower-alpha;">
                        <li>
                            Jasa piutang masyarakat yang sudah dilakukan pembayaran
                            diakui sebagai pendapatan dan diterbitkan kuitansi pembayaran,
                            sedangkan jasa yang seharusnya sudah memasuki kewajiban bayar/target bayar
                            akan tetapi tidak dipenuhi oleh nasabah (menunggak) tetap diakui sebagai pendapatan
                            meskipun tidak diterbitkan kuitansi, sehinga sekaligus dicatatkan sebagai
                            piutang jasa. Adapun berkaitan dengan penerimaan denda atas keterlambatan
                            pembayaran/pinalti diakui sebagai pendapatan pada saat diterbitkan kuitansi pembayaran.
                        </li>
                        <li>
                            Adapun kewajiban bayar atas kebutuhan operasional, pemasaran maupun non operasional pada suatu
                            periode operasi tertentu sebagai akibat telah menikmati manfaat/menerima fasilitas, maka hal
                            tersebut sudah wajib diakui sebagai beban meskipun belum diterbitkan kuitansi pembayaran.
                        </li>
                    </ol>
                </li>
                <li>
                    Pajak Penghasilan
                    <div>
                        Pajak Penghasilan mengikuti ketentuan perpajakan yang berlaku di Indonesia.
                    </div>
                </li>
            </ol>
        </li>

        <li style="margin-top: 12px;">
            <div style="text-transform: uppercase;">
                Informasi Tambahan Laporan Keuangan
            </div>
            <div>
                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                    <tr style="background: #000; color: #fff;">
                        <td width="10%">Kode</td>
                        <td width="45%">Nama Akun</td>
                        <td align="center" width="15%">Saldo Tahun Lalu</td>
                        <td align="center" width="15%">Total Saldo</td>
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

                                    if (!isset($rekening[$lev3->kode_akun])) {
                                        continue;
                                    }

                                    $saldoRekening = [];
                                @endphp

                                @foreach ($rekening[$lev3->kode_akun] as $rek => $lokasi)
                                    @php
                                        $kode_akun = explode('||', $rek)[0];
                                        $nama_akun = explode('||', $rek)[1];

                                        $jumlah_saldo_awal = 0;
                                        $jumlah_total_saldo = 0;
                                        foreach ($kecamatan as $kec) {
                                            $saldoRek = isset($lokasi[$kec->id]) ? $lokasi[$kec->id] : false;

                                            if ($saldoRek) {
                                                $saldo = $keuangan->getTbSaldo($saldoRek);
                                                $saldo_awal = $saldo['saldo_awal'];
                                                $saldo_berjalan = $saldo['saldo_berjalan'];
                                                if ($kode_akun == '3.2.02.01') {
                                                    $saldo_berjalan = $laba_rugi[$kec->id];
                                                }

                                                $jumlah_saldo_awal += $saldo_awal;
                                                $jumlah_total_saldo += $saldo_berjalan;
                                            }
                                        }

                                        $saldoRekening[] = [
                                            'nama_akun' => $nama_akun,
                                            'kode_akun' => $kode_akun,
                                            'jumlah_saldo_awal' => $jumlah_saldo_awal,
                                            'jumlah_total_saldo' => $jumlah_total_saldo,
                                        ];

                                        $sum_saldo_awal += $jumlah_saldo_awal;
                                        $sum_total_saldo += $jumlah_total_saldo;
                                    @endphp
                                @endforeach

                                @php
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

                                @foreach ($saldoRekening as $rek)
                                    <tr>
                                        <td>{{ $rek['kode_akun'] }}.</td>
                                        <td>{{ $rek['nama_akun'] }}</td>
                                        @if ($rek['jumlah_saldo_awal'] < 0)
                                            <td align="right">
                                                ({{ number_format($rek['jumlah_saldo_awal'] * -1, 2) }})
                                            </td>
                                        @else
                                            <td align="right">{{ number_format($rek['jumlah_saldo_awal'], 2) }}</td>
                                        @endif

                                        @if ($rek['jumlah_total_saldo'] < 0)
                                            <td align="right">
                                                ({{ number_format($rek['jumlah_total_saldo'] * -1, 2) }})
                                            </td>
                                        @else
                                            <td align="right">{{ number_format($rek['jumlah_total_saldo'], 2) }}</td>
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

                    <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                        <td height="15" colspan="3" align="left">
                            <b>Jumlah Liabilitas + Ekuitas </b>
                        </td>
                        <td align="right">{{ number_format($kredit, 2) }}</td>
                    </tr>
                </table>
            </div>
        </li>

        <li style="margin-top: 12px;">
            <div style="text-transform: uppercase;">
                Ketentuan Pembagian SHU :
            </div>
            <div>
                Pembagian laba yang diperoleh dalam satu tahun buku dialokasikan
                untuk
                :
            </div>
            <ol>
                <li>
                    Penambahan modal Koperasi Arthamari/ laba ditahan
                </li>
                <li>
                    Dividen
                </li>
                <li>
                    Alokasi lain yang diputuskan dalam rapat pertangung jawaban dan/atau Rapat Anggota Tahunan (RAT).
                </li>
            </ol>
        </li>

        <li style="margin-top: 12px;page-break-inside: avoid; break-inside: avoid;">
            <div style="text-transform: uppercase;">
                Penutup
            </div>
            <div style="text-align: justify; ">
                Catatan atas Laporan Keuangan (CaLK) ini merupakan bagian tidak terpisahkan dari Laporan
                Keuangan Koperasi untuk Laporan Operasi Bulan {{ $nama_tgl }}.
                Selanjutnya Catatan
                atas Laporan Keuangan ini diharapkan untuk dapat berguna bagi pihak-pihak yang berkepentingan
                (stakeholders) serta memenuhi prinsip-prinsip transparansi, akuntabilitas, pertanggungjawaban,
                independensi, dan fairness dalam pengelolaan keuangan Arthamari.
                <br><br><br>
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
            </div>
        </li>
    </ol>
@endsection

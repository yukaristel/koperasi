<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekening_0', function ($table) {
            $table->string('parent_id', 50)->nullable();
            $table->integer('lev1')->default(0);
            $table->integer('lev2')->default(0);
            $table->integer('lev3')->default(0);
            $table->integer('lev4')->default(0);
            $table->string('kode_akun', 10);
            $table->string('nama_akun', 100)->default('0');
            $table->string('jenis_mutasi', 6)->default('0');
            $table->string('saldo_awal', 100)->default('0');
            $table->primary('kode_akun');
        });

        DB::table('rekening_0')->insert([            ['111', 1, 1, 1, 1, '1.1.01.01', 'Kas Tunai', 'debet', '0'],
            ['111', 1, 1, 1, 2, '1.1.01.02', 'Kas Kecil', 'debet', '0'],
            ['111', 1, 1, 1, 3, '1.1.01.03', 'Kas di Bank BRI', 'debet', '0'],
            ['111', 1, 1, 1, 4, '1.1.01.04', 'Kas di Bank Mandiri', 'debet', '0'],
            ['112', 1, 1, 2, 1, '1.1.02.01', 'Deposito (Jatuh Tempo ≤ 12 Bulan)', 'debet', '0'],
            ['112', 1, 1, 2, 2, '1.1.02.02', 'Obligasi (Jatuh Tempo ≤ 12 Bulan)', 'debet', '0'],
            ['112', 1, 1, 2, 3, '1.1.02.03', 'Saham (Diperdagangkan / FVTPL)', 'debet', '0'],
            ['113', 1, 1, 3, 1, '1.1.03.01', 'Pinjaman yang Diberikan — Anggota', 'debet', '0'],
            ['113', 1, 1, 3, 2, '1.1.03.02', 'Pinjaman yang Diberikan — Non-Anggota', 'debet', '0'],
            ['113', 1, 1, 3, 99, '1.1.03.99', 'Piutang Lain-lain', 'debet', '0'],
            ['114', 1, 1, 4, 1, '1.1.04.01', 'Penyisihan Pinjaman Tidak Tertagih — Anggota', 'kredit', '0'],
            ['114', 1, 1, 4, 2, '1.1.04.02', 'Penyisihan Pinjaman Tidak Tertagih — Non-Anggota', 'kredit', '0'],
            ['115', 1, 1, 5, 1, '1.1.05.01', 'Pendapatan Jasa yang Masih Harus Diterima', 'debet', '0'],
            ['116', 1, 1, 6, 1, '1.1.06.01', 'Rekening Antar Kantor — Cab. Waeapo 2', 'debet', '0'],
            ['116', 1, 1, 6, 2, '1.1.06.02', 'Rekening Antar Kantor — Cab. Lolongguba', 'debet', '0'],
            ['116', 1, 1, 6, 3, '1.1.06.03', 'Rekening Antar Kantor — Cab. Waelata', 'debet', '0'],
            ['117', 1, 1, 7, 1, '1.1.07.01', 'Biaya Dibayar Dimuka (≤ 12 Bulan)', 'debet', '0'],
            ['121', 1, 2, 1, 4, '1.2.01.04', 'Investasi Unit Usaha', 'debet', '0'],
            ['122', 1, 2, 2, 1, '1.2.02.01', 'Tanah', 'debet', '0'],
            ['122', 1, 2, 2, 2, '1.2.02.02', 'Gedung dan Bangunan', 'debet', '0'],
            ['122', 1, 2, 2, 3, '1.2.02.03', 'Kendaraan dan Mesin', 'debet', '0'],
            ['122', 1, 2, 2, 4, '1.2.02.04', 'Inventaris / Peralatan Kantor', 'debet', '0'],
            ['122', 1, 2, 2, 5, '1.2.02.05', 'Perangkat Teknologi Informasi', 'debet', '0'],
            ['124', 1, 2, 4, 1, '1.2.04.01', 'Aset Hak-Guna — Bangunan', 'debet', '0'],
            ['125', 1, 2, 5, 1, '1.2.05.01', 'Biaya Pendirian Organisasi', 'debet', '0'],
            ['125', 1, 2, 5, 2, '1.2.05.02', 'Lisensi / Perangkat Lunak', 'debet', '0'],
            ['126', 1, 2, 6, 1, '1.2.06.01', 'Akumulasi Amortisasi — Biaya Pendirian', 'kredit', '0'],
            ['126', 1, 2, 6, 2, '1.2.06.02', 'Akumulasi Amortisasi — Lisensi / Perangkat Lunak', 'kredit', '0'],
            ['127', 1, 2, 7, 1, '1.2.07.01', 'Konstruksi Dalam Pengerjaan dan Uang Muka Aset', 'debet', '0'],
            ['127', 1, 2, 7, 3, '1.2.07.03', 'Aset Tidak Lancar Lain-lain', 'debet', '0'],
            ['211', 2, 1, 1, 1, '2.1.01.01', 'Simpanan — Simpanan Umum / Tabungan', 'kredit', '0'],
            ['211', 2, 1, 1, 2, '2.1.01.02', 'Simpanan — Simpanan Program', 'kredit', '0'],
            ['211', 2, 1, 1, 3, '2.1.01.03', 'Simpanan — Simpanan Berjangka / Deposito', 'kredit', '0'],
            ['212', 2, 1, 2, 1, '2.1.02.01', 'Liabilitas Operasional — Beban yang Masih Harus Dibayar', 'kredit', '0'],
            ['213', 2, 1, 3, 1, '2.1.03.01', 'Utang Pajak Penghasilan (PPh Badan)', 'kredit', '0'],
            ['214', 2, 1, 4, 1, '2.1.04.01', 'Utang SHU — Bagian Anggota', 'kredit', '0'],
            ['214', 2, 1, 4, 2, '2.1.04.02', 'Utang SHU — Dana Cadangan', 'kredit', '0'],
            ['216', 2, 1, 6, 1, '2.1.06.01', 'Liabilitas Sewa — Jatuh Tempo ≤ 12 Bulan', 'kredit', '0'],
            ['217', 2, 1, 7, 1, '2.1.07.01', 'Liabilitas Jangka Pendek Lain-lain', 'kredit', '0'],
            ['221', 2, 2, 1, 1, '2.2.01.01', 'Pinjaman Diterima dari Bank', 'kredit', '0'],
            ['221', 2, 2, 1, 2, '2.2.01.02', 'Pinjaman Diterima dari Non-Bank / Pihak Ke-3', 'kredit', '0'],
            ['222', 2, 2, 2, 1, '2.2.02.01', 'Liabilitas Imbalan Pascakerja (Pesangon)', 'kredit', '0'],
            ['223', 2, 2, 3, 1, '2.2.03.01', 'Liabilitas Sewa — Jatuh Tempo > 12 Bulan', 'kredit', '0'],
            ['311', 3, 1, 1, 1, '3.1.01.01', 'Simpanan Pokok / Modal Tetap', 'kredit', '0'],
            ['311', 3, 1, 1, 2, '3.1.01.02', 'Simpanan Wajib / Modal Tambahan', 'kredit', '0'],
            ['311', 3, 1, 1, 3, '3.1.01.03', 'Modal Penyertaan', 'kredit', '0'],
            ['312', 3, 1, 2, 1, '3.1.02.01', 'Cadangan Umum', 'kredit', '0'],
            ['312', 3, 1, 2, 2, '3.1.02.02', 'Cadangan Risiko (Cadangan Khusus)', 'kredit', '0'],
            ['313', 3, 1, 3, 1, '3.1.03.01', 'Keuntungan (Kerugian) Aktuarial Imbalan Kerja', 'kredit', '0'],
            ['313', 3, 1, 3, 2, '3.1.03.02', 'Surplus Revaluasi Aset Tetap', 'kredit', '0'],
            ['321', 3, 2, 1, 1, '3.2.01.01', 'SHU Ditahan s/d Tahun Lalu', 'kredit', '0'],
            ['321', 3, 2, 1, 2, '3.2.01.02', 'SHU Tahun Lalu Belum Dibagi', 'kredit', '0'],
            ['322', 3, 2, 2, 1, '3.2.02.01', 'SHU Berjalan (Tahun Ini)', 'kredit', '0'],
            ['411', 4, 1, 1, 1, '4.1.01.01', 'Pendapatan Jasa Pinjaman — Anggota', 'kredit', '0'],
            ['412', 4, 1, 2, 1, '4.1.02.01', 'Pendapatan Denda Pinjaman — Anggota', 'kredit', '0'],
            ['413', 4, 1, 3, 1, '4.1.03.01', 'Pendapatan Administrasi Simpanan — Anggota', 'kredit', '0'],
            ['414', 4, 1, 4, 1, '4.1.04.01', 'Pendapatan Provisi Pinjaman — Anggota', 'kredit', '0'],
            ['421', 4, 2, 1, 1, '4.2.01.01', 'Pendapatan Jasa Pinjaman — Non-Anggota', 'kredit', '0'],
            ['422', 4, 2, 2, 1, '4.2.02.01', 'Pendapatan Denda Pinjaman — Non-Anggota', 'kredit', '0'],
            ['431', 4, 3, 1, 1, '4.3.01.01', 'Pendapatan Dividen / Bagi Hasil Anak Usaha', 'kredit', '0'],
            ['441', 4, 4, 1, 1, '4.4.01.01', 'Pendapatan Bunga / Jasa Giro Bank', 'kredit', '0'],
            ['441', 4, 4, 1, 2, '4.4.01.02', 'Pendapatan Hadiah', 'kredit', '0'],
            ['441', 4, 4, 1, 3, '4.4.01.03', 'Pendapatan Hibah', 'kredit', '0'],
            ['451', 4, 5, 1, 2, '4.5.01.02', 'Keuntungan Revaluasi Instrumen Keuangan', 'kredit', '0'],
            ['511', 5, 1, 1, 1, '5.1.01.01', 'Beban Jasa Simpanan Umum / Tabungan', 'debet', '0'],
            ['511', 5, 1, 1, 2, '5.1.01.02', 'Beban Jasa Simpanan Berjangka / Deposito', 'debet', '0'],
            ['512', 5, 1, 2, 1, '5.1.02.01', 'Beban Gaji Pegawai', 'debet', '0'],
            ['512', 5, 1, 2, 4, '5.1.02.04', 'Beban BPJS Ketenagakerjaan', 'debet', '0'],
            ['512', 5, 1, 2, 5, '5.1.02.05', 'Beban BPJS Kesehatan (Tanggungan Pemberi Kerja)', 'debet', '0'],
            ['512', 5, 1, 2, 9, '5.1.02.09', 'Beban Imbalan Pascakerja / Pesangon (Akrual)', 'debet', '0'],
            ['515', 5, 1, 5, 3, '5.1.05.03', 'Beban Sewa Jangka Pendek / Nilai Rendah', 'debet', '0'],
            ['516', 5, 1, 6, 1, '5.1.06.01', 'Beban Penyisihan Pinjaman Tidak Tertagih — Anggota', 'debet', '0'],
            ['517', 5, 1, 7, 5, '5.1.07.05', 'Beban Penyusutan Aset Hak-Guna', 'debet', '0'],
            ['531', 5, 3, 1, 1, '5.3.01.01', 'Beban Bunga Pinjaman Bank', 'debet', '0'],
            ['532', 5, 3, 2, 1, '5.3.02.01', 'Beban Bunga Liabilitas Sewa', 'debet', '0'],
            ['551', 5, 5, 1, 1, '5.5.01.01', 'Taksiran PPh Final (0,5% — PP 55/2022)', 'debet', '0'],
            ['551', 5, 5, 1, 2, '5.5.01.02', 'Beban Pajak Penghasilan Badan (Non-Final)', 'debet', '0']
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('rekening_0');
    }
};
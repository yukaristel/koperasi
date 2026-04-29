-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2026 at 02:31 PM
-- Server version: 8.0.36
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siupk_koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `rekening_351`
--

CREATE TABLE `rekening_351` (
  `parent_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lev1` int DEFAULT '0',
  `lev2` int DEFAULT '0',
  `lev3` int DEFAULT '0',
  `lev4` int DEFAULT '0',
  `kode_akun` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_akun` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `jenis_mutasi` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0',
  `saldo_awal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening_351`
--

INSERT INTO `rekening_351` (`parent_id`, `lev1`, `lev2`, `lev3`, `lev4`, `kode_akun`, `nama_akun`, `jenis_mutasi`, `saldo_awal`) VALUES
('111', 1, 1, 1, 1, '1.1.01.01', 'Kas Tunai', 'debet', '0'),
('111', 1, 1, 1, 2, '1.1.01.02', 'Kas Kecil', 'debet', '0'),
('111', 1, 1, 1, 3, '1.1.01.03', 'Kas di Bank BRI', 'debet', '0'),
('111', 1, 1, 1, 4, '1.1.01.04', 'Kas di Bank Mandiri', 'debet', '0'),
('112', 1, 1, 2, 1, '1.1.02.01', 'Deposito (Jatuh Tempo ≤ 12 Bulan)', 'debet', '0'),
('112', 1, 1, 2, 2, '1.1.02.02', 'Obligasi (Jatuh Tempo ≤ 12 Bulan)', 'debet', '0'),
('112', 1, 1, 2, 3, '1.1.02.03', 'Saham (Diperdagangkan / FVTPL)', 'debet', '0'),
('113', 1, 1, 3, 1, '1.1.03.01', 'Pinjaman yang Diberikan — Anggota', 'debet', '0'),
('113', 1, 1, 3, 2, '1.1.03.02', 'Pinjaman yang Diberikan — Non-Anggota', 'debet', '0'),
('113', 1, 1, 3, 99, '1.1.03.99', 'Piutang Lain-lain', 'debet', '0'),
('114', 1, 1, 4, 1, '1.1.04.01', 'Penyisihan Pinjaman Tidak Tertagih — Anggota', 'kredit', '0'),
('114', 1, 1, 4, 2, '1.1.04.02', 'Penyisihan Pinjaman Tidak Tertagih — Non-Anggota', 'kredit', '0'),
('115', 1, 1, 5, 1, '1.1.05.01', 'Pendapatan Jasa yang Masih Harus Diterima', 'debet', '0'),
('115', 1, 1, 5, 2, '1.1.05.02', 'Pendapatan Bunga / Bagi Hasil yang Masih Harus Diterima', 'debet', '0'),
('116', 1, 1, 6, 1, '1.1.06.01', 'Rekening Antar Kantor — Cab. Waeapo 2', 'debet', '0'),
('116', 1, 1, 6, 2, '1.1.06.02', 'Rekening Antar Kantor — Cab. Lolongguba', 'debet', '0'),
('116', 1, 1, 6, 3, '1.1.06.03', 'Rekening Antar Kantor — Cab. Waelata', 'debet', '0'),
('117', 1, 1, 7, 1, '1.1.07.01', 'Biaya Dibayar Dimuka (≤ 12 Bulan)', 'debet', '0'),
('117', 1, 1, 7, 2, '1.1.07.02', 'Aset Lancar Lain-lain', 'debet', '0'),
('121', 1, 2, 1, 1, '1.2.01.01', 'Deposito (Jatuh Tempo > 12 Bulan)', 'debet', '0'),
('121', 1, 2, 1, 2, '1.2.01.02', 'Obligasi (Jatuh Tempo > 12 Bulan)', 'debet', '0'),
('121', 1, 2, 1, 3, '1.2.01.03', 'Saham Penyertaan / Investasi pada Anak Usaha', 'debet', '0'),
('121', 1, 2, 1, 4, '1.2.01.04', 'Investasi Unit Usaha', 'debet', '0'),
('122', 1, 2, 2, 1, '1.2.02.01', 'Tanah', 'debet', '0'),
('122', 1, 2, 2, 2, '1.2.02.02', 'Gedung dan Bangunan', 'debet', '0'),
('122', 1, 2, 2, 3, '1.2.02.03', 'Kendaraan dan Mesin', 'debet', '0'),
('122', 1, 2, 2, 4, '1.2.02.04', 'Inventaris / Peralatan Kantor', 'debet', '0'),
('122', 1, 2, 2, 5, '1.2.02.05', 'Perangkat Teknologi Informasi', 'debet', '0'),
('123', 1, 2, 3, 1, '1.2.03.01', 'Akumulasi Penyusutan — Gedung dan Bangunan', 'kredit', '0'),
('123', 1, 2, 3, 2, '1.2.03.02', 'Akumulasi Penyusutan — Kendaraan dan Mesin', 'kredit', '0'),
('123', 1, 2, 3, 3, '1.2.03.03', 'Akumulasi Penyusutan — Inventaris / Peralatan', 'kredit', '0'),
('123', 1, 2, 3, 4, '1.2.03.04', 'Akumulasi Penyusutan — Perangkat TI', 'kredit', '0'),
('124', 1, 2, 4, 1, '1.2.04.01', 'Aset Hak-Guna — Bangunan', 'debet', '0'),
('124', 1, 2, 4, 2, '1.2.04.02', 'Akumulasi Penyusutan Aset Hak-Guna', 'kredit', '0'),
('125', 1, 2, 5, 1, '1.2.05.01', 'Biaya Pendirian Organisasi', 'debet', '0'),
('125', 1, 2, 5, 2, '1.2.05.02', 'Lisensi / Perangkat Lunak', 'debet', '0'),
('126', 1, 2, 6, 1, '1.2.06.01', 'Akumulasi Amortisasi — Biaya Pendirian', 'kredit', '0'),
('126', 1, 2, 6, 2, '1.2.06.02', 'Akumulasi Amortisasi — Lisensi / Perangkat Lunak', 'kredit', '0'),
('127', 1, 2, 7, 1, '1.2.07.01', 'Konstruksi Dalam Pengerjaan dan Uang Muka Aset', 'debet', '0'),
('127', 1, 2, 7, 2, '1.2.07.02', 'Biaya Dibayar Dimuka (> 12 Bulan)', 'debet', '0'),
('127', 1, 2, 7, 3, '1.2.07.03', 'Aset Tidak Lancar Lain-lain', 'debet', '0'),
('211', 2, 1, 1, 1, '2.1.01.01', 'Simpanan — Simpanan Umum / Tabungan', 'kredit', '0'),
('211', 2, 1, 1, 2, '2.1.01.02', 'Simpanan — Simpanan Program', 'kredit', '0'),
('211', 2, 1, 1, 3, '2.1.01.03', 'Simpanan — Simpanan Berjangka / Deposito', 'kredit', '0'),
('212', 2, 1, 2, 1, '2.1.02.01', 'Liabilitas Operasional — Beban yang Masih Harus Dibayar', 'kredit', '0'),
('212', 2, 1, 2, 2, '2.1.02.02', 'Liabilitas Operasional — Utang kepada Pihak Ketiga', 'kredit', '0'),
('213', 2, 1, 3, 1, '2.1.03.01', 'Utang Pajak Penghasilan (PPh Badan)', 'kredit', '0'),
('213', 2, 1, 3, 2, '2.1.03.02', 'Utang Pajak Lain-lain (PPN, PPh Pasal 21, dll)', 'kredit', '0'),
('214', 2, 1, 4, 1, '2.1.04.01', 'Utang SHU — Bagian Anggota', 'kredit', '0'),
('214', 2, 1, 4, 2, '2.1.04.02', 'Utang SHU — Dana Cadangan', 'kredit', '0'),
('214', 2, 1, 4, 3, '2.1.04.03', 'Utang SHU — Dana Lain-lain', 'kredit', '0'),
('215', 2, 1, 5, 1, '2.1.05.01', 'Rekening Antar Kantor — Cab. Waeapo 2', 'kredit', '0'),
('215', 2, 1, 5, 2, '2.1.05.02', 'Rekening Antar Kantor — Cab. Lolongguba', 'kredit', '0'),
('215', 2, 1, 5, 3, '2.1.05.03', 'Rekening Antar Kantor — Cab. Waelata', 'kredit', '0'),
('216', 2, 1, 6, 1, '2.1.06.01', 'Liabilitas Sewa — Jatuh Tempo ≤ 12 Bulan', 'kredit', '0'),
('217', 2, 1, 7, 1, '2.1.07.01', 'Liabilitas Jangka Pendek Lain-lain', 'kredit', '0'),
('221', 2, 2, 1, 1, '2.2.01.01', 'Pinjaman Diterima dari Bank', 'kredit', '0'),
('221', 2, 2, 1, 2, '2.2.01.02', 'Pinjaman Diterima dari Non-Bank / Pihak Ke-3', 'kredit', '0'),
('221', 2, 2, 1, 3, '2.2.01.03', 'Pinjaman Dana Kerjasama', 'kredit', '0'),
('222', 2, 2, 2, 1, '2.2.02.01', 'Liabilitas Imbalan Pascakerja (Pesangon)', 'kredit', '0'),
('222', 2, 2, 2, 2, '2.2.02.02', 'Liabilitas Imbalan Kerja Jangka Panjang Lainnya', 'kredit', '0'),
('223', 2, 2, 3, 1, '2.2.03.01', 'Liabilitas Sewa — Jatuh Tempo > 12 Bulan', 'kredit', '0'),
('224', 2, 2, 4, 1, '2.2.04.01', 'Liabilitas Jangka Panjang Lain-lain', 'kredit', '0'),
('311', 3, 1, 1, 1, '3.1.01.01', 'Simpanan Pokok / Modal Tetap', 'kredit', '0'),
('311', 3, 1, 1, 2, '3.1.01.02', 'Simpanan Wajib / Modal Tambahan', 'kredit', '0'),
('311', 3, 1, 1, 3, '3.1.01.03', 'Modal Penyertaan', 'kredit', '0'),
('311', 3, 1, 1, 4, '3.1.01.04', 'Modal Dasar / Modal Disetor Lainnya', 'kredit', '0'),
('312', 3, 1, 2, 1, '3.1.02.01', 'Cadangan Umum', 'kredit', '0'),
('312', 3, 1, 2, 2, '3.1.02.02', 'Cadangan Risiko (Cadangan Khusus)', 'kredit', '0'),
('312', 3, 1, 2, 3, '3.1.02.03', 'Dana Lain-lain', 'kredit', '0'),
('313', 3, 1, 3, 1, '3.1.03.01', 'Keuntungan (Kerugian) Aktuarial Imbalan Kerja', 'kredit', '0'),
('313', 3, 1, 3, 2, '3.1.03.02', 'Surplus Revaluasi Aset Tetap', 'kredit', '0'),
('313', 3, 1, 3, 3, '3.1.03.03', 'Selisih Kurs Penjabaran Laporan Keuangan', 'kredit', '0'),
('321', 3, 2, 1, 1, '3.2.01.01', 'SHU Ditahan s/d Tahun Lalu', 'kredit', '0'),
('321', 3, 2, 1, 2, '3.2.01.02', 'SHU Tahun Lalu Belum Dibagi', 'kredit', '0'),
('322', 3, 2, 2, 1, '3.2.02.01', 'SHU Berjalan (Tahun Ini)', 'kredit', '0'),
('411', 4, 1, 1, 1, '4.1.01.01', 'Pendapatan Jasa Pinjaman — Anggota', 'kredit', '0'),
('412', 4, 1, 2, 1, '4.1.02.01', 'Pendapatan Denda Pinjaman — Anggota', 'kredit', '0'),
('413', 4, 1, 3, 1, '4.1.03.01', 'Pendapatan Administrasi Simpanan — Anggota', 'kredit', '0'),
('413', 4, 1, 3, 2, '4.1.03.02', 'Pendapatan Administrasi Pinjaman — Anggota', 'kredit', '0'),
('414', 4, 1, 4, 1, '4.1.04.01', 'Pendapatan Provisi Pinjaman — Anggota', 'kredit', '0'),
('421', 4, 2, 1, 1, '4.2.01.01', 'Pendapatan Jasa Pinjaman — Non-Anggota', 'kredit', '0'),
('422', 4, 2, 2, 1, '4.2.02.01', 'Pendapatan Denda Pinjaman — Non-Anggota', 'kredit', '0'),
('423', 4, 2, 3, 1, '4.2.03.01', 'Pendapatan Administrasi Pinjaman — Non-Anggota', 'kredit', '0'),
('424', 4, 2, 4, 1, '4.2.04.01', 'Pendapatan Provisi Pinjaman — Non-Anggota', 'kredit', '0'),
('431', 4, 3, 1, 1, '4.3.01.01', 'Pendapatan Dividen / Bagi Hasil Anak Usaha', 'kredit', '0'),
('431', 4, 3, 1, 2, '4.3.01.02', 'Pendapatan Usaha Lainnya', 'kredit', '0'),
('441', 4, 4, 1, 1, '4.4.01.01', 'Pendapatan Bunga / Jasa Giro Bank', 'kredit', '0'),
('441', 4, 4, 1, 2, '4.4.01.02', 'Pendapatan Hadiah', 'kredit', '0'),
('441', 4, 4, 1, 3, '4.4.01.03', 'Pendapatan Hibah', 'kredit', '0'),
('441', 4, 4, 1, 4, '4.4.01.04', 'Pendapatan Non-Usaha Lain-lain', 'kredit', '0'),
('451', 4, 5, 1, 1, '4.5.01.01', 'Keuntungan Pelepasan Aset Tetap', 'kredit', '0'),
('451', 4, 5, 1, 2, '4.5.01.02', 'Keuntungan Revaluasi Instrumen Keuangan', 'kredit', '0'),
('451', 4, 5, 1, 3, '4.5.01.03', 'Penghasilan Luar Biasa Lainnya', 'kredit', '0'),
('511', 5, 1, 1, 1, '5.1.01.01', 'Beban Jasa Simpanan Umum / Tabungan', 'debet', '0'),
('511', 5, 1, 1, 2, '5.1.01.02', 'Beban Jasa Simpanan Berjangka / Deposito', 'debet', '0'),
('512', 5, 1, 2, 1, '5.1.02.01', 'Beban Gaji Pegawai', 'debet', '0'),
('512', 5, 1, 2, 2, '5.1.02.02', 'Beban Honor Verifikasi', 'debet', '0'),
('512', 5, 1, 2, 3, '5.1.02.03', 'Beban Tunjangan Pegawai', 'debet', '0'),
('512', 5, 1, 2, 4, '5.1.02.04', 'Beban BPJS Ketenagakerjaan', 'debet', '0'),
('512', 5, 1, 2, 5, '5.1.02.05', 'Beban BPJS Kesehatan (Tanggungan Pemberi Kerja)', 'debet', '0'),
('512', 5, 1, 2, 6, '5.1.02.06', 'Beban Bonus / Insentif Pegawai', 'debet', '0'),
('512', 5, 1, 2, 7, '5.1.02.07', 'Beban Bingkisan Hari Raya', 'debet', '0'),
('512', 5, 1, 2, 8, '5.1.02.08', 'Beban Transportasi dan Perjalanan Dinas (SPPD)', 'debet', '0'),
('512', 5, 1, 2, 9, '5.1.02.09', 'Beban Imbalan Pascakerja / Pesangon (Akrual)', 'debet', '0'),
('513', 5, 1, 3, 1, '5.1.03.01', 'Beban Administrasi dan Umum', 'debet', '0'),
('513', 5, 1, 3, 2, '5.1.03.02', 'Beban Komunikasi dan Internet', 'debet', '0'),
('513', 5, 1, 3, 3, '5.1.03.03', 'Beban Listrik, Air, dan Gas', 'debet', '0'),
('513', 5, 1, 3, 4, '5.1.03.04', 'Beban Perlengkapan Kantor / ATK', 'debet', '0'),
('514', 5, 1, 4, 1, '5.1.04.01', 'Beban Rapat', 'debet', '0'),
('514', 5, 1, 4, 2, '5.1.04.02', 'Beban Pendidikan dan Pelatihan Anggota', 'debet', '0'),
('514', 5, 1, 4, 3, '5.1.04.03', 'Beban Peningkatan Kapasitas Karyawan', 'debet', '0'),
('515', 5, 1, 5, 1, '5.1.05.01', 'Beban Sewa Kantor', 'debet', '0'),
('515', 5, 1, 5, 2, '5.1.05.02', 'Beban Pemeliharaan dan Perbaikan Aset', 'debet', '0'),
('515', 5, 1, 5, 3, '5.1.05.03', 'Beban Sewa Jangka Pendek / Nilai Rendah', 'debet', '0'),
('516', 5, 1, 6, 1, '5.1.06.01', 'Beban Penyisihan Pinjaman Tidak Tertagih — Anggota', 'debet', '0'),
('516', 5, 1, 6, 2, '5.1.06.02', 'Beban Penyisihan Pinjaman Tidak Tertagih — Non-Anggota', 'debet', '0'),
('516', 5, 1, 6, 3, '5.1.06.03', 'Beban Penghapusan Pinjaman Tidak Tertagih', 'debet', '0'),
('517', 5, 1, 7, 1, '5.1.07.01', 'Beban Penyusutan Gedung dan Bangunan', 'debet', '0'),
('517', 5, 1, 7, 2, '5.1.07.02', 'Beban Penyusutan Kendaraan dan Mesin', 'debet', '0'),
('517', 5, 1, 7, 3, '5.1.07.03', 'Beban Penyusutan Inventaris / Peralatan', 'debet', '0'),
('517', 5, 1, 7, 4, '5.1.07.04', 'Beban Penyusutan Perangkat TI', 'debet', '0'),
('517', 5, 1, 7, 5, '5.1.07.05', 'Beban Penyusutan Aset Hak-Guna', 'debet', '0'),
('517', 5, 1, 7, 6, '5.1.07.06', 'Beban Amortisasi Biaya Pendirian Organisasi', 'debet', '0'),
('517', 5, 1, 7, 7, '5.1.07.07', 'Beban Amortisasi Lisensi / Perangkat Lunak', 'debet', '0'),
('518', 5, 1, 8, 1, '5.1.08.01', 'Beban Operasional Lain-lain', 'debet', '0'),
('521', 5, 2, 1, 1, '5.2.01.01', 'Beban Promosi (Brosur, Spanduk, Iklan)', 'debet', '0'),
('522', 5, 2, 2, 1, '5.2.02.01', 'Beban Sponsor', 'debet', '0'),
('522', 5, 2, 2, 2, '5.2.02.02', 'Beban Fee Marketing / Agen', 'debet', '0'),
('523', 5, 2, 3, 1, '5.2.03.01', 'Beban Pemasaran Lain-lain', 'debet', '0'),
('531', 5, 3, 1, 1, '5.3.01.01', 'Beban Bunga Pinjaman Bank', 'debet', '0'),
('531', 5, 3, 1, 2, '5.3.01.02', 'Beban Bagi Hasil Pinjaman Pihak Ke-3 (Non-Bank)', 'debet', '0'),
('531', 5, 3, 1, 3, '5.3.01.03', 'Beban Bagi Hasil Dana Kerjasama', 'debet', '0'),
('532', 5, 3, 2, 1, '5.3.02.01', 'Beban Bunga Liabilitas Sewa', 'debet', '0'),
('541', 5, 4, 1, 1, '5.4.01.01', 'Beban Pajak Bunga / Jasa Giro Bank', 'debet', '0'),
('541', 5, 4, 1, 2, '5.4.01.02', 'Beban Administrasi Bank', 'debet', '0'),
('542', 5, 4, 2, 1, '5.4.02.01', 'Kerugian Pelepasan / Penghapusan Aset Tetap', 'debet', '0'),
('543', 5, 4, 3, 1, '5.4.03.01', 'Beban Non-Usaha Lain-lain', 'debet', '0'),
('551', 5, 5, 1, 1, '5.5.01.01', 'Taksiran PPh Final (0,5% — PP 55/2022)', 'debet', '0'),
('551', 5, 5, 1, 2, '5.5.01.02', 'Beban Pajak Penghasilan Badan (Non-Final)', 'debet', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rekening_351`
--
ALTER TABLE `rekening_351`
  ADD PRIMARY KEY (`kode_akun`),
  ADD KEY `idx_parent` (`parent_id`),
  ADD KEY `idx_jenis_mutasi` (`jenis_mutasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

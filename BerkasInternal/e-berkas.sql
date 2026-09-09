-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 09, 2026 at 02:30 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-berkas`
--

-- --------------------------------------------------------

--
-- Table structure for table `berkas`
--

CREATE TABLE `berkas` (
  `id_berkas` int NOT NULL,
  `n_dokumen` varchar(255) NOT NULL,
  `tgl_kirim` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_pengirim` int DEFAULT NULL,
  `id_tujuan` int DEFAULT NULL,
  `tujuan_semua` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_terima` datetime DEFAULT NULL,
  `tujuan` varchar(20) DEFAULT NULL,
  `keterangan` text,
  `file_berkas` varchar(255) DEFAULT NULL,
  `status` enum('Dikirim','Diterima','Ditolak') NOT NULL DEFAULT 'Dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`id_berkas`, `n_dokumen`, `tgl_kirim`, `id_pengirim`, `id_tujuan`, `tujuan_semua`, `tgl_terima`, `tujuan`, `keterangan`, `file_berkas`, `status`) VALUES
(37, '12', '2026-09-09 09:16:19', 1, 8, 0, '2026-09-09 16:17:31', NULL, '12', NULL, 'Diterima'),
(38, 'testing', '2026-09-09 09:16:39', 22, 8, 0, '2026-09-09 16:17:10', NULL, '123', NULL, 'Diterima'),
(39, 'Panduan ', '2026-09-09 09:24:40', 8, 22, 0, NULL, NULL, '12', NULL, 'Ditolak'),
(40, 'huhu', '2026-09-09 09:28:41', 22, 8, 0, '2026-09-09 16:29:05', NULL, '45', NULL, 'Diterima');

-- --------------------------------------------------------

--
-- Table structure for table `komentar_berkas`
--

CREATE TABLE `komentar_berkas` (
  `id_komentar` int NOT NULL,
  `id_berkas` int NOT NULL,
  `id_user` int NOT NULL,
  `komentar` text NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `komentar_berkas`
--

INSERT INTO `komentar_berkas` (`id_komentar`, `id_berkas`, `id_user`, `komentar`, `dibuat_pada`) VALUES
(14, 31, 22, 'TES', '2026-09-09 08:49:15');

-- --------------------------------------------------------

--
-- Table structure for table `pesan_berkas`
--

CREATE TABLE `pesan_berkas` (
  `id_pesan` int NOT NULL,
  `id_berkas` int NOT NULL,
  `id_pengirim` int NOT NULL,
  `id_penerima` int NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `pesan` text NOT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `dibuat_pada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesan_berkas`
--

INSERT INTO `pesan_berkas` (`id_pesan`, `id_berkas`, `id_pengirim`, `id_penerima`, `jenis`, `pesan`, `sudah_dibaca`, `dibuat_pada`) VALUES
(29, 31, 22, 8, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 1, '2026-09-09 08:42:24'),
(30, 31, 8, 22, 'belum_dapat_diterima', 'Berkas belum dapat diterima oleh penerima.', 0, '2026-09-09 08:42:41'),
(31, 32, 8, 22, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 1, '2026-09-09 08:58:19'),
(32, 33, 22, 8, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 0, '2026-09-09 09:00:26'),
(33, 34, 8, 22, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 0, '2026-09-09 09:05:15'),
(34, 34, 22, 8, 'belum_dapat_diterima', 'Berkas belum dapat diterima oleh penerima.', 0, '2026-09-09 09:06:21'),
(35, 35, 22, 8, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 1, '2026-09-09 09:07:05'),
(38, 37, 1, 8, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 1, '2026-09-09 09:16:19'),
(39, 38, 22, 8, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 1, '2026-09-09 09:16:40'),
(40, 39, 8, 22, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 0, '2026-09-09 09:24:40'),
(41, 39, 22, 8, 'belum_dapat_diterima', 'Berkas belum dapat diterima oleh penerima.', 0, '2026-09-09 09:28:24'),
(42, 40, 22, 8, 'sistem', 'Ada berkas baru yang belum dibaca. Silakan periksa dan terima berkas.', 1, '2026-09-09 09:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bagian` varchar(50) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL,
  `hobi` varchar(100) DEFAULT NULL,
  `makanan_favorit` varchar(100) DEFAULT NULL,
  `hewan_favorit` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `bagian`, `role`, `hobi`, `makanan_favorit`, `hewan_favorit`) VALUES
(1, 'Admin', 'admin', '123', 'IT', 'admin', '', 'mie ayam', ''),
(8, 'tes', 'tes', '123456', 'p', 'pegawai', 'Tidur', 'Halal', 'Haram'),
(9, 'MUKHLIS ADI PURNOMO', '3421', '123456', 'BRANCH MANAGER DEPOK', 'pegawai', NULL, NULL, NULL),
(10, 'RAHMAD HIDAYAD', '3372', '123456', 'SERVICE SECTION HEAD DEPOK', 'pegawai', NULL, NULL, NULL),
(11, 'MIQSYAL KHALID ', '3258', '123456', 'MEMBERSHIP SECTION HEAD DEPOK', 'pegawai', NULL, NULL, NULL),
(12, 'ST.REMBULAN ARSYAD', '3327', '123456', 'FINANCE SECTION HEAD ', 'pegawai', NULL, NULL, NULL),
(13, 'TISIA BERNANTI WINDANSARI ', '3575', '123456', 'HC AND GA SECTION HEAD DEPOK ', 'pegawai', NULL, NULL, NULL),
(14, 'RYA ROSALINA PANGARIBUAN', '3492', '123456', 'VERIFICATION STAFF DEPOK', 'pegawai', NULL, NULL, NULL),
(15, 'FRANSISKA ANDRIYANI ODOS', '3657', '123456', 'SERVICES STAFF DEPOK', 'pegawai', NULL, NULL, NULL),
(16, 'NADHIA NURI TARIANI', '3579', '123456', 'CUSTOMER SERVICE DEPOK', 'pegawai', NULL, NULL, NULL),
(17, 'MUHAMMAD FARIZAL PRASETYA', '4150', '123456', 'CUSTOMER SERVICE DEPOK', 'pegawai', NULL, NULL, NULL),
(18, 'SITI HUTAMI', '3638', '123456', 'FINANCE ADMINISTRATION STAFF DEPOK', 'pegawai', NULL, NULL, NULL),
(19, 'STELLA NADINE ALVARITA ', '4061', '123456', 'CASH & PENSION REPORT VERIF.STAFF DEPOK', 'pegawai', NULL, NULL, NULL),
(20, 'BIMA SABDA PRATAMA', '3315', '123456', 'HC AND GA STAFF DEPOK', 'pegawai', NULL, NULL, NULL),
(21, 'AVILA BUNDASARI ANDARWATI', '3927', '123456', 'HC AND GA STAFF DEPOK', 'pegawai', NULL, NULL, NULL),
(22, 'tes1', 'tes1', '123', '', 'pegawai', '', '', 'KUDA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id_berkas`),
  ADD KEY `berkas_tujuan_fk` (`id_tujuan`),
  ADD KEY `berkas_pengirim_fk` (`id_pengirim`);

--
-- Indexes for table `komentar_berkas`
--
ALTER TABLE `komentar_berkas`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_berkas` (`id_berkas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pesan_berkas`
--
ALTER TABLE `pesan_berkas`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_penerima` (`id_penerima`),
  ADD KEY `id_berkas` (`id_berkas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berkas`
--
ALTER TABLE `berkas`
  MODIFY `id_berkas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `komentar_berkas`
--
ALTER TABLE `komentar_berkas`
  MODIFY `id_komentar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pesan_berkas`
--
ALTER TABLE `pesan_berkas`
  MODIFY `id_pesan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berkas`
--
ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_pengirim_fk` FOREIGN KEY (`id_pengirim`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `berkas_tujuan_fk` FOREIGN KEY (`id_tujuan`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

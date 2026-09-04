-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2026 at 05:58 AM
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
  `tgl_kirim` date NOT NULL,
  `id_pengirim` int NOT NULL,
  `id_tujuan` int DEFAULT NULL,
  `tujuan_semua` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_terima` date DEFAULT NULL,
  `tujuan` varchar(20) DEFAULT NULL,
  `keterangan` text,
  `file_berkas` varchar(255) DEFAULT NULL,
  `status` enum('Dikirim','Diterima') NOT NULL DEFAULT 'Dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `berkas`
--

INSERT INTO `berkas` (`id_berkas`, `n_dokumen`, `tgl_kirim`, `id_pengirim`, `id_tujuan`, `tujuan_semua`, `tgl_terima`, `tujuan`, `keterangan`, `file_berkas`, `status`) VALUES
(3, 'Surat undangan', '2026-09-04', 3, NULL, 1, '2026-09-04', NULL, 'apa hayo', '1788479257_logo (2).png', 'Dikirim'),
(4, 'Panduan ', '2026-09-04', 1, 3, 0, NULL, NULL, 'panduan bos', '1788481305_gelang4.jpeg', 'Dikirim');

-- --------------------------------------------------------

--
-- Table structure for table `password_changes`
--

CREATE TABLE `password_changes` (
  `id_change` int NOT NULL,
  `id_user` int NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `no_tlp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','pegawai') NOT NULL,
  `pw_diganti` datetime DEFAULT NULL,
  `pw_batas` int NOT NULL DEFAULT '0',
  `pw_waktuganti` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `bagian`, `no_tlp`, `email`, `role`, `pw_diganti`, `pw_batas`, `pw_waktuganti`) VALUES
(1, 'Admin', 'admin', '$2y$10$EuTtU20YbmUL6SIRo6G/8eOT5Daow1ZMS/uPPR..MoOxXRFgsJ9wS', 'IT', '345678', 'hadja@gmail.com', 'admin', '2026-09-04 07:20:41', 2, '2026-09-04 00:20:09'),
(2, 'Fathir', 'Fathir', '123', 'Kepesertaan', '345678', 'fathir@gmail.com', 'pegawai', NULL, 0, NULL),
(3, 'Niko', 'Niko', '$2y$10$yfzfX/tuRnOGSGZog474JO.W785rZl.Xfhm6pT/DHnVO6aReFXh4O', 'Umum', '081245678', 'Niko@gmail.com', 'pegawai', NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berkas`
--
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id_berkas`);

--
-- Indexes for table `password_changes`
--
ALTER TABLE `password_changes`
  ADD PRIMARY KEY (`id_change`),
  ADD KEY `password_changes_user` (`id_user`);

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
  MODIFY `id_berkas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_changes`
--
ALTER TABLE `password_changes`
  MODIFY `id_change` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_changes`
--
ALTER TABLE `password_changes`
  ADD CONSTRAINT `password_changes_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

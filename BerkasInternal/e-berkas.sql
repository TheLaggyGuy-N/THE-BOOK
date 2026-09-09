-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2026 at 04:24 AM
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
  `id_pengirim` int NOT NULL,
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
(3, 'Surat undangan', '2026-09-04', 3, NULL, 1, '2026-09-04', NULL, 'apa hayo', '1788479257_logo (2).png', 'Dikirim'),
(4, 'Panduan ', '2026-09-04', 1, 3, 0, NULL, NULL, 'panduan bos', '1788481305_gelang4.jpeg', 'Dikirim'),
(5, 'Panduan ', '2026-09-04', 4, NULL, 1, NULL, NULL, 'dateng ajg', '1788502852_logo (2).png', 'Dikirim');

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

-- --------------------------------------------------------

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

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `bagian`, `role`) VALUES
(1, 'Admin', 'admin', '123', 'IT', 'admin'),
(3, 'Niko', 'Niko', '123', 'Umum', 'pegawai'),
(4, 'fathir', 'Fathir', '123', 'IT', 'pegawai');
ALTER TABLE `berkas`
  ADD PRIMARY KEY (`id_berkas`);
--
-- AUTO_INCREMENT for table `komentar_berkas`
--
ALTER TABLE `komentar_berkas`
  MODIFY `id_komentar` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_berkas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

ALTER TABLE `berkas`
  ADD CONSTRAINT `berkas_pengirim_fk` FOREIGN KEY (`id_pengirim`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `berkas_tujuan_fk` FOREIGN KEY (`id_tujuan`) REFERENCES `user` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

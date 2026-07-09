-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2026 at 11:01 AM
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
-- Database: `db_gereja_gkkb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_doa`
--

CREATE TABLE `tb_doa` (
  `id_doa` int NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `isi_doa` text NOT NULL,
  `tanggal_kirim` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumentasi`
--

CREATE TABLE `tb_dokumentasi` (
  `id_foto` int NOT NULL,
  `nama_file_gambar` varchar(255) NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_dokumentasi`
--

INSERT INTO `tb_dokumentasi` (`id_foto`, `nama_file_gambar`, `id_user`) VALUES
(1, 'rekreasi.jpeg', 1),
(2, 'imlek.jpeg', 1),
(3, 'remaja.jpeg', 1),
(4, 'sm.jpeg', 1),
(5, 'ultah.jpeg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id_jadwal` int NOT NULL,
  `hari` varchar(20) NOT NULL,
  `nama_kegiatan` varchar(150) NOT NULL,
  `jam_mulai` time NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendeta`
--

CREATE TABLE `tb_pendeta` (
  `id_pendeta` int NOT NULL,
  `nama_pendeta` varchar(150) NOT NULL,
  `biodata` text NOT NULL,
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_renungan`
--

CREATE TABLE `tb_renungan` (
  `id_renungan` int NOT NULL,
  `isi_ayat` text NOT NULL,
  `referensi_ayat` varchar(100) NOT NULL,
  `gambar_renungan` varchar(255) NOT NULL,
  `tanggal_publish` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_user` int DEFAULT NULL,
  `link_sumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_renungan`
--

INSERT INTO `tb_renungan` (`id_renungan`, `isi_ayat`, `referensi_ayat`, `gambar_renungan`, `tanggal_publish`, `id_user`, `link_sumber`) VALUES
(12, 'test', 'test1', 'gmbar', '2026-06-18 10:58:21', 1, 'https://warungsatekamu.org/renungan/');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_doa`
--
ALTER TABLE `tb_doa`
  ADD PRIMARY KEY (`id_doa`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_dokumentasi`
--
ALTER TABLE `tb_dokumentasi`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_pendeta`
--
ALTER TABLE `tb_pendeta`
  ADD PRIMARY KEY (`id_pendeta`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_renungan`
--
ALTER TABLE `tb_renungan`
  ADD PRIMARY KEY (`id_renungan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_doa`
--
ALTER TABLE `tb_doa`
  MODIFY `id_doa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dokumentasi`
--
ALTER TABLE `tb_dokumentasi`
  MODIFY `id_foto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pendeta`
--
ALTER TABLE `tb_pendeta`
  MODIFY `id_pendeta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_renungan`
--
ALTER TABLE `tb_renungan`
  MODIFY `id_renungan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_doa`
--
ALTER TABLE `tb_doa`
  ADD CONSTRAINT `tb_doa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tb_dokumentasi`
--
ALTER TABLE `tb_dokumentasi`
  ADD CONSTRAINT `tb_dokumentasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `tb_jadwal_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tb_pendeta`
--
ALTER TABLE `tb_pendeta`
  ADD CONSTRAINT `tb_pendeta_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `tb_renungan`
--
ALTER TABLE `tb_renungan`
  ADD CONSTRAINT `tb_renungan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

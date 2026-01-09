-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 05:06 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jurnal`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_mengajar`
--

CREATE TABLE `jurnal_mengajar` (
  `id` int(11) NOT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jam_awal` varchar(10) DEFAULT NULL,
  `jam_akhir` varchar(10) DEFAULT NULL,
  `hadir` int(11) DEFAULT NULL,
  `tidak_hadir` int(11) DEFAULT NULL,
  `nama_tidak_hadir` text DEFAULT NULL,
  `kegiatan` text DEFAULT NULL,
  `materi` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurnal_mengajar`
--
ALTER TABLE `jurnal_mengajar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurnal_mengajar`
--
ALTER TABLE `jurnal_mengajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

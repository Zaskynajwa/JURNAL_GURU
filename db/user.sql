-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2025 at 05:07 PM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`) VALUES
(1, 'admin', 'admin123', 'admin'),
(12, '1214654', 'SMK9-08752', 'guru'),
(13, '1214655', 'SMK9-08753', 'guru'),
(14, '1214656', 'SMK9-08754', 'guru'),
(15, '1214657', 'SMK9-08755', 'guru'),
(16, '1214658', 'SMK9-08756', 'guru'),
(17, '1214659', 'SMK9-08757', 'guru'),
(18, '1214660', 'SMK9-08758', 'guru'),
(19, '1214661', 'SMK9-08759', 'guru'),
(20, '1214662', 'SMK9-08760', 'guru'),
(21, '1214663', 'SMK9-08761', 'guru'),
(22, '1214664', 'SMK9-08762', 'guru'),
(23, '1214665', 'SMK9-08763', 'guru'),
(24, '1214666', 'SMK9-08764', 'guru'),
(25, '1214667', 'SMK9-08765', 'guru'),
(26, '1214668', 'SMK9-08766', 'guru'),
(27, '1214669', 'SMK9-08767', 'guru'),
(28, '1214670', 'SMK9-08768', 'guru'),
(29, '1214671', 'SMK9-08769', 'guru'),
(30, '1214672', 'SMK9-08770', 'guru'),
(31, '1214673', 'SMK9-08771', 'guru');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

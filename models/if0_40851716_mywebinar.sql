-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql202.infinityfree.com
-- Generation Time: Jan 21, 2026 at 12:49 PM
-- Server version: 11.4.9-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_40851716_mywebinar`
--

-- --------------------------------------------------------

--
-- Table structure for table `diskusi`
--

CREATE TABLE `diskusi` (
  `id_diskusi` int(11) NOT NULL,
  `id_webinar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `tgl_kirim` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diskusi`
--

INSERT INTO `diskusi` (`id_diskusi`, `id_webinar`, `id_user`, `pesan`, `tgl_kirim`) VALUES
(1, 15, 1, 'test', '2026-01-06 01:58:11'),
(2, 26, 1, 'Test', '2026-01-06 23:23:34'),
(3, 27, 1, 'asaasas', '2026-01-10 03:15:28'),
(4, 29, 1, 'test', '2026-01-13 07:21:33'),
(5, 29, 1, 'test', '2026-01-13 07:38:19'),
(6, 15, 1, 'p', '2026-01-13 12:43:27'),
(7, 30, 1, 'test', '2026-01-13 07:02:21'),
(8, 30, 1, 'set', '2026-01-13 07:03:19'),
(9, 30, 4, 'Test', '2026-01-14 23:43:39'),
(10, 31, 4, 'test', '2026-01-16 11:54:06'),
(11, 25, 1, 'Test', '2026-01-18 04:10:37'),
(12, 27, 1, 'Test', '2026-01-18 15:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_peserta` varchar(100) DEFAULT NULL,
  `id_webinar` int(11) NOT NULL,
  `tgl_daftar` datetime DEFAULT current_timestamp(),
  `status_hadir` tinyint(1) DEFAULT 0,
  `status_peserta` enum('Umum','Mahasiswa') DEFAULT 'Umum',
  `universitas` varchar(150) DEFAULT NULL,
  `no_telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_user`, `nama_peserta`, `id_webinar`, `tgl_daftar`, `status_hadir`, `status_peserta`, `universitas`, `no_telp`) VALUES
(2, 3, 'Bernard', 15, '2026-01-05 00:31:19', 0, 'Mahasiswa', 'Universitas Pelita Bangsa', '08912345678'),
(3, 1, 'Reynaldi', 15, '2026-01-06 01:54:37', 0, 'Mahasiswa', 'Universitas Pelita Bangsa', '083608774256'),
(4, 1, 'Reynaldi', 25, '2026-01-06 02:58:35', 0, 'Mahasiswa', 'Universitas Pelita Bangsa', '0895123456'),
(5, 1, 'Reynaldi Nugraha Putra', 26, '2026-01-06 08:55:14', 0, 'Mahasiswa', 'Universitas Pelita Bangsa', '089608774256'),
(6, 4, 'admin123', 26, '2026-01-06 09:06:03', 0, 'Mahasiswa', 'Universitas Indonesia', '0812345678'),
(10, 4, 'admin123', 31, '2026-01-16 09:26:35', 0, 'Umum', '-', '0812121212121'),
(11, 4, 'admin123', 30, '2026-01-16 09:50:06', 0, 'Umum', '-', '054545'),
(12, 1, 'Reynaldi Nugraha Putra', 31, '2026-01-16 19:51:35', 0, 'Mahasiswa', 'Universitas Pelita Bangsa', '089608774256'),
(13, 1, 'Reynaldi Nugraha Putra', 30, '2026-01-18 04:08:52', 0, 'Mahasiswa', 'Universitas Pelita Bangsa ', '089608774256'),
(14, 1, 'Reynaldi Nugraha Putra', 27, '2026-01-18 15:24:20', 0, 'Mahasiswa', 'Universitas Pelita Bangsa ', '089123456789');

-- --------------------------------------------------------

--
-- Table structure for table `penyelenggara`
--

CREATE TABLE `penyelenggara` (
  `id_penyelenggara` int(11) NOT NULL,
  `nama_penyelenggara` varchar(100) NOT NULL,
  `email_penyelenggara` varchar(100) NOT NULL,
  `password_penyelenggara` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyelenggara`
--

INSERT INTO `penyelenggara` (`id_penyelenggara`, `nama_penyelenggara`, `email_penyelenggara`, `password_penyelenggara`) VALUES
(1, 'Admin Utama', 'admin@mywebinar.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id_peserta` int(11) NOT NULL,
  `nama_peserta` varchar(100) NOT NULL,
  `email_peserta` varchar(100) NOT NULL,
  `password_peserta` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sertifikat`
--

CREATE TABLE `sertifikat` (
  `id_sertifikat` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `tgl_terbit` datetime DEFAULT current_timestamp(),
  `kode_sertifikat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `tgl_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto_user` varchar(255) DEFAULT 'default.png',
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `email_user`, `password_user`, `tgl_daftar`, `foto_user`, `role`) VALUES
(1, 'Reynaldi Nugraha Putra', 'reynaldinp18@gmail.com', '$2y$10$8nYjEsSUx0AyxBL1s0Zc9urelbsEScyF3bkSSYZGKXQiLJxByn1UW', '2026-01-01 18:16:36', 'profile_1_1768269806.jpeg', 'user'),
(2, 'Reynaldi Nugraha Putra', 'hatakereynaldi1@gmail.com', '$2y$10$MAUPGHIrZWGxtS6gIjVJpufAnrabmWh4z47TEssnV638V0/HTXnOy', '2026-01-01 18:19:07', 'default.png', 'user'),
(3, 'Bernard', 'bernard@gmail.com', '$2y$10$9y.vi5MgSDX1NB.7.1vbyeouTysdSofiX4IX4GX2lJknN.ZVg2bUe', '2026-01-04 17:30:32', 'default.png', 'user'),
(4, 'admin123', 'admin123@gmail.com', '$2y$10$hP145qw3E72stEvEYYuuTefi/Vgmbqj3pmz6JnyQJDjkzyEJkPh4i', '2026-01-05 19:19:43', 'profile_4_1768463185.jpg', 'admin'),
(5, 'aa', 'aa@gmail.com', '$2y$10$LM7MbFvyL5Bs9HLpO4ntju7swO9fTkW3t5XCKgBgkdCOUZ7QYDhDS', '2026-01-15 04:17:18', 'default.png', 'user'),
(6, 'arenpi', 'arenpi18@gmail.com', '$2y$10$0mVQA.IIzcOwXGmGVpM14.Iu2yRNRjRKCAHIG4027fqCl8vavQIG2', '2026-01-18 14:51:34', 'default.png', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `webinar`
--

CREATE TABLE `webinar` (
  `id_webinar` int(11) NOT NULL,
  `id_penyelenggara` int(11) NOT NULL,
  `judul_webinar` varchar(255) NOT NULL,
  `narasumber` varchar(100) DEFAULT NULL,
  `poster_webinar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_pelaksanaan` date NOT NULL,
  `jam_pelaksanaan` time NOT NULL,
  `kuota` int(11) NOT NULL,
  `link_webinar` varchar(255) DEFAULT NULL,
  `sertifikat` enum('Ya','Tidak') DEFAULT 'Tidak',
  `template_sertifikat` varchar(255) DEFAULT NULL,
  `latar_belakang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `webinar`
--

INSERT INTO `webinar` (`id_webinar`, `id_penyelenggara`, `judul_webinar`, `narasumber`, `poster_webinar`, `deskripsi`, `tgl_pelaksanaan`, `jam_pelaksanaan`, `kuota`, `link_webinar`, `sertifikat`, `template_sertifikat`, `latar_belakang`) VALUES
(15, 1, 'Sharing Experience With Project Manager', 'Tejo Nugroho', 'poster_1767496244_6959da3448fc6.jpg', 'deskripsiPPPP\r\nPPPP', '2026-01-04', '00:10:00', 50, 'https://meet.google.com/qjq-rcrg-xis', 'Tidak', '', NULL),
(24, 4, '\"Peran Hukum Termodinamika dalam Industri\"', 'Rizal Lutfi Hendi Yulianto S.T', 'poster_1767643001_695c1779a70d6.jpg', 'Test', '2026-01-06', '08:46:00', 50, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1767643001_695c1779a7c4b.png', NULL),
(25, 1, '\"Peran Hukum Termodinamika dalam Industri\"', 'Rizal Lutfi Hendi Yulianto S.T', 'poster_1767643087_695c17cfcdb2a.jpg', 'Test', '2026-01-06', '09:57:00', 50, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1767643087_695c17cfce366.png', NULL),
(26, 1, '\"Peran Hukum Termodinamika dalam Industri\"', 'Rizal Lutfi Hendi Yulianto S.T', 'poster_1767644715_695c1e2b9021e.jpg', 'Test', '2026-01-06', '10:30:00', 20, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1767644715_695c1e2b9155a.png', 'latar_1767644715_695c1e2b91979.png'),
(27, 1, 'Test', 'Tejo Nugroho', 'poster_1767838431_695f12dfb7072.jpg', 'Test', '2026-01-08', '01:13:00', 20, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1767838431_695f12dfb8caa.png', 'latar_1767838431_695f12dfb91af.png'),
(29, 1, 'Test 2', 'test2', 'poster_1768256959_696575bf89d99.jpg', 'test 2', '2026-01-13', '00:28:00', 20, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1768256959_696575bf8a25c.png', 'latar_1768256959_696575bf8a6c2.png'),
(30, 1, 'Menyelam', 'test', 'poster_1768294949_69660a25c74b2.jpg', 'test', '2026-01-29', '23:02:00', 50, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1768294949_69660a25c7e40.png', 'latar_1768294949_69660a25c82c6.png'),
(31, 1, 'Menyelam', 'Rizal Lutfi Hendi Yulianto S.T', 'poster_1768312757_69664fb527af9.jpg', 'test', '2026-01-13', '12:57:00', 50, 'https://meet.google.com/qjq-rcrg-xis', 'Ya', 'cert_1768312757_69664fb527d14.png', 'latar_1768312757_69664fb527fef.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD PRIMARY KEY (`id_diskusi`),
  ADD KEY `id_webinar` (`id_webinar`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_peserta` (`id_user`),
  ADD KEY `id_webinar` (`id_webinar`);

--
-- Indexes for table `penyelenggara`
--
ALTER TABLE `penyelenggara`
  ADD PRIMARY KEY (`id_penyelenggara`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`);

--
-- Indexes for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD PRIMARY KEY (`id_sertifikat`),
  ADD UNIQUE KEY `kode_sertifikat` (`kode_sertifikat`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`);

--
-- Indexes for table `webinar`
--
ALTER TABLE `webinar`
  ADD PRIMARY KEY (`id_webinar`),
  ADD KEY `id_penyelenggara` (`id_penyelenggara`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diskusi`
--
ALTER TABLE `diskusi`
  MODIFY `id_diskusi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `penyelenggara`
--
ALTER TABLE `penyelenggara`
  MODIFY `id_penyelenggara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sertifikat`
--
ALTER TABLE `sertifikat`
  MODIFY `id_sertifikat` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `webinar`
--
ALTER TABLE `webinar`
  MODIFY `id_webinar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diskusi`
--
ALTER TABLE `diskusi`
  ADD CONSTRAINT `diskusi_ibfk_1` FOREIGN KEY (`id_webinar`) REFERENCES `webinar` (`id_webinar`) ON DELETE CASCADE,
  ADD CONSTRAINT `diskusi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `fk_daftar_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_daftar_webinar` FOREIGN KEY (`id_webinar`) REFERENCES `webinar` (`id_webinar`) ON DELETE CASCADE;

--
-- Constraints for table `sertifikat`
--
ALTER TABLE `sertifikat`
  ADD CONSTRAINT `fk_sertifikat_daftar` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Constraints for table `webinar`
--
ALTER TABLE `webinar`
  ADD CONSTRAINT `fk_webinar_users` FOREIGN KEY (`id_penyelenggara`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 03:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magang`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_jurusan` varchar(150) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `id_user`, `kode`, `nama_jurusan`, `keterangan`) VALUES
(1, 5, '', 'Teknologi Informasi', '');

-- --------------------------------------------------------

--
-- Table structure for table `logbook`
--

CREATE TABLE `logbook` (
  `id_logbook` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kegiatan` text NOT NULL,
  `dokumentasi` varchar(255) DEFAULT NULL,
  `status` enum('pending','disetujui') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lowongan`
--

CREATE TABLE `lowongan` (
  `id_lowongan` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `judul_lowongan` varchar(150) NOT NULL,
  `kuota` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `lokasi` varchar(159) NOT NULL,
  `status` enum('dibuka','ditutup','penuh') NOT NULL,
  `persyaratan` text NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nim` varchar(100) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL,
  `angkatan` year(4) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `id_user`, `nim`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `id_jurusan`, `id_prodi`, `angkatan`, `kelas`, `email`, `no_hp`, `create_at`) VALUES
(1, 4, '2401093017', 'Mila Huriyati Fathina', '2005-11-01', 'perempuan', 'Pauh', 1, 1, '2024', '2C', 'mila@gmail.com', '00000', '2026-01-18 03:04:31'),
(2, 7, '2401091030', 'Ibra Andria', '0000-00-00', 'laki-laki', '', 0, 1, '0000', '', '', '0812345678', '2026-01-19 11:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa_berkas`
--

CREATE TABLE `mahasiswa_berkas` (
  `id_berkas` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jenis_berkas` varchar(50) NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `alamat_perusahaan` text NOT NULL,
  `status` enum('menunggu_verifikasi','verifikasi_ditolak','menunggu_surat_permohonan','pending','diterima','ditolak') NOT NULL,
  `file_balasan` varchar(255) DEFAULT NULL,
  `jenis` enum('mandiri','lowongan') NOT NULL,
  `id_surat_permohonan` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan`
--

CREATE TABLE `perusahaan` (
  `id_perusahaan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_perusahaan` varchar(200) NOT NULL,
  `bidang` varchar(150) NOT NULL,
  `keterangan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `contact_person` varchar(200) NOT NULL,
  `alamat_perusahaan` text NOT NULL,
  `is_registered` enum('no','yes') NOT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `id_user`, `nama_perusahaan`, `bidang`, `keterangan`, `foto`, `email`, `no_hp`, `contact_person`, `alamat_perusahaan`, `is_registered`, `create_at`) VALUES
(1, 2, 'PT. Mencari Cinta Sejati', '', '', '', 'mcs@gmail.com', '1234567890', 'ayana', 'Jl. Dr. Moh. Hatta, Binuang Kp.Dalam, Kec. Pauh, Kota Padang, Sumatera Barat 25176', 'yes', '2025-12-21 20:13:13'),
(2, 3, 'PT. Malika Jaya', '', '', '', 'hrd@perusahaan.com', '00000', 'Sinta', '', 'yes', '2025-12-23 14:41:34'),
(3, 6, 'PT. Bhinneka', '', '', '', 'bhinneka@gmail.com', '00000', 'Sinta', '', 'yes', '2026-01-18 09:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `id_jurusan`, `nama_prodi`, `status`) VALUES
(1, 1, 'D3 Manajemen Informatika', 'tidak aktif'),
(2, 1, 'D3 Teknik Komputer', 'aktif'),
(3, 1, 'D4 TRPL', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id_surat_permohonan` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `jenis_surat` enum('permohonan','pelaksanaan') NOT NULL,
  `nomor_surat` varchar(100) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `file_surat` varchar(255) NOT NULL,
  `status` enum('aktif','selesai') NOT NULL DEFAULT 'aktif',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  `roles` enum('super_admin','admin_jurusan','mahasiswa','perusahaan') NOT NULL,
  `foto` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `status` enum('Pending','Verified','Rejected') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `created_at`, `update_at`, `roles`, `foto`, `no_hp`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '$2a$12$CUEeTQnOwGzepLTQs/YXnOJiIfVf8hmgBVmqwU/DAdZOezaMLuRMy', '2025-12-20 04:58:12', '2025-12-20 04:58:12', 'super_admin', '', '', 'Pending'),
(2, 'store', 'mcs@gmail.com', '$2y$10$dZ6OMNppR8HkaHihoFU0Yuk4fiwA4O3Ih2xMKM9UpmsV57Lpik4bW', '2025-12-21 20:13:13', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending'),
(3, 'malika', 'hrd@perusahaan.com', '$2y$10$Zzd2aJd4nC4tiqRgwmDiCOMiIIQJBJyPoKR1dvAHOBh0l5uYMO0e6', '2025-12-23 14:41:34', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending'),
(4, 'mila', 'mila@gmail.com', '$2a$12$8MIDumtbrCNpSxYF6u0Ue.ehKMbK93Su6JMkR2HCQ9u8uGW2VhQ2y', '2026-01-17 12:20:34', '2026-01-17 12:20:34', 'mahasiswa', 'profile_4_1768658726.jpeg', '00000', 'Verified'),
(5, 'ti', 'ti@gmail.com', '$2a$12$q81ZrxKM7wiJk76hGLbrzen.R8pDkiyq8TJ920hCB7HJOhtneUhN2', '2026-01-18 02:10:42', '2026-01-18 02:10:42', 'admin_jurusan', '', '00000', ''),
(6, 'Bhinneka', 'bhinneka@gmail.com', '$2y$10$FrfSC.TvcYHlpdgsZ5GXPOoNckKmVKTkOOVk0WZaA1TVXCiA0.Nea', '2026-01-18 09:37:30', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending'),
(7, 'ibra', 'ibrabisnis756@gmail.com', '$2y$10$pW/OLPgn5O2NyWcxL.6q2ueQ4F/mFlhZpZcujvR4L1VdOJOE1U58O', '2026-01-19 11:13:04', '0000-00-00 00:00:00', 'mahasiswa', '', '', 'Verified'),
(8, 'mesin', 'mesin@gmail.com', '$2y$10$dRhJkex9N4xofpaVPxFl3eWmynDYAvgjCH7IGqHMUMg6PbxezzqGa', '2026-01-19 11:58:12', '0000-00-00 00:00:00', 'admin_jurusan', '', '', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `logbook`
--
ALTER TABLE `logbook`
  ADD PRIMARY KEY (`id_logbook`);

--
-- Indexes for table `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id_lowongan`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  ADD PRIMARY KEY (`id_berkas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indexes for table `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id_surat_permohonan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id_logbook` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id_lowongan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat_permohonan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  ADD CONSTRAINT `mahasiswa_berkas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

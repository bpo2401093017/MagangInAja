-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 07:18 PM
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
(1, 5, '', 'Teknologi Informasi', ''),
(5, 12, '-', 'Adminitrasi Niaga', ''),
(7, 15, '-', 'Teknik Sipil', '');

-- --------------------------------------------------------

--
-- Table structure for table `lamaran`
--

CREATE TABLE `lamaran` (
  `id_lamaran` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `tgl_lamar` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `file_cv` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lamaran`
--

INSERT INTO `lamaran` (`id_lamaran`, `id_mahasiswa`, `id_lowongan`, `tgl_lamar`, `status`, `file_cv`) VALUES
(1, 1, 1, '2026-01-19 23:41:04', 'pending', NULL),
(2, 1, 1, '2026-01-19 23:41:05', 'pending', NULL),
(3, 4, 3, '2026-01-20 01:08:15', 'pending', NULL);

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

--
-- Dumping data for table `logbook`
--

INSERT INTO `logbook` (`id_logbook`, `id_mahasiswa`, `id_perusahaan`, `tanggal`, `kegiatan`, `dokumentasi`, `status`, `created_at`) VALUES
(2, 3, 4, '2026-01-19', 'asdasd', 'log_1768845378_3.png', 'disetujui', '2026-01-19 17:56:18'),
(3, 3, 4, '2026-01-19', 'laporan 1', 'log_1768846169_3.png', 'disetujui', '2026-01-19 18:09:29');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `jenis_lowongan` varchar(50) DEFAULT 'Magang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lowongan`
--

INSERT INTO `lowongan` (`id_lowongan`, `id_perusahaan`, `judul_lowongan`, `kuota`, `id_jurusan`, `id_prodi`, `lokasi`, `status`, `persyaratan`, `tanggal_mulai`, `tanggal_selesai`, `created_at`, `jenis_lowongan`) VALUES
(1, 4, 'Perbaikan Mesin', 10, 2, 0, 'Limau Manis', 'dibuka', 'Di butuhkan tamatan :\r\n1. D3 Teknik Mesin\r\n2. D4 Teknik Mesin', '2026-01-01', '2026-01-31', '2026-01-19 15:44:00', 'Magang'),
(2, 4, 'Ui Ux Web', 5, 5, 0, 'Limau Manis', 'dibuka', '1. D4 Bisnis digital\r\n\r\nDI BUTUHKAN MAHASISWA DENGAN SKILL EDITING WEB', '2026-01-10', '2026-01-31', '2026-01-19 16:17:52', 'Magang'),
(3, 5, 'Enginering', 3, 7, 0, 'ganting', 'dibuka', 'Wajib mengusai skill tukang', '2026-01-01', '2026-03-01', '2026-01-19 18:06:02', 'Magang');

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
(2, 7, '2401091030', 'Ibra Andria', '0000-00-00', 'laki-laki', '', 0, 1, '0000', '', '', '0812345678', '2026-01-19 11:13:04'),
(3, 13, '2401091029', 'Sinta', '2006-01-31', 'perempuan', 'padang', 5, 6, '2024', '2A', 'sinta@gmail.com', '08123456789', '2026-01-19 23:27:11'),
(4, 16, '2401091028', 'ririn', '0000-00-00', 'laki-laki', '', 0, 8, '0000', '', '', '08123456788', '2026-01-20 01:06:46');

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

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id_pengajuan`, `id_mahasiswa`, `id_perusahaan`, `id_lowongan`, `nama_perusahaan`, `alamat_perusahaan`, `status`, `file_balasan`, `jenis`, `id_surat_permohonan`, `create_at`) VALUES
(1, 3, 4, 2, 'PT Bumi', 'padang', 'diterima', NULL, 'lowongan', 0, '2026-01-19 16:29:14');

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
  `website` varchar(100) DEFAULT NULL,
  `is_registered` enum('no','yes') NOT NULL,
  `create_at` datetime NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `id_user`, `nama_perusahaan`, `bidang`, `keterangan`, `foto`, `email`, `no_hp`, `contact_person`, `alamat_perusahaan`, `website`, `is_registered`, `create_at`, `deskripsi`) VALUES
(1, 2, 'PT. Mencari Cinta Sejati', '', '', '', 'mcs@gmail.com', '1234567890', 'ayana', 'Jl. Dr. Moh. Hatta, Binuang Kp.Dalam, Kec. Pauh, Kota Padang, Sumatera Barat 25176', NULL, 'yes', '2025-12-21 20:13:13', NULL),
(2, 3, 'PT. Malika Jaya', '', '', '', 'hrd@perusahaan.com', '00000', 'Sinta', '', NULL, 'yes', '2025-12-23 14:41:34', NULL),
(3, 6, 'PT. Bhinneka', '', '', '', 'bhinneka@gmail.com', '00000', 'Sinta', '', NULL, 'yes', '2026-01-18 09:37:30', NULL),
(4, 9, 'PT Bumi', '', '', 'logo_1768839382_4.png', 'bumi@gmail.com', '081211223343', 'Agung', 'padang', NULL, 'yes', '2026-01-19 22:21:00', NULL),
(5, 14, 'PT HIJAU', '', '', '', 'hijau@gmail.com', '08123456790', 'Adit', '', NULL, 'yes', '2026-01-20 01:03:43', NULL);

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
(3, 1, 'D4 TRPL', 'aktif'),
(6, 5, 'D4 Bisnis digital', 'aktif'),
(7, 5, 'D4 Pariwisata', 'aktif'),
(8, 7, 'D4 Manufakturing', 'aktif');

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
(8, 'mesin', 'mesin@gmail.com', '$2y$10$dRhJkex9N4xofpaVPxFl3eWmynDYAvgjCH7IGqHMUMg6PbxezzqGa', '2026-01-19 11:58:12', '0000-00-00 00:00:00', 'admin_jurusan', '', '0812345678', 'Pending'),
(9, 'bumi', 'bumi@gmail.com', '$2y$10$0fh8Ib0SLdff/oL/8Mv/9eU4/Dted9QCv5KVT9QnxFvEU3ZBa1UE.', '2026-01-19 22:21:00', '0000-00-00 00:00:00', 'perusahaan', 'logo_1768839382_4.png', '08123456789', 'Pending'),
(12, 'an', 'an@gmail.com', '$2y$10$aBIz8n1XOFuLXqplQ/ygtuZiexJMVdQw9/tEyRIbmX7c5uQakXB1K', '2026-01-19 23:13:27', '0000-00-00 00:00:00', 'admin_jurusan', '', '6212345678', 'Pending'),
(13, 'sinta', 'sinta@gmail.com', '$2y$10$s4XJHiykwJAdbPwX3EAyUu3ABwKre1qz9/DuNiJ4hJGtZ/.OV5sKy', '2026-01-19 23:27:11', '0000-00-00 00:00:00', 'mahasiswa', 'profile_13_1768844166.png', '08123456789', 'Verified'),
(14, 'hijau', 'hijau@gmail.com', '$2y$10$xF5JgkerJ0pB56uy5ErM0O4SxlCovifJt9nfj0L9Ke4UrUz8SMCKi', '2026-01-20 01:03:42', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending'),
(15, 'sipil', 'sipil@gmail.com', '$2y$10$8ApRzMh55I1eNMgrgDy7meqzqyQ0W2R9NVmWPwQjVnTydx6ysF5om', '2026-01-20 01:04:16', '0000-00-00 00:00:00', 'admin_jurusan', '', '0812345678', 'Pending'),
(16, 'ririn', 'ririn@gmail.com', '$2y$10$6SKNogay7q.b5nhq.jNcIeLtgttjSu5Qx6RIOAIgdQv.hpoR6wVVS', '2026-01-20 01:06:46', '0000-00-00 00:00:00', 'mahasiswa', '', '', 'Verified');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `lamaran`
--
ALTER TABLE `lamaran`
  ADD PRIMARY KEY (`id_lamaran`);

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
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lamaran`
--
ALTER TABLE `lamaran`
  MODIFY `id_lamaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logbook`
--
ALTER TABLE `logbook`
  MODIFY `id_logbook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id_lowongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id_surat_permohonan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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

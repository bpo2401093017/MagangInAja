-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jan 2026 pada 10.01
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama_jurusan` varchar(150) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `id_user`, `kode`, `nama_jurusan`, `keterangan`) VALUES
(1, 5, '', 'Teknologi Informas', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
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
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `id_user`, `nim`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `id_jurusan`, `id_prodi`, `angkatan`, `kelas`, `email`, `no_hp`, `create_at`) VALUES
(1, 4, '2401093017', 'Mila Huriyati Fathina', '2005-11-01', 'perempuan', 'Pauh', 1, 1, '2024', '2C', 'mila@gmail.com', '00000', '2026-01-18 03:04:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa_berkas`
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
-- Struktur dari tabel `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `nama_perusahaan` varchar(100) NOT NULL,
  `alamat_perusahaan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `perusahaan`
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
-- Dumping data untuk tabel `perusahaan`
--

INSERT INTO `perusahaan` (`id_perusahaan`, `id_user`, `nama_perusahaan`, `bidang`, `keterangan`, `foto`, `email`, `no_hp`, `contact_person`, `alamat_perusahaan`, `is_registered`, `create_at`) VALUES
(1, 2, 'PT. Mencari Cinta Sejati', '', '', '', 'mcs@gmail.com', '1234567890', 'ayana', 'Jl. Dr. Moh. Hatta, Binuang Kp.Dalam, Kec. Pauh, Kota Padang, Sumatera Barat 25176', 'yes', '2025-12-21 20:13:13'),
(2, 3, 'PT. Malika Jaya', '', '', '', 'hrd@perusahaan.com', '00000', 'Sinta', '', 'yes', '2025-12-23 14:41:34'),
(3, 6, 'PT. Bhinneka', '', '', '', 'bhinneka@gmail.com', '00000', 'Sinta', '', 'yes', '2026-01-18 09:37:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `status` enum('aktif','tidak aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `id_jurusan`, `nama_prodi`, `status`) VALUES
(1, 1, 'D3 Manajemen Informatika', 'tidak aktif'),
(2, 1, 'D3 Teknik Komputer', 'aktif'),
(3, 1, 'D4 TRPL', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `created_at`, `update_at`, `roles`, `foto`, `no_hp`, `status`) VALUES
(1, 'admin', 'admin@gmail.com', '$2a$12$CUEeTQnOwGzepLTQs/YXnOJiIfVf8hmgBVmqwU/DAdZOezaMLuRMy', '2025-12-20 04:58:12', '2025-12-20 04:58:12', 'super_admin', '', '', 'Pending'),
(2, 'store', 'mcs@gmail.com', '$2y$10$dZ6OMNppR8HkaHihoFU0Yuk4fiwA4O3Ih2xMKM9UpmsV57Lpik4bW', '2025-12-21 20:13:13', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending'),
(3, 'malika', 'hrd@perusahaan.com', '$2y$10$Zzd2aJd4nC4tiqRgwmDiCOMiIIQJBJyPoKR1dvAHOBh0l5uYMO0e6', '2025-12-23 14:41:34', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending'),
(4, 'mila', 'mila@gmail.com', '$2a$12$8MIDumtbrCNpSxYF6u0Ue.ehKMbK93Su6JMkR2HCQ9u8uGW2VhQ2y', '2026-01-17 12:20:34', '2026-01-17 12:20:34', 'mahasiswa', 'profile_4_1768658726.jpeg', '00000', 'Verified'),
(5, 'ti', 'ti@gmail.com', '$2a$12$q81ZrxKM7wiJk76hGLbrzen.R8pDkiyq8TJ920hCB7HJOhtneUhN2', '2026-01-18 02:10:42', '2026-01-18 02:10:42', 'admin_jurusan', '', '00000', ''),
(6, 'Bhinneka', 'bhinneka@gmail.com', '$2y$10$FrfSC.TvcYHlpdgsZ5GXPOoNckKmVKTkOOVk0WZaA1TVXCiA0.Nea', '2026-01-18 09:37:30', '0000-00-00 00:00:00', 'perusahaan', '', '', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indeks untuk tabel `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  ADD PRIMARY KEY (`id_berkas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`);

--
-- Indeks untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  ADD PRIMARY KEY (`id_perusahaan`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  MODIFY `id_berkas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `perusahaan`
--
ALTER TABLE `perusahaan`
  MODIFY `id_perusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `mahasiswa_berkas`
--
ALTER TABLE `mahasiswa_berkas`
  ADD CONSTRAINT `mahasiswa_berkas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

<?php
session_start();
require_once '../config.php';

// 1. Pastikan yang login adalah MAHASISWA
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['id_lowongan'])) {
    $id_lowongan = mysqli_real_escape_string($conn, $_GET['id_lowongan']);
    $id_user = $_SESSION['user_id'];

    // 2. Ambil id_mahasiswa berdasarkan user yang sedang login
    $q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
    $d_mhs = mysqli_fetch_assoc($q_mhs);
    $id_mahasiswa = $d_mhs['id_mahasiswa'];

    // 3. Ambil id_perusahaan dari lowongan tersebut (PENTING)
    // Agar data ini muncul di dashboard perusahaan yang tepat
    $q_low = mysqli_query($conn, "SELECT id_perusahaan FROM lowongan WHERE id_lowongan = '$id_lowongan'");
    $d_low = mysqli_fetch_assoc($q_low);
    $id_perusahaan = $d_low['id_perusahaan'];

    // 4. Masukkan data baru ke tabel 'pengajuan'
    $query = "INSERT INTO pengajuan (id_mahasiswa, id_lowongan, id_perusahaan, status, create_at) 
              VALUES ('$id_mahasiswa', '$id_lowongan', '$id_perusahaan', 'menunggu_verifikasi', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: daftar_lowongan.php?msg=berhasil_melamar");
    } else {
        echo "Gagal menyimpan lamaran: " . mysqli_error($conn);
    }
} else {
    header("Location: daftar_lowongan.php");
}
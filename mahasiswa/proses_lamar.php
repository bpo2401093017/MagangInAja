<?php
session_start();
require_once '../config.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// 2. Cek apakah ada ID Lowongan yang dikirim
if (isset($_GET['id_lowongan'])) {
    
    $id_lowongan = mysqli_real_escape_string($conn, $_GET['id_lowongan']);
    $id_user = $_SESSION['user_id'];

    // 3. Ambil ID Mahasiswa yang Benar
    $q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
    $d_mhs = mysqli_fetch_assoc($q_mhs);

    if (!$d_mhs) {
        echo "<script>alert('Lengkapi Biodata Mahasiswa Dulu!'); window.location='lihat_profile.php';</script>";
        exit;
    }

    $id_mahasiswa = $d_mhs['id_mahasiswa'];

    // 4. Cek apakah sudah pernah melamar lowongan ini? (Agar tidak dobel)
    $cek_dobel = mysqli_query($conn, "SELECT id_lamaran FROM lamaran WHERE id_mahasiswa = '$id_mahasiswa' AND id_lowongan = '$id_lowongan'");
    
    if (mysqli_num_rows($cek_dobel) > 0) {
        echo "<script>
            alert('Anda sudah pernah melamar posisi ini sebelumnya.');
            window.location = 'riwayat_lamaran.php';
        </script>";
        exit;
    }

    // 5. INSERT DATA REAL KE DATABASE
    // Status default = pending
    $query_insert = "INSERT INTO lamaran (id_mahasiswa, id_lowongan, tgl_lamar, status) 
                     VALUES ('$id_mahasiswa', '$id_lowongan', NOW(), 'pending')";

    if (mysqli_query($conn, $query_insert)) {
        // SUKSES
        echo "<script>
            alert('Berhasil Melamar! Lamaran Anda telah dikirim ke perusahaan.');
            window.location = 'riwayat_lamaran.php';
        </script>";
    } else {
        // GAGAL INSERT
        echo "Error Database: " . mysqli_error($conn);
    }

} else {
    // Tidak ada ID Lowongan
    header("Location: lowongan.php");
}
?>
<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['lamar'])) {
    $id_user = $_SESSION['user_id'];
    
    $q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
    $d_mhs = mysqli_fetch_assoc($q_mhs);
    $id_mahasiswa = $d_mhs['id_mahasiswa'];

    $id_lowongan = mysqli_real_escape_string($conn, $_POST['id_lowongan']);
    $id_perusahaan = mysqli_real_escape_string($conn, $_POST['id_perusahaan']);
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $alamat_perusahaan = mysqli_real_escape_string($conn, $_POST['alamat_perusahaan']);

    $cek_double = mysqli_query($conn, "SELECT id_pengajuan FROM pengajuan 
                                       WHERE id_mahasiswa = '$id_mahasiswa' 
                                       AND status NOT IN ('ditolak', 'verifikasi_ditolak')");
    
    if (mysqli_num_rows($cek_double) > 0) {
        echo "<script>alert('Gagal! Anda masih memiliki lamaran yang sedang diproses.'); window.location='riwayat_lamaran.php';</script>";
        exit;
    }

    $query = "INSERT INTO pengajuan (id_mahasiswa, id_perusahaan, id_lowongan, nama_perusahaan, alamat_perusahaan, status, jenis, create_at) 
              VALUES ('$id_mahasiswa', '$id_perusahaan', '$id_lowongan', '$nama_perusahaan', '$alamat_perusahaan', 'menunggu_verifikasi', 'lowongan', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: riwayat_lamaran.php?msg=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: lowongan.php");
}
?>
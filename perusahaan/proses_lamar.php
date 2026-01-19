<?php
session_start();
require_once '../config.php';

// Cek Login Perusahaan
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id_lamaran = mysqli_real_escape_string($conn, $_GET['id']);
    $aksi = $_GET['aksi'];
    
    // Tentukan status baru
    $status_baru = ($aksi == 'terima') ? 'diterima' : 'ditolak';

    // Update database
    $query = "UPDATE lamaran SET status = '$status_baru' WHERE id_lamaran = '$id_lamaran'";
    
    if (mysqli_query($conn, $query)) {
        // Jika diterima, mungkin mau update status magang mahasiswa juga? (Opsional)
        // if ($aksi == 'terima') { ... logika update tabel mahasiswa ... }

        header("Location: pengajuan_magang.php?msg=Lamaran berhasil di-" . $aksi);
    } else {
        header("Location: pengajuan_magang.php?msg=Gagal memproses lamaran");
    }
} else {
    header("Location: pengajuan_magang.php");
}
?>
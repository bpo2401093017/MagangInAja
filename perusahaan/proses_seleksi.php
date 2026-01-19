<?php
session_start();
require_once '../config.php';

// 1. Cek Login Perusahaan
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// 2. Tangkap Parameter dari URL (id & aksi)
if (isset($_GET['id']) && isset($_GET['aksi'])) {
    
    $id_pengajuan = mysqli_real_escape_string($conn, $_GET['id']);
    $aksi = $_GET['aksi']; // Ini yang tadi salah (sebelumnya $_GET['action'])

    // LOGIKA TERIMA
    if ($aksi == 'terima') {
        // Update status jadi 'diterima'
        $query = "UPDATE pengajuan SET status = 'diterima' WHERE id_pengajuan = '$id_pengajuan'";
        
        if (mysqli_query($conn, $query)) {
            // Sukses -> Balik ke daftar
            header("Location: pengajuan_magang.php?msg=berhasil_diterima");
            exit;
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
    } 
    // LOGIKA TOLAK
    elseif ($aksi == 'tolak') {
        // Update status jadi 'ditolak'
        $query = "UPDATE pengajuan SET status = 'ditolak' WHERE id_pengajuan = '$id_pengajuan'";
        
        if (mysqli_query($conn, $query)) {
            // Sukses -> Balik ke daftar
            header("Location: pengajuan_magang.php?msg=berhasil_ditolak");
            exit;
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
    }

} else {
    // Jika link diklik tanpa ID/Aksi (Mencegah blank screen)
    header("Location: pengajuan_magang.php");
    exit;
}
?>
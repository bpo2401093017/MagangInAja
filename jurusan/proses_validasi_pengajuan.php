<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin_jurusan') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id_pengajuan = mysqli_real_escape_string($conn, $_GET['id']);
    $action = $_GET['action'];
    
    $new_status = ($action == 'approve') ? 'pending' : 'verifikasi_ditolak';
    
    $query = "UPDATE pengajuan SET status = '$new_status' WHERE id_pengajuan = '$id_pengajuan'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: pengajuan_magang.php?msg=validated");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: pengajuan_magang.php");
}
?>
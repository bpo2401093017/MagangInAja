<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin_jurusan') {
    header("Location: {$base_url}auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_user_mhs = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "UPDATE users SET status = 'Rejected' WHERE id_user = '$id_user_mhs' AND roles = 'mahasiswa'";

    if (mysqli_query($conn, $query)) {
        header("Location: {$base_url}dashboard/dashboard_jurusan.php?pesan=sukses_tolak");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: {$base_url}dashboard/dashboard_jurusan.php");
}
?>
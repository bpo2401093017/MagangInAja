<?php
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil id_user dulu agar bisa menghapus akun loginnya juga
    $get_user = mysqli_query($conn, "SELECT id_user FROM perusahaan WHERE id_perusahaan = '$id'");
    $data = mysqli_fetch_assoc($get_user);
    $id_user = $data['id_user'];

    // Hapus data perusahaan
    $delete_perusahaan = mysqli_query($conn, "DELETE FROM perusahaan WHERE id_perusahaan = '$id'");
    
    // Hapus data user
    if ($delete_perusahaan) {
        mysqli_query($conn, "DELETE FROM users WHERE id_user = '$id_user'");
        header("Location: data_perusahaan.php?status=deleted");
    } else {
        header("Location: data_perusahaan.php?status=error");
    }
}
?>
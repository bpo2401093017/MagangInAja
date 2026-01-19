<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../auth/login.php");
    exit;
}

$id_user = $_SESSION['user_id'];
$q_p = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan WHERE id_user = '$id_user'");
$d_p = mysqli_fetch_assoc($q_p);
$id_perusahaan = $d_p['id_perusahaan'];

if (!$id_perusahaan) {
    die("Data perusahaan belum lengkap. Silakan lengkapi profil terlebih dahulu.");
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'create') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $kuota = (int) $_POST['kuota'];
    $status = $_POST['status'];
    $id_jurusan = (int) $_POST['id_jurusan'];
    $id_prodi = (int) $_POST['id_prodi']; 
    $persyaratan = mysqli_real_escape_string($conn, $_POST['persyaratan']);

    $query = "INSERT INTO lowongan (id_perusahaan, judul_lowongan, kuota, id_jurusan, id_prodi, lokasi, status, persyaratan, tanggal_mulai, tanggal_selesai) 
              VALUES ('$id_perusahaan', '$judul', '$kuota', '$id_jurusan', '$id_prodi', '$lokasi', '$status', '$persyaratan', '$tgl_mulai', '$tgl_selesai')";

    if (mysqli_query($conn, $query)) {
        header("Location: lowongan.php?msg=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} elseif ($action === 'update') {
    $id_lowongan = (int) $_POST['id_lowongan'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    $kuota = (int) $_POST['kuota'];
    $status = $_POST['status'];
    $id_jurusan = (int) $_POST['id_jurusan'];
    $persyaratan = mysqli_real_escape_string($conn, $_POST['persyaratan']);

    $query = "UPDATE lowongan SET 
              judul_lowongan = '$judul', 
              lokasi = '$lokasi', 
              kuota = '$kuota', 
              status = '$status', 
              id_jurusan = '$id_jurusan',
              persyaratan = '$persyaratan', 
              tanggal_mulai = '$tgl_mulai', 
              tanggal_selesai = '$tgl_selesai' 
              WHERE id_lowongan = '$id_lowongan' AND id_perusahaan = '$id_perusahaan'";

    if (mysqli_query($conn, $query)) {
        header("Location: lowongan.php?msg=updated");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} elseif ($action === 'delete') {
    $id_lowongan = (int) $_GET['id'];
    $query = "DELETE FROM lowongan WHERE id_lowongan = '$id_lowongan' AND id_perusahaan = '$id_perusahaan'";

    if (mysqli_query($conn, $query)) {
        header("Location: lowongan.php?msg=deleted");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../auth/login.php");
    exit;
}

// HANDLING ACCEPT WITH FILE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'accept_with_file') {
    $id_pengajuan = mysqli_real_escape_string($conn, $_POST['id_pengajuan']);
    
    if (isset($_FILES['file_balasan']) && $_FILES['file_balasan']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['file_balasan']['name'], PATHINFO_EXTENSION));
        if ($ext === 'pdf') {
            $new_name = "surat_balasan_" . $id_pengajuan . "_" . time() . ".pdf";
            $dest = "../uploads/surat_balasan/" . $new_name;

            if (!is_dir('../uploads/surat_balasan')) mkdir('../uploads/surat_balasan', 0777, true);

            if (move_uploaded_file($_FILES['file_balasan']['tmp_name'], $dest)) {
                $query = "UPDATE pengajuan SET status = 'diterima', file_balasan = '$new_name' WHERE id_pengajuan = '$id_pengajuan'";
                if (mysqli_query($conn, $query)) {
                    header("Location: pengajuan_magang.php?msg=processed");
                    exit;
                }
            }
        }
    }
    echo "Gagal upload file atau format salah.";
    exit;
}

// HANDLING GET REQUEST (REJECT / OLD LOGIC)
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id_pengajuan = mysqli_real_escape_string($conn, $_GET['id']);
    $action = $_GET['action'];
    
    // Jika action accept, redirect ke halaman upload surat
    if ($action == 'accept') {
        header("Location: konfirmasi_terima.php?id=$id_pengajuan");
        exit;
    }
    
    // Jika reject, langsung proses
    if ($action == 'reject') {
        $query = "UPDATE pengajuan SET status = 'ditolak' WHERE id_pengajuan = '$id_pengajuan'";
        mysqli_query($conn, $query);
        header("Location: pengajuan_magang.php?msg=processed");
    }
}
?>
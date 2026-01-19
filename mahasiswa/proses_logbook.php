<?php
session_start();
require_once '../config.php';

// 1. Cek Login & Role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../auth/login.php");
    exit;
}

// ==========================================
// BAGIAN 1: PROSES SIMPAN (INSERT)
// ==========================================
if (isset($_POST['simpan'])) {
    
    $id_user = $_SESSION['user_id'];
    
    // Ambil ID Mahasiswa
    $q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
    $d_mhs = mysqli_fetch_assoc($q_mhs);
    $id_mahasiswa = $d_mhs['id_mahasiswa'];

    // Cek apakah mahasiswa sudah punya tempat magang (Status Diterima)
    $q_magang = mysqli_query($conn, "SELECT id_perusahaan FROM pengajuan WHERE id_mahasiswa = '$id_mahasiswa' AND status = 'diterima' LIMIT 1");
    
    if (mysqli_num_rows($q_magang) == 0) {
        echo "<script>alert('Anda belum diterima magang di perusahaan manapun!'); window.location='logbook.php';</script>";
        exit;
    }
    
    $d_magang = mysqli_fetch_assoc($q_magang);
    $id_perusahaan = $d_magang['id_perusahaan'];

    $tanggal  = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
    
    // Upload Dokumentasi
    $nama_file = '';
    if (isset($_FILES['dokumentasi']) && $_FILES['dokumentasi']['error'] === 0) {
        $allowed  = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['dokumentasi']['name'];
        $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $nama_file = 'log_' . time() . '_' . $id_mahasiswa . '.' . $ext;
            
            // PERBAIKAN PATH: Disamakan dengan logbook.php yaitu ke folder img/logbook
            $target_dir = '../img/logbook/';
            
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            move_uploaded_file($_FILES['dokumentasi']['tmp_name'], $target_dir . $nama_file);
        } else {
            echo "<script>alert('Format file harus JPG/PNG!'); window.history.back();</script>";
            exit;
        }
    }

    $query = "INSERT INTO logbook (id_mahasiswa, id_perusahaan, tanggal, kegiatan, dokumentasi, status) 
              VALUES ('$id_mahasiswa', '$id_perusahaan', '$tanggal', '$kegiatan', '$nama_file', 'pending')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Logbook berhasil disimpan!'); window.location='logbook.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// ==========================================
// BAGIAN 2: PROSES HAPUS (DELETE) - INI YANG TADI HILANG
// ==========================================
elseif (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    
    if (isset($_GET['id'])) {
        $id_logbook = mysqli_real_escape_string($conn, $_GET['id']);
        
        // 1. Ambil nama file foto dulu buat dihapus dari folder
        $cek_file = mysqli_query($conn, "SELECT dokumentasi FROM logbook WHERE id_logbook = '$id_logbook'");
        if (mysqli_num_rows($cek_file) > 0) {
            $data = mysqli_fetch_assoc($cek_file);
            $file_hapus = $data['dokumentasi'];
            
            // Hapus file fisik jika ada
            if (!empty($file_hapus) && file_exists("../img/logbook/" . $file_hapus)) {
                unlink("../img/logbook/" . $file_hapus);
            }
        }

        // 2. Hapus data dari database
        $query_hapus = "DELETE FROM logbook WHERE id_logbook = '$id_logbook'";
        
        if (mysqli_query($conn, $query_hapus)) {
            echo "<script>alert('Data berhasil dihapus!'); window.location='logbook.php';</script>";
        } else {
            echo "Gagal menghapus: " . mysqli_error($conn);
        }
    }
} 
else {
    header("Location: logbook.php");
}
?>
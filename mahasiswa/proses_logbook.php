<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $id_user = $_SESSION['user_id'];
    
    $q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
    $d_mhs = mysqli_fetch_assoc($q_mhs);
    $id_mahasiswa = $d_mhs['id_mahasiswa'];

    $q_magang = mysqli_query($conn, "SELECT id_perusahaan FROM pengajuan WHERE id_mahasiswa = '$id_mahasiswa' AND status = 'diterima' LIMIT 1");
    
    if (mysqli_num_rows($q_magang) == 0) {
        die("Error: Anda belum diterima magang.");
    }
    
    $d_magang = mysqli_fetch_assoc($q_magang);
    $id_perusahaan = $d_magang['id_perusahaan'];

    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
    
    $nama_file = '';
    if (isset($_FILES['dokumentasi']) && $_FILES['dokumentasi']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['dokumentasi']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $nama_file = 'log_' . time() . '_' . $id_mahasiswa . '.' . $ext;
            $destination = '../uploads/logbook/' . $nama_file;
            
            if (!is_dir('../uploads/logbook')) {
                mkdir('../uploads/logbook', 0777, true);
            }
            
            move_uploaded_file($_FILES['dokumentasi']['tmp_name'], $destination);
        } else {
            echo "<script>alert('Format file tidak valid!'); window.history.back();</script>";
            exit;
        }
    }

    $query = "INSERT INTO logbook (id_mahasiswa, id_perusahaan, tanggal, kegiatan, dokumentasi, status) 
              VALUES ('$id_mahasiswa', '$id_perusahaan', '$tanggal', '$kegiatan', '$nama_file', 'pending')";

    if (mysqli_query($conn, $query)) {
        header("Location: logbook.php?msg=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: logbook.php");
}
?>
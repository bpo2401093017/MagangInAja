<?php
session_start();
require_once '../config.php';

// Cek Login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'perusahaan') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['update'])) {
    $id_user = $_SESSION['user_id'];
    $id_perusahaan = mysqli_real_escape_string($conn, $_POST['id_perusahaan']);
    
    // 1. Data untuk Tabel USERS
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    
    // 2. Data untuk Tabel PERUSAHAAN
    // Kita HANYA ambil nama dan alamat karena 'website' & 'deskripsi' tidak ada di DB
    $nama_perusahaan = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // --- PROSES UPDATE ---

    // A. Update Tabel Users (Email & No HP)
    $query_user = "UPDATE users SET email = '$email', no_hp = '$no_hp' WHERE id_user = '$id_user'";
    if (!mysqli_query($conn, $query_user)) {
        die("Error Update User: " . mysqli_error($conn));
    }

    // B. Update Tabel Perusahaan (HANYA Nama & Alamat)
    // Bagian deskripsi & website SUDAH DIHAPUS dari query ini agar tidak error
    $query_perusahaan = "UPDATE perusahaan SET 
                         nama_perusahaan = '$nama_perusahaan',
                         alamat_perusahaan = '$alamat'
                         WHERE id_perusahaan = '$id_perusahaan'";
                         
    if (!mysqli_query($conn, $query_perusahaan)) {
        die("Error Update Perusahaan: " . mysqli_error($conn));
    }

    // C. Update Foto Profil (Jika ada file diupload)
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['foto_profil']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            // Hapus foto lama jika bukan default
            $q_foto = mysqli_query($conn, "SELECT foto FROM users WHERE id_user = '$id_user'");
            $d_foto = mysqli_fetch_assoc($q_foto);
            
            $path_lama = '../img/profile_perusahaan/' . $d_foto['foto'];
            if ($d_foto['foto'] != 'default.png' && file_exists($path_lama)) {
                unlink($path_lama);
            }

            // Upload foto baru
            $new_name = "logo_" . time() . "_" . $id_perusahaan . "." . $ext;
            $dest = "../img/profile_perusahaan/" . $new_name;
            
            // Buat folder jika belum ada
            if (!is_dir('../img/profile_perusahaan')) {
                mkdir('../img/profile_perusahaan', 0777, true);
            }

            if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $dest)) {
                // Update nama file di DB
                mysqli_query($conn, "UPDATE users SET foto = '$new_name' WHERE id_user = '$id_user'");
                mysqli_query($conn, "UPDATE perusahaan SET foto = '$new_name' WHERE id_perusahaan = '$id_perusahaan'");
                
                // Update session foto agar langsung berubah
                $_SESSION['foto'] = $new_name;
            }
        }
    }

    // Redirect Sukses
    header("Location: lihat_profile.php?msg=success");
} else {
    // Akses langsung tanpa submit
    header("Location: lihat_profile.php");
}
?>
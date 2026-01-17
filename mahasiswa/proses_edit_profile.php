<?php
require_once '../config.php';
session_start();

// 1. Proteksi Halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user_id'];
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp   = mysqli_real_escape_string($conn, $_POST['no_hp']);

    // 2. Ambil data lama untuk cek foto lama
    $query_old  = "SELECT foto FROM users WHERE id_user = '$id_user'";
    $result_old = mysqli_query($conn, $query_old);
    $data_old   = mysqli_fetch_assoc($result_old);
    $foto_lama  = $data_old['foto'];

    // 3. Logika Unggah Foto
   $nama_file_baru = $foto_lama; 

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $nama_file = $_FILES['foto']['name'];
        $ukuran    = $_FILES['foto']['size'];
        $tmp_name  = $_FILES['foto']['tmp_name'];
        
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_file  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

        if ($ukuran <= 2000000) {
            $nama_file_baru = "profile_" . $id_user . "_" . time() . "." . $ekstensi_file;
            
            // SESUAIKAN: Path folder harus tepat
            $tujuan = "../img/profile_mahasiswa/" . $nama_file_baru;

            if (move_uploaded_file($tmp_name, $tujuan)) {
                // Hapus foto lama di folder yang sama jika ada
                if ($foto_lama != '' && $foto_lama != 'default.png' && file_exists("../img/profile_mahasiswa/" . $foto_lama)) {
                    unlink("../img/profile_mahasiswa/" . $foto_lama);
                }
            } 
        } else {
            echo "<script>alert('Format tidak valid!'); window.history.back();</script>";
            exit;
        }
    }

    // 4. Update Database
    $query_update = "UPDATE users SET 
                    email = '$email', 
                    no_hp = '$no_hp', 
                    foto = '$nama_file_baru' 
                    WHERE id_user = '$id_user'";

    if (mysqli_query($conn, $query_update)) {
        echo "<script>
                alert('Profil berhasil diperbarui!');
                window.location.href = 'lihat_profile.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<?php
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            
            
            // Set session jika verifikasi lolos
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['roles'];
            $_SESSION['foto'] = $user['foto'];

            // --- LOGIKA VERIFIKASI MAHASISWA ---
          
            // -----------------------------------


            // Redirect sesuai role
            if ($user['roles'] === 'super_admin') {
                header("Location: {$base_url}dashboard/dashboard_admin.php");
            } else if ($user['roles'] === 'perusahaan') {
                header("Location: {$base_url}dashboard/dashboard_perusahaan.php");
            } else if ($user['roles'] === 'admin_jurusan') {
                header("Location: {$base_url}dashboard/dashboard_jurusan.php");
            }   if ($user['roles'] === 'mahasiswa') {
                    // Pastikan besar kecil huruf 'Verified' sesuai dengan di Database (case sensitive)
                    if ($user['status'] !== 'Verified') {
                        $pesan = ($user['status'] === 'Rejected') ? "Akun Anda ditolak." : "Akun Anda belum diverifikasi oleh Admin Jurusan.";
                        header("Location: {$base_url}auth/login.php?error=" . urlencode($pesan));
                        exit;
                    }
                    // Jika lolos verifikasi, redirect ke dashboard
                    header("Location: {$base_url}dashboard/dashboard_mahasiswa.php");
                    exit;
                }    
            
        } else {
            header("Location: {$base_url}auth/login.php?error=" . urlencode("Password salah!"));
            exit;
        }
    } else {
        header("Location: {$base_url}auth/login.php?error=" . urlencode("Akun tidak ditemukan!"));
        exit;
    }
    
}
?>
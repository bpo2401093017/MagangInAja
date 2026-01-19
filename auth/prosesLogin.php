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
            
            if ($user['roles'] === 'mahasiswa') {
                if ($user['status'] === 'Pending') {
                    header("Location: {$base_url}auth/login.php?error=" . urlencode("Akun Anda sedang dalam proses verifikasi oleh Admin Jurusan."));
                    exit;
                } elseif ($user['status'] === 'Rejected') {
                    header("Location: {$base_url}auth/login.php?error=" . urlencode("Registrasi Anda ditolak. Silakan hubungi Jurusan."));
                    exit;
                }
            }

            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['roles'];
            $_SESSION['foto'] = $user['foto'];

            switch ($user['roles']) {
                case 'super_admin':
                    header("Location: {$base_url}dashboard/dashboard_admin.php");
                    break;
                case 'perusahaan':
                    header("Location: {$base_url}dashboard/dashboard_perusahaan.php");
                    break;
                case 'admin_jurusan':
                    header("Location: {$base_url}dashboard/dashboard_jurusan.php");
                    break;
                case 'mahasiswa':
                    header("Location: {$base_url}dashboard/dashboard_mahasiswa.php");
                    break;
                default:
                    session_destroy();
                    header("Location: {$base_url}auth/login.php?error=" . urlencode("Role tidak dikenali!"));
                    break;
            }
            exit;
            
        } else {
            header("Location: {$base_url}auth/login.php?error=" . urlencode("Password salah!"));
            exit;
        }
    } else {
        header("Location: {$base_url}auth/login.php?error=" . urlencode("Username tidak ditemukan!"));
        exit;
    }
} else {
    header("Location: {$base_url}auth/login.php");
    exit;
}
?>
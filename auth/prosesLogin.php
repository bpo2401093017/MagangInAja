<?php
require_once '../config.php';

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // query harus benar
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // cek user ada atau tidak
    if (mysqli_num_rows($result) === 1) {

        $user = mysqli_fetch_assoc($result);

        // verifikasi password
        if (password_verify($password, $user['password'])) {

            // set session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['roles'];

            // **redirect sesuai role**
            if ($user['roles'] === 'super_admin') {
                header("Location: admin/");
            } else if ($user['roles'] === 'perusahaan') {
                header("Location: perusahaan/");
            } else if ($user['roles'] === 'admin_jurusan') {
                header("Location: jurusan/");
            }else {
                header("Location: mahasiswa/");
            }
            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Akun tidak ditemukan!";
    }
}
?>

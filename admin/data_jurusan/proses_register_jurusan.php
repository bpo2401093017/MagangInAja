<?php
require_once "../../config.php";

if (isset($_POST['submit'])) {
    // 1. Tangkap Data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $nama_jurusan = mysqli_real_escape_string($conn, $_POST['nama_jurusan']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp        = mysqli_real_escape_string($conn, $_POST['no_hp']);
    
    // Kode Jurusan default strip (-)
    $kode = '-';

    // 2. Insert ke tabel USERS
    $query_user = "INSERT INTO users (username, email, password, roles, no_hp, created_at) 
                   VALUES ('$username', '$email', '$password', 'admin_jurusan', '$no_hp', NOW())";
    
    if (mysqli_query($conn, $query_user)) {
        $id_user = mysqli_insert_id($conn);

        // 3. Insert ke tabel JURUSAN
        $query_jurusan = "INSERT INTO jurusan (id_user, nama_jurusan, kode) 
                          VALUES ('$id_user', '$nama_jurusan', '$kode')";
        
        if (mysqli_query($conn, $query_jurusan)) {
            // SUKSES -> Redirect ke Data Master
            header("Location: ../data_perusahaan.php?status=success_jurusan");
            exit;
        } else {
            // GAGAL JURUSAN -> Hapus User (Rollback)
            mysqli_query($conn, "DELETE FROM users WHERE id_user = '$id_user'");
            header("Location: register_jurusan.php?status=failed_jurusan");
            exit;
        }
    } else {
        // GAGAL USER (Username/Email Kembar)
        header("Location: register_jurusan.php?status=failed_user");
        exit;
    }
} else {
    header("Location: register_jurusan.php");
    exit;
}
?>
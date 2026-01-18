<?php
require_once "../../config.php";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_jurusan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $kode_jurusan = mysqli_real_escape_string($conn, $_POST['kode']);

    // Simpan ke tabel users
    $query_user = "INSERT INTO users (username, email, password, roles, created_at) 
                   VALUES ('$username', '$email', '$password', 'admin_jurusan', NOW())";
    
    if (mysqli_query($conn, $query_user)) {
        $id_user = mysqli_insert_id($conn);

        // Simpan ke tabel jurusan (Alamat dan Foto dikosongkan/default)
        $query_jurusan = "INSERT INTO jurusan (id_user, nama_jurusan, kode, create_at) 
                             VALUES ('$id_user', '$nama_jurusan', '$kode', NOW())";
        
        if (mysqli_query($conn, $query_perusahaan)) {
            header("Location: ../../admin/data_perusahaan.php?status=success");
        } else {
            header("Location: register.php?status=failed");
        }
    } else {
        header("Location: register.php?status=failed");
    }
} else {
    header("Location: register.php");
}
?>
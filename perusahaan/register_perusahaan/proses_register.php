<?php
require_once "../../config.php";

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $pic = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat_perusahaan']);

    $query_user = "INSERT INTO users (username, email, password, roles, created_at) 
                   VALUES ('$username', '$email', '$password', 'perusahaan', NOW())";
    
    if (mysqli_query($conn, $query_user)) {
        $id_user = mysqli_insert_id($conn);
        
        $query_perusahaan = "INSERT INTO perusahaan (id_user, nama_perusahaan, email, no_hp, contact_person, alamat_perusahaan, create_at) 
                             VALUES ('$id_user', '$nama', '$email', '$no_hp', '$pic', '$alamat', NOW())";
        
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
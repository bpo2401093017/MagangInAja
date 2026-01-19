<?php
require_once "../../config.php";

if (isset($_POST['update'])) {
    // 1. Ambil Data ID
    $id_jurusan = mysqli_real_escape_string($conn, $_POST['id_jurusan']);
    $id_user    = mysqli_real_escape_string($conn, $_POST['id_user']);
    
    // 2. Ambil Data Inputan
    $nama_jurusan = mysqli_real_escape_string($conn, $_POST['nama_jurusan']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp        = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $password     = $_POST['password']; // Cek nanti apakah diisi atau tidak

    // 3. Update Tabel Users (Email & No HP)
    $query_user = "UPDATE users SET email = '$email', no_hp = '$no_hp' WHERE id_user = '$id_user'";
    
    if (!mysqli_query($conn, $query_user)) {
        die("Error Update User: " . mysqli_error($conn));
    }

    // 4. Update Password (Hanya jika diisi)
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query_pass = "UPDATE users SET password = '$hashed_password' WHERE id_user = '$id_user'";
        mysqli_query($conn, $query_pass);
    }

    // 5. Update Tabel Jurusan
    $query_jurusan = "UPDATE jurusan SET nama_jurusan = '$nama_jurusan' WHERE id_jurusan = '$id_jurusan'";
    
    if (mysqli_query($conn, $query_jurusan)) {
        // SUKSES -> Kembali ke Halaman Data Master
        header("Location: ../data_perusahaan.php?status=updated");
        exit;
    } else {
        die("Error Update Jurusan: " . mysqli_error($conn));
    }

} else {
    // Akses ilegal
    header("Location: ../data_perusahaan.php");
    exit;
}
?>
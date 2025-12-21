<?php
require_once '../config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_perusahaan'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $pic = mysqli_real_escape_string($conn, $_POST['contact_person']);

    $query = "UPDATE perusahaan SET 
              nama_perusahaan = '$nama', 
              email = '$email', 
              no_hp = '$no_hp', 
              contact_person = '$pic' 
              WHERE id_perusahaan = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: data_perusahaan.php?status=updated");
    } else {
        header("Location: data_perusahaan.php?status=failed");
    }
}
?>
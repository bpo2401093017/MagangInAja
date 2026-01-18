<?php
require_once '../../config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_prodi'];
    $nama_prodi = mysqli_real_escape_string($conn, $_POST['nama_prodi']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE prodi SET 
              nama_prodi = '$nama_prodi', 
              status = '$status' 
              WHERE id_prodi = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: data_prodi.php?status=updated");
    } else {
        header("Location: data_prodi.php?status=failed");
    }
}
?>
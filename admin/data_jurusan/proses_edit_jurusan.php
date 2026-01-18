<?php
require_once '../../config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id_jurusan'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama_jurusan']);
    $kode = mysqli_real_escape_string($conn, $_POST['kode']);

    $query = "UPDATE jurusan SET 
              nama_jurusan = '$nama', 
              kode = '$kode' 
              WHERE id_jurusan = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: data_perusahaan.php?status=updated");
    } else {
        header("Location: data_perusahaan.php?status=failed");
    }
}
?>
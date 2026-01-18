<?php

session_start();
require_once '../../config.php';

$id_user = $_SESSION['user_id'] ?? null;
if (!$id_user) {
    die("Akses tidak valid");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $id_user   = $_SESSION['id_user'];
    $nama_prodi = $_POST['nama_prodi'];
    $status     = $_POST['status'];

    // 1️⃣ Ambil id_jurusan milik user
    $qJurusan = "SELECT id_jurusan FROM jurusan WHERE id_user = ?";
    $stmtJur = mysqli_prepare($conn, $qJurusan);
    mysqli_stmt_bind_param($stmtJur, "i", $id_user);
    mysqli_stmt_execute($stmtJur);
    $resJur = mysqli_stmt_get_result($stmtJur);

    if (mysqli_num_rows($resJur) === 0) {
        die("Jurusan tidak ditemukan.");
    }

    $jurusan = mysqli_fetch_assoc($resJur);
    $id_jurusan = $jurusan['id_jurusan'];

    // 2️⃣ Insert prodi
    $sql = "INSERT INTO prodi (id_jurusan, nama_prodi, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $id_jurusan, $nama_prodi, $status);

    if (mysqli_stmt_execute($stmt)) {
        echo "Prodi berhasil ditambahkan.";
        header("Location: data_prodi.php");
    } else {
        echo "Gagal menambahkan prodi.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

<?php
require_once "../../config.php";

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
    $id_jurusan = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Cari id_user milik jurusan ini (Agar akun login juga terhapus)
    $query_cek = "SELECT id_user FROM jurusan WHERE id_jurusan = '$id_jurusan'";
    $result = mysqli_query($conn, $query_cek);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $id_user = $data['id_user'];

        // 2. Hapus Data JURUSAN terlebih dahulu
        $q_delete_jurusan = "DELETE FROM jurusan WHERE id_jurusan = '$id_jurusan'";
        
        if (mysqli_query($conn, $q_delete_jurusan)) {
            // 3. Jika jurusan berhasil dihapus, HAPUS AKUN LOGIN (Users)
            mysqli_query($conn, "DELETE FROM users WHERE id_user = '$id_user'");
            
            // Redirect Sukses
            header("Location: ../data_perusahaan.php?status=deleted");
        } else {
            // Error Database (Biasanya karena Foreign Key Constraint / Masih ada data Prodi/Mahasiswa)
            echo "<script>
                alert('Gagal menghapus! Jurusan ini mungkin masih memiliki Data Prodi atau Mahasiswa. Hapus data terkait terlebih dahulu.');
                window.location = '../data_perusahaan.php';
            </script>";
        }
    } else {
        // Data tidak ditemukan
        header("Location: ../data_perusahaan.php");
    }
} else {
    // Akses tanpa ID
    header("Location: ../data_perusahaan.php");
}
?>
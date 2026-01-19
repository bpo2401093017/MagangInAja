<?php
session_start();

require_once '../config.php';
require_once '../auth/auth_jurusan.php'; // Pastikan path ini benar

// 1. Cek Request Method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Jika ditembak langsung via URL, tendang balik
    header("Location: ../dashboard/dashboard_jurusan.php");
    exit;
}

// 2. Validasi ID User
if (!isset($_POST['id_user']) || empty($_POST['id_user'])) {
    $_SESSION['error'] = "Error: ID Mahasiswa tidak ditemukan.";
    header("Location: ../dashboard/dashboard_jurusan.php");
    exit;
}

// PENTING: Karena di gambar database 'id_user' adalah INT(11), 
// kita paksa jadi integer biar aman dari karakter aneh.
$id_user = (int) $_POST['id_user'];

// 3. Cek Status Sekarang (Sekalian memastikan User ada & Role benar)
// Sesuai gambar: kolom 'roles' juga ada.
$queryCek = mysqli_query($conn, "SELECT status, roles FROM users WHERE id_user = $id_user");
$data = mysqli_fetch_assoc($queryCek);

if (!$data) {
    $_SESSION['error'] = "Data mahasiswa tidak ditemukan di Database.";
    header("Location: ../dashboard/dashboard_jurusan.php");
    exit;
}

// Validasi Role (Opsional, tapi bagus untuk keamanan)
if ($data['roles'] !== 'mahasiswa') {
    $_SESSION['error'] = "User ini bukan mahasiswa (Role: " . $data['roles'] . ").";
    header("Location: ../dashboard/dashboard_jurusan.php");
    exit;
}

// Cek jika sudah Verified
if ($data['status'] === 'Verified') {
    $_SESSION['info'] = "Mahasiswa ini sudah berstatus Verified sebelumnya.";
    header("Location: ../dashboard/dashboard_jurusan.php");
    exit;
}

// 4. PROSES UPDATE (Sesuai Struktur Gambar)
// id_user = int (tidak perlu kutip di SQL, tapi pakai kutip juga tidak apa-apa)
// status = 'Verified' (Sesuai Enum)
// update_at = NOW() (Sesuai kolom datetime)

$sql_update = "UPDATE users 
               SET status = 'Verified', 
                   update_at = NOW() 
               WHERE id_user = $id_user";

$update = mysqli_query($conn, $sql_update);

// 5. Cek Keberhasilan
if ($update) {
    // Cek apakah ada baris yang berubah
    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['success'] = "Berhasil! Status mahasiswa diubah menjadi Verified.";
    } else {
        // Query sukses, tapi data tidak berubah (kemungkinan error logika aneh)
        $_SESSION['error'] = "Sistem: Update dijalankan tapi status tidak berubah. Cek Database.";
    }
} else {
    // Tampilkan error MySQL spesifik ke session untuk debug
    $_SESSION['error'] = "Gagal Update Database: " . mysqli_error($conn);
}

// 6. Redirect
header("Location: ../dashboard/dashboard_jurusan.php");
exit;
?>
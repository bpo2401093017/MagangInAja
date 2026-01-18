<?php
require_once '../auth/auth_mahasiswa.php';
require_once '../templates/header_mahasiswa.php';


$role = $_SESSION['role'];
$username = $_SESSION['username'];

// // 1. Ambil input pencarian jika ada
// $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
// $lokasi = isset($_GET['lokasi']) ? mysqli_real_escape_string($conn, $_GET['lokasi']) : '';

// // 2. Jalankan Query ke Database agar variabel $result terisi
// $query = "SELECT * FROM users WHERE roles = 'perusahaan'"; // Sesuaikan nama tabel Anda

// if (!empty($keyword)) {
//     $query .= " AND (username LIKE '%$keyword%' OR nama_jurusan LIKE '%$keyword%')";
// }
// if (!empty($lokasi)) {
//     $query .= " AND lokasi = '$lokasi'"; // Sesuaikan jika ada kolom lokasi
// }

// $result = mysqli_query($conn, $query);

// // Cek jika query gagal
// if (!$result) {
//     die("Query Error: " . mysqli_error($conn));
// }
?>

<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Lowongan Kerja</title>
    <link rel="stylesheet" href="lowongan.css">
</head>
<body>

<div class="container">
    <header class="sidebar">
        <div class="logo">LOGO</div>
        <nav>
            <ul>
                <li class="active">Lowongan</li>
                <li>Profil</li>
                <li>Keluar</li>
            </ul>
        </nav>
    </header>

    <main class="content">
        <div class="top-bar">
            <h1>Daftar Lowongan Kerja</h1>
            <p class="user-role">Role: <strong>Admin Perusahaan</strong></p>
        </div>

        <section class="job-section priority">
            <h2>Lowongan Perusahaan Anda</h2>
            <div class="job-card">
                <div class="job-info">
                    <h3>Frontend Developer</h3>
                    <p>PT. Teknologi Maju | Lokasi: Padang</p>
                </div>
                <div class="actions">
                    <button class="btn btn-edit">Edit Lowongan</button>
                </div>
            </div>
        </section>

        <section class="job-section">
            <h2>Lowongan Lainnya</h2>
            
            <div class="job-card">
                <div class="job-info">
                    <h3>UI/UX Designer</h3>
                    <p>PT. Kreatif Digital | Lokasi: Jakarta</p>
                </div>
                <div class="actions">
                    <button class="btn btn-apply">Lamar Sekarang</button>
                </div>
            </div>

            <div class="job-card readonly">
                <div class="job-info">
                    <h3>Backend Engineer</h3>
                    <p>PT. Data Solusi | Lokasi: Bandung</p>
                </div>
                <div class="actions">
                    <span class="badge">View Only</span>
                </div>
            </div>
        </section>
    </main>
</div>

</body>
</html> -->
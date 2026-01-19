<?php
require_once '../templates/header_perusahaan.php';

$id_user = $_SESSION['user_id'];
$q_p = mysqli_query($conn, "SELECT id_perusahaan, nama_perusahaan FROM perusahaan WHERE id_user = '$id_user'");
$d_p = mysqli_fetch_assoc($q_p);
$id_perusahaan = $d_p['id_perusahaan'];

$q_lowongan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM lowongan WHERE id_perusahaan = '$id_perusahaan'"));
$q_pelamar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengajuan WHERE id_perusahaan = '$id_perusahaan' AND status = 'pending'"));
$q_aktif = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pengajuan WHERE id_perusahaan = '$id_perusahaan' AND status = 'diterima'"));
$q_logbook = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM logbook WHERE id_perusahaan = '$id_perusahaan' AND status = 'pending'"));
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/dashboard_new.css">

<div class="main-content">
    <div class="welcome-section">
        <div class="welcome-text">
            <h1>Halo, <?= htmlspecialchars($d_p['nama_perusahaan']); ?>!</h1>
            <p>Selamat datang di panel manajemen magang. Berikut ringkasan aktivitas hari ini.</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">💼</div>
            <div class="stat-info">
                <h3><?= $q_lowongan['total']; ?></h3>
                <p>Lowongan Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange">📄</div>
            <div class="stat-info">
                <h3><?= $q_pelamar['total']; ?></h3>
                <p>Pelamar Baru</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green">👥</div>
            <div class="stat-info">
                <h3><?= $q_aktif['total']; ?></h3>
                <p>Mahasiswa Magang</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red">📝</div>
            <div class="stat-info">
                <h3><?= $q_logbook['total']; ?></h3>
                <p>Logbook Pending</p>
            </div>
        </div>
    </div>

    <div class="action-card">
        <h3 style="color: #333;">Aksi Cepat</h3>
        <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
            <a href="../perusahaan/tambah_lowongan.php" class="btn-download" style="background: #2E8B47;">+ Pasang Lowongan</a>
            <a href="../perusahaan/pengajuan_magang.php" class="btn-download" style="background: #ef6c00;">Cek Pelamar Masuk</a>
            <a href="../perusahaan/monitoring_mahasiswa.php" class="btn-download" style="background: #1976d2;">Monitoring Mahasiswa</a>
        </div>
    </div>
</div>
</body>
</html>
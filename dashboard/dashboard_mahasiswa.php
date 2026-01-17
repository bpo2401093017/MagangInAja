<?php
require_once '../config.php';
require_once '../templates/header_mahasiswa.php';

// Contoh data dummy untuk statistik
$total_perusahaan = 12; // Anda bisa ganti dengan query mysqli
?>

<main class="main-content">
    <div class="content-header">
        <h2 style="color: #2E8B47; font-size: 24px;">Selamat Datang, <?= ucfirst($_SESSION['username'] ?? 'Mahasiswa'); ?>!</h2>
        <p style="color: #666; margin-top: 5px;">Pantau status magang dan cari mitra industri terbaik di <strong>SIPADEKPNP</strong>.</p>
    </div>

    <div class="dashboard-cards" style="margin-top: 30px;">
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
            <div>
                <span style="display: block; color: #888; font-size: 14px;">Mitra Industri</span>
                <span style="display: block; font-size: 12px; color: #aaa;">Perusahaan terdaftar aktif</span>
            </div>
            <div style="font-size: 32px; font-weight: bold; color: #2E8B47;"><?= $total_perusahaan; ?></div>
        </div>
    </div>

    <div style="margin-top: 40px; display: flex; gap: 15px;">
        <a href="lowongan.php" style="background: #2E8B47; color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600;">Cari Tempat Magang</a>
        <a href="edit_profile.php" style="border: 2px solid #2E8B47; color: #2E8B47; padding: 10px 25px; border-radius: 8px; text-decoration: none; font-weight: 600;">Lengkapi Profile</a>
    </div>

    <?php include '../templates/footer.php'; ?>

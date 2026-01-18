<?php
// Pastikan config sudah menyertakan session_start() dan variabel $base_url
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth/auth_mahasiswa.php';

// --- LOGIKA PENGECEKAN DATA MAHASISWA ---
$id_user = $_SESSION['user_id'];
$cek_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
$sudah_isi_data = mysqli_num_rows($cek_mhs) > 0;

// Tentukan link tujuan
$link_data_mhs = $sudah_isi_data ? "data_mahasiswa.php" : "form_data_mahasiswa.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - MagangInAja</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/mahasiswa.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>MagangInAja</h3>
            <small>Mahasiswa Panel</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="<?= $base_url; ?>dashboard/dashboard_mahasiswa.php" 
                   class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard_mahasiswa.php' ? 'active' : ''; ?>">
                   Dashboard
                </a>
            </li>
            <li>
                <a href="<?= $base_url; ?>mahasiswa/data_mahasiswa/<?= $link_data_mhs; ?>"
                   class="<?= (basename($_SERVER['PHP_SELF']) == 'data_mahasiswa.php' || basename($_SERVER['PHP_SELF']) == 'form_data_mahasiswa.php') ? 'active' : ''; ?>">
                   Data Mahasiswa
                </a>
            </li>
            <li>
                <a href="<?= $base_url; ?>mahasiswa/data_mahasiswa/<?= $link_data_mhs; ?>"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'pengajuan_magang.php' ? 'active' : ''; ?>">
                   Pengajuan Magang
                </a>
            </li>
            <li>
                <a href="<?= $base_url; ?>mahasiswa/lowongan.php"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'lowongan.php' ? 'active' : ''; ?>">
                   Cari Lowongan
                </a>
            </li>
            <li>
                <a href="<?= $base_url; ?>mahasiswa/riwayat_lamaran.php"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'riwayat_lamaran.php' ? 'active' : ''; ?>">
                   Riwayat Lamaran
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="profile-menu-container" id="profileMenu">
                <a href="<?= $base_url; ?>mahasiswa/lihat_profile.php">Lihat Profile</a>
                <a href="<?= $base_url; ?>mahasiswa/ganti_password.php">Ganti Password</a>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                <a href="<?= $base_url; ?>auth/logout.php" style="color: #ff7675;">Log Out</a>
            </div>

            <div class="user-profile-toggle" onclick="toggleProfileMenu(event)">
                <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $_SESSION['foto'] ?? 'default.png'; ?>" 
                     class="mini-avatar" 
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'"
                     alt="User">
                <div class="user-details">
                    <span class="user-name"><?= $_SESSION['username'] ?? 'Mahasiswa'; ?></span>
                    <span class="user-role">Mahasiswa</span>
                </div>
                <span class="chevron-icon">▲</span>
            </div>
        </div>
    </aside>

    <script>
        function toggleProfileMenu(event) {
            // Mencegah klik menyebar ke window.onclick
            event.stopPropagation();
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('active');
        }

        // Menutup menu jika klik di mana saja di luar area sidebar footer
        window.onclick = function(event) {
            const menu = document.getElementById('profileMenu');
            if (!event.target.closest('.sidebar-footer')) {
                if (menu.classList.contains('active')) {
                    menu.classList.remove('active');
                }
            }
        }
    </script>
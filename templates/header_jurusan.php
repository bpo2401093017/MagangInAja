<?php
// Pastikan config sudah menyertakan session_start() dan variabel $base_url
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth/auth_jurusan.php';

// --- LOGIKA PENGECEKAN DATA JURUSAN---
$id_user = $_SESSION['user_id'];
$cek_jrs = mysqli_query($conn, "SELECT id_jurusan FROM jurusan WHERE id_user = '$id_user'");
$sudah_isi_data = mysqli_num_rows($cek_jrs) > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Jurusan Dashboard - MagangInAja</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/jurusan.css">
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>MagangInAja</h3>
            <small>Admin Jurusan Panel</small>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="<?= $base_url; ?>dashboard/dashboard_jurusan.php" 
                   class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard_jurusan.php' ? 'active' : ''; ?>">
                   Dashboard
                </a>
            </li>
            <li>
                <a href="<?= $base_url; ?>jurusan/data_mahasiswa/<?= $link_data_mhs; ?>"
                   class="<?= (basename($_SERVER['PHP_SELF']) == 'data_mahasiswa.php' || basename($_SERVER['PHP_SELF']) == 'form_data_mahasiswa.php') ? 'active' : ''; ?>">
                   Data Mahasiswa
                </a>
            </li>           
            <li>
                <a href="<?= $base_url; ?>jurusan/lowongan.php"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'lowongan.php' ? 'active' : ''; ?>">
                   Cari Lowongan
                </a>
            </li>
            <li>
                <a href="<?= $base_url; ?>jurusan/register_prodi/data_prodi.php"
                   class="<?= basename($_SERVER['PHP_SELF']) == 'data_prodi.php' ? 'active' : ''; ?>">
                   Program Studi
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="profile-menu-container" id="profileMenu">
                <a href="<?= $base_url; ?>jurusan/lihat_profile.php">Lihat Profile</a>
                <a href="<?= $base_url; ?>jurusan/ganti_password.php">Ganti Password</a>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                <a href="<?= $base_url; ?>auth/logout.php" style="color: #ff7675;">Log Out</a>
            </div>

            <div class="user-profile-toggle" onclick="toggleProfileMenu(event)">
                <img src="<?= $base_url; ?>img/profile_jurusan/<?= $_SESSION['foto'] ?? 'default.png'; ?>" 
                     class="mini-avatar" 
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'"
                     alt="User">
                <div class="user-details">
                    <span class="user-name"><?= $_SESSION['username'] ?? 'Admin Jurusan'; ?></span>
                    <span class="user-role">Admin Jurusan</span>
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
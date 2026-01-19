<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth/auth_jurusan.php';

$id_user = $_SESSION['user_id'];
$cek_jrs = mysqli_query($conn, "SELECT id_jurusan FROM jurusan WHERE id_user = '$id_user'");
$sudah_isi_data = mysqli_num_rows($cek_jrs) > 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Jurusan - SIPADEKPNP</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/jurusan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="admin-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-university"></i> JURUSAN</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?= $base_url; ?>dashboard/dashboard_jurusan.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="<?= $base_url; ?>jurusan/register_prodi/data_prodi.php"><i class="fas fa-layer-group"></i> Data Prodi</a></li>
                <li><a href="<?= $base_url; ?>jurusan/pengajuan_magang.php"><i class="fas fa-user-check"></i> Validasi Magang</a></li>
                <li><a href="<?= $base_url; ?>jurusan/lihat_profile.php"><i class="fas fa-user-cog"></i> Profil Jurusan</a></li>
            </ul>

            <div class="sidebar-footer">
                <div class="profile-menu-container" id="profileMenu">
                    <a href="<?= $base_url; ?>jurusan/lihat_profile.php">Lihat Profile</a>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                    <a href="<?= $base_url; ?>auth/logout.php" style="color: #c62828;">Log Out</a>
                </div>

                <div class="user-profile-toggle" onclick="toggleProfileMenu(event)">
                    <img src="<?= $base_url; ?>img/profile_jurusan/<?= $_SESSION['foto'] ?? 'default.png'; ?>" 
                         class="mini-avatar" 
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'"
                         alt="User">
                    <div class="user-details">
                        <span class="user-name"><?= $_SESSION['username'] ?? 'Admin'; ?></span>
                        <span class="user-role">Admin Jurusan</span>
                    </div>
                    <span class="chevron-icon" style="margin-left: auto;">▲</span>
                </div>
            </div>
        </aside>

        <div class="overlay" onclick="toggleSidebar()"></div>

        <script>
            function toggleSidebar() {
                document.getElementById('sidebar').classList.toggle('active');
            }
            function toggleProfileMenu(event) {
                event.stopPropagation();
                document.getElementById('profileMenu').classList.toggle('active');
            }
            window.onclick = function(event) {
                if (!event.target.closest('.sidebar-footer')) {
                    document.getElementById('profileMenu').classList.remove('active');
                }
            }
        </script>
<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth/auth_perusahaan.php';

$id_user = $_SESSION['user_id'];
$cek_prs = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan WHERE id_user = '$id_user'");
$sudah_isi_data = mysqli_num_rows($cek_prs) > 0;
$link_data_prs = $sudah_isi_data ? "data_perusahaan.php" : "form_data_perusahaan.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perusahaan - SIPADEKPNP</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/perusahaan.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="admin-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-building"></i> PERUSAHAAN</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?= $base_url; ?>dashboard/dashboard_perusahaan.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="<?= $base_url; ?>perusahaan/data_perusahaan/<?= $link_data_prs; ?>"><i class="fas fa-edit"></i> Data Perusahaan</a></li>
                <li><a href="<?= $base_url; ?>perusahaan/lowongan.php"><i class="fas fa-briefcase"></i> Lowongan</a></li>
                <li><a href="<?= $base_url; ?>perusahaan/pengajuan_magang.php"><i class="fas fa-users"></i> Pelamar</a></li>
                <li><a href="<?= $base_url; ?>perusahaan/monitoring_mahasiswa.php"><i class="fas fa-chart-line"></i> Monitoring</a></li>
            </ul>

            <div class="sidebar-footer">
                <div class="profile-menu-container" id="profileMenu">
                    <a href="<?= $base_url; ?>perusahaan/lihat_profile.php">Lihat Profile</a>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                    <a href="<?= $base_url; ?>auth/logout.php" style="color: #c62828;">Log Out</a>
                </div>

                <div class="user-profile-toggle" onclick="toggleProfileMenu(event)">
                    <img src="<?= $base_url; ?>img/profile_perusahaan/<?= $_SESSION['foto'] ?? 'default.png'; ?>" 
                         class="mini-avatar" 
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'"
                         alt="User">
                    <div class="user-details">
                        <span class="user-name"><?= $_SESSION['username'] ?? 'Perusahaan'; ?></span>
                        <span class="user-role">Mitra</span>
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
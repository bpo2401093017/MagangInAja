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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - SIPADEKPNP</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/mahasiswa.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="admin-container">
        
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-graduation-cap"></i> MAHASISWA</h3>
                <small>SIPADEKPNP Panel</small>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="<?= $base_url; ?>dashboard/dashboard_mahasiswa.php" 
                       class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard_mahasiswa.php' ? 'active' : ''; ?>">
                       <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url; ?>mahasiswa/data_mahasiswa/<?= $link_data_mhs; ?>"
                       class="<?= (basename($_SERVER['PHP_SELF']) == 'data_mahasiswa.php' || basename($_SERVER['PHP_SELF']) == 'form_data_mahasiswa.php') ? 'active' : ''; ?>">
                       <i class="fas fa-user-edit"></i> Data Diri
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url; ?>mahasiswa/lowongan.php"
                       class="<?= basename($_SERVER['PHP_SELF']) == 'lowongan.php' ? 'active' : ''; ?>">
                       <i class="fas fa-search"></i> Cari Lowongan
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url; ?>mahasiswa/riwayat_lamaran.php"
                       class="<?= basename($_SERVER['PHP_SELF']) == 'riwayat_lamaran.php' ? 'active' : ''; ?>">
                       <i class="fas fa-history"></i> Riwayat Lamaran
                    </a>
                </li>
                <li>
                    <a href="<?= $base_url; ?>mahasiswa/logbook.php"
                       class="<?= basename($_SERVER['PHP_SELF']) == 'logbook.php' ? 'active' : ''; ?>">
                       <i class="fas fa-book"></i> Logbook Harian
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <div class="profile-menu-container" id="profileMenu">
                    <a href="<?= $base_url; ?>mahasiswa/lihat_profile.php"><i class="fas fa-user-circle"></i> Lihat Profile</a>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;">
                    <a href="<?= $base_url; ?>auth/logout.php" style="color: #c62828;"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                </div>

                <div class="user-profile-toggle" onclick="toggleProfileMenu(event)">
                    <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $_SESSION['foto'] ?? 'default.png'; ?>" 
                         class="mini-avatar" 
                         onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'"
                         alt="User">
                    <div class="user-details">
                        <span class="user-name"><?= ucfirst($_SESSION['username'] ?? 'Mahasiswa'); ?></span>
                        <span class="user-role">Mahasiswa</span>
                    </div>
                    <span class="chevron-icon"><i class="fas fa-chevron-up"></i></span>
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

            // Tutup menu jika klik di luar
            window.onclick = function(event) {
                if (!event.target.closest('.sidebar-footer')) {
                    document.getElementById('profileMenu').classList.remove('active');
                }
            }
        </script>
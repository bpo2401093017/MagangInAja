<?php
require_once __DIR__ . '/../config.php';

// Cek Sesi Login & Role
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: {$base_url}auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Super Admin - SIPADEKPNP</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="<?= $base_url; ?>css/admin.css">
</head>
<body>

    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="admin-container">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-shield-alt"></i> SUPER ADMIN</h3>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="<?= $base_url; ?>dashboard/dashboard_admin.php" 
                       class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard_admin.php' ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                
                <li>
                    <a href="<?= $base_url; ?>admin/data_perusahaan.php"
                       class="<?= basename($_SERVER['PHP_SELF']) == 'data_perusahaan.php' ? 'active' : ''; ?>">
                        <i class="fas fa-database"></i> Data Master
                    </a>
                </li>

                <li>
                    <a href="<?= $base_url; ?>admin/data_jurusan/register_jurusan.php"
                       class="<?= (basename($_SERVER['PHP_SELF']) == 'register_jurusan.php' || basename($_SERVER['PHP_SELF']) == 'register.php') ? 'active' : ''; ?>">
                        <i class="fas fa-university"></i> Tambah Jurusan
                    </a>
                </li>

                <li>
                    <a href="<?= $base_url; ?>perusahaan/register_perusahaan/register.php"
                       class="<?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">
                        <i class="fas fa-building"></i> Tambah Mitra
                    </a>
                </li>

                <li>
                    <a href="<?= $base_url; ?>admin/kelola_surat/index.php"
                       class="<?= (strpos($_SERVER['REQUEST_URI'], 'kelola_surat') !== false) ? 'active' : ''; ?>">
                        <i class="fas fa-envelope-open-text"></i> Kelola Surat
                    </a>
                </li>

                <li style="margin-top: 30px;">
                    <a href="<?= $base_url; ?>auth/logout.php" style="color: #ffcccc;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

        <div class="overlay" onclick="toggleSidebar()"></div>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('active');
            }
        </script>
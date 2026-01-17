<?php
$base_url = "http://localhost/MagangInAja/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SIPADEKPNP</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/admin.css">
    <style>
        .sidebar {
            width: 250px;
            background: #2E8B47;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            padding: 20px 0;
        }
        .sidebar-header {
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
            margin: 0;
        }
        .sidebar-menu li a {
            padding: 15px 25px;
            display: block;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: 0.3s;
            font-weight: 500;
        }
        .sidebar-menu li a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 35px;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
            background: #f4f7f6;
            min-height: 100vh;
        }
        /* Style Tambahan untuk Button Tema Hijau Putih */
        .btn-theme-green {
            background-color: #2E8B47;
            color: white;
            border: 2px solid #2E8B47;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: inline-block;
        }
        .btn-theme-green:hover {
            background-color: white;
            color: #2E8B47;
        }
        .btn-theme-white {
            background-color: white;
            color: #2E8B47;
            border: 2px solid #2E8B47;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: inline-block;
        }
        .btn-theme-white:hover {
            background-color: #2E8B47;
            color: white;
        }
  </style>
</head>
<body>

<div class="admin-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3>MagangInAja</h3>
            <small>Administrator Panel</small>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?= $base_url; ?>dashboard/dashboard_admin.php">Dashboard</a></li>
            <li><a href="<?= $base_url; ?>admin/data_perusahaan.php">Data Perusahaan</a></li>
            <li style="margin-top: 50px;">
                <a href="<?= $base_url; ?>/auth/logout.php" style="color: #ff7675;">Logout</a>
            </li>
        </ul>
    </aside>
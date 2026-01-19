<?php
require_once __DIR__ . '/../config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPADEKPNP - Sistem Informasi Magang</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/style.css">
    <link rel="stylesheet" href="<?= $base_url; ?>css/landing.css">
</head>
<body>

<nav class="navbar">
    <a href="<?= $base_url; ?>index.php" class="nav-brand">
        SIPADEKPNP
    </a>

    <ul class="nav-links">
        <li><a href="<?= $base_url; ?>index.php">Beranda</a></li>
        <li><a href="#fitur">Fitur</a></li>
        <li><a href="#tentang">Tentang</a></li>
    </ul>

    <div class="auth-buttons">
        <a href="<?= $base_url; ?>auth/login.php" class="btn-login">Masuk</a>
    </div>
</nav>
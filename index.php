<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPADEKPNP - Magang Politeknik Negeri Padang</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <link rel="stylesheet" href="css/beranda.css">
</head>
<body>

    <div class="hero-wrapper">
        <div class="bg-pattern"></div>

        <nav>
            <a href="index.php" class="logo-container">
                <img src="assets/logo.png" alt="Logo PNP" class="logo-img" onerror="this.style.display='none'">
                <div class="logo-text">
                    SIPADEKPNP
                </div>
            </a>

            <div class="nav-links">
                <a href="#">Home</a>
                <a href="#">Lowongan</a>
                <a href="#">Mitra Industri</a>
                <a href="#">Jurusan</a>
            </div>

            <div class="dropdown">
                <a href="javascript:void(0)" class="btn-login" onclick="bukaDropdown()">Log In ▾</a>
                <div id="menuLogin" class="dropdown-content">
                    <a href="#">Login Mahasiswa</a>
                    <a href="admin/login_admin.php">Login Admin</a>
                </div>
            </div>
        </nav>

        <div class="hero-container">
            <div class="hero-text">
                <h1>Transformasi Skill, <br><span class="text-accent">Pengalaman Nyata.</span></h1>
                <p>Selamat datang di portal resmi <strong>SIPADEKPNP</strong>. Sistem Informasi Praktik Kerja & Dedikasi Politeknik Negeri Padang yang menghubungkan mahasiswa vokasi dengan industri terbaik.</p>
                
                <div class="btn-group">
                    <a href="#" class="btn-main">
                        Pelajari Selengkapnya
                        <i class="ph-bold ph-arrow-right"></i>
                    </a>
                </div>
            </div>

        <div class="hero-image-wrapper">
            <img src="img/ilustrasimagang.jpg" alt="Ilustrasi Magang" class="hero-img">
        </div>
        </div>

        <footer>
            <p>&copy; 2026 SIPADEKPNP. Sistem Informasi Praktik Kerja & Dedikasi.</p>
        </footer>
    </div>

    <script>
        function bukaDropdown() {
            document.getElementById("menuLogin").classList.toggle("tampil");
            document.querySelector(".btn-login").classList.toggle("aktif");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.btn-login')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var tombol = document.querySelector(".btn-login");
                
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('tampil')) {
                        openDropdown.classList.remove('tampil');
                        tombol.classList.remove('aktif');
                    }
                }
            }
        }
    </script>

</body>
</html>
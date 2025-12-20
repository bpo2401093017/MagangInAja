<?php 
// Memuat konfigurasi database (jika nanti butuh data)
require_once 'config.php'; 

// Memuat bagian atas halaman
include 'templates/header.php'; 
?>

<div class="hero-section">
    <h1>Selamat Datang di SIPADEKPNP</h1>
    <p>Sistem Informasi Praktik Kerja & Dedikasi Politeknik Negeri Padang.</p>
    <p>Platform terintegrasi untuk pengelolaan data magang, perusahaan mitra, dan mahasiswa.</p>
    
    <div style="margin-top: 20px;">
        <a href="admin/login_admin.php" class="btn-hijau">Masuk ke Portal Admin</a>
    </div>
</div>

<?php 
// Memuat bagian bawah halaman
include 'templates/footer.php'; 
?>
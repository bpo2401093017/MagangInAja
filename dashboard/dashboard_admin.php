<?php
require_once '../config.php';
require_once '../templates/header_admin.php';


$total_perusahaan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM perusahaan"))['total'];
$total_jurusan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM jurusan"))['total'];
?>

<main class="main-content">
    <div class="content-header">
        <h2 class="page-title">Selamat Datang, <?= isset($_SESSION['username']) ? ucfirst($_SESSION['username']) : 'Admin'; ?>!</h2>
        <p class="page-subtitle">
            Ringkasan data mitra <strong>SIPADEKPNP</strong>.
        </p>
    </div>

    <div class="simple-data-list">
        <div class="data-row">
            <div class="data-info">
                <span class="data-label">Mitra Industri</span>
                <span class="data-desc">Perusahaan Terdaftar saat ini</span>
            </div>
            <div class="data-value" style="color: #2E8B47; font-size: 2rem; font-weight: bold;"><?= $total_perusahaan; ?></div>
        </div>
    </div>
     <div style="margin-top: 10px; display: flex; gap: 15px;">
        <a href="../perusahaan/register_perusahaan/register.php" class="btn-theme-green">Tambah Mitra Baru</a>
        <a href="../admin/data_perusahaan.php" class="btn-theme-white">Kelola Data Perusahaan</a>
    </div>
    
    <div class="simple-data-list">
        <div class="data-row">
            <div class="data-info">
                <span class="data-label">Jurusan Politeknik Negri Padang</span>
                <span class="data-desc">Jurusan Terdaftar saat ini</span>
            </div>
            <div class="data-value" style="color: #2E8B47; font-size: 2rem; font-weight: bold;"><?= $total_jurusan; ?></div>
        </div>
    </div>
     <div style="margin-top: 30px; display: flex; gap: 30px;">
        <a href="../admin/data_jurusan/register_jurusan.php" class="btn-theme-green">Tambah Jurusan Baru</a>
        <a href="../admin/data_perusahaan.php" class="btn-theme-white">Kelola Data Jurusan</a>
    </div>

   
</main>

</div> 
</body> 


</html>
<?php
include '../templates/footer.php';
?>
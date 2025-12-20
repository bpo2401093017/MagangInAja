<?php
require_once '../config.php';
require_once '../templates/header_admin.php';

$query_perusahaan = "SELECT COUNT(*) as total FROM perusahaan";
$res_perusahaan = mysqli_query($conn, $query_perusahaan);
$row_perusahaan = mysqli_fetch_assoc($res_perusahaan);
$total_perusahaan = $row_perusahaan['total'];
?>

<main class="main-content">
    <div class="content-header">
        <h2 class="page-title">Selamat Datang, <?= isset($_SESSION['username']) ? ucfirst($_SESSION['username']) : 'Admin'; ?>!</h2>
        <p class="page-subtitle">
            Selamat datang di panel administrasi <strong>SIPADEKPNP</strong>.<br>
            Anda memiliki akses penuh untuk mengelola data kemitraan perusahaan dan pemantauan sistem.
        </p>
    </div>

    <div class="simple-data-list">
        
        <div class="data-row">
            <div class="data-info">
                <span class="data-label">Mitra Perusahaan</span>
                <span class="data-desc">Total perusahaan aktif yang telah bekerjasama</span>
            </div>
            <div class="data-value">
                <?= $total_perusahaan; ?>
            </div>
        </div>

    </div>
</main>

</div> </body>
</html>
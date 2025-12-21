<?php
require_once '../config.php';
require_once '../templates/header_admin.php';

$query = "SELECT * FROM perusahaan ORDER BY id_perusahaan DESC";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_perusahaan.css">

<main class="main-content">
    <div class="table-header">
        <div>
            <h2 class="page-title">Data Mitra Perusahaan</h2>
            <p class="page-subtitle">Daftar seluruh mitra industri yang terhubung dengan SIPADEKPNP</p>
        </div>
        <a href="../perusahaan/register_perusahaan/register.php" class="btn-theme-green"> + Registrasi Mitra</a>
    </div>

    <div class="data-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="company-item">
                    <div class="company-info">
                        <div class="company-logo-circle">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div class="company-details">
                            <h4><?= $row['nama_perusahaan']; ?></h4>
                            <p><?= $row['email']; ?> • <?= $row['no_hp']; ?> • PIC: <?= $row['contact_person']; ?></p>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="#" class="btn-edit">Edit</a>
                        <a href="#" class="btn-delete" onclick="return confirm('Hapus mitra ini?')">Hapus</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #999;">
                <p>Belum ada data mitra perusahaan.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

</div> </body> </html>
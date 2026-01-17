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
            <h2 class="page-title">Manajemen Mitra Industri</h2>
            <p class="page-subtitle">Daftar perusahaan yang telah terdaftar dalam sistem.</p>
        </div>
        <a href="../perusahaan/register_perusahaan/register.php" class="btn-theme-green"> + Registrasi Mitra</a>
    </div>

    <div class="data-container" style="overflow-x: auto;">
        <table class="company-table" style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr style="background: #f8faf8; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px; text-align: left;">Nama Perusahaan</th>
                    <th style="padding: 15px; text-align: left;">Email</th>
                    <th style="padding: 15px; text-align: left;">No. Telp</th>
                    <th style="padding: 15px; text-align: left;">PIC / Penanggung Jawab</th>
                    <th style="padding: 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr style="border-bottom: 1px solid #eee; transition: 0.3s;">
                            <td style="padding: 15px; font-weight: 600; color: #333;"><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                            <td style="padding: 15px; color: #666;"><?= htmlspecialchars($row['email']); ?></td>
                            <td style="padding: 15px; color: #666;"><?= htmlspecialchars($row['no_hp']); ?></td>
                            <td style="padding: 15px; color: #666;"><?= htmlspecialchars($row['contact_person']); ?></td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="edit_perusahaan.php?id=<?= $row['id_perusahaan']; ?>" class="btn-edit" style="text-decoration: none;">Edit</a>
                                    <a href="hapus_perusahaan.php?id=<?= $row['id_perusahaan']; ?>" class="btn-delete" style="text-decoration: none;" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #999;">Belum ada data perusahaan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        



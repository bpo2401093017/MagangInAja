<?php
require_once '../../templates/header_jurusan.php';

$query = "SELECT prodi.*, jurusan.nama_jurusan FROM prodi JOIN jurusan ON prodi.id_jurusan = jurusan.id_jurusan JOIN users ON users.id_user = jurusan.id_user WHERE users.id_user = '$id_user' ORDER BY id_prodi DESC";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_prodi.css">

<main class="main-content">
    <div class="table-header">
        <div>
            <h2 class="page-title">Manajemen Program Studi</h2>
            <p class="page-subtitle">Daftar program studi yang telah terdaftar dalam sistem.</p>
        </div>
        <a href="register.php" class="btn-theme-green"> + Registrasi Prodi</a>
    </div>

    <div class="data-container" style="overflow-x: auto;">
        <table class="company-table" style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr style="background: #f8faf8; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px; text-align: left;">Nama Program Studi</th>
                    <th style="padding: 15px; text-align: left;">Jurusan</th>
                    <th style="padding: 15px; text-align: left;">Status</th>
                    <th style="padding: 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr style="border-bottom: 1px solid #eee; transition: 0.3s;">
                            <td style="padding: 15px; font-weight: 600; color: #333;"><?= htmlspecialchars($row['nama_prodi']); ?></td>
                            <td style="padding: 15px; color: #666;"><?= htmlspecialchars($row['nama_jurusan']); ?></td>
                            <td style="padding: 15px; color: #666;"><?= htmlspecialchars($row['status']); ?></td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="edit_prodi.php?id=<?= $row['id_prodi']; ?>" class="btn-edit" style="text-decoration: none;">Edit</a>                                    
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
        



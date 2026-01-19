<?php
require_once '../templates/header_perusahaan.php';

$id_user = $_SESSION['user_id'];
$q_perusahaan = mysqli_query($conn, "SELECT id_perusahaan, foto FROM perusahaan WHERE id_user = '$id_user'");
$data_perusahaan = mysqli_fetch_assoc($q_perusahaan);
$id_perusahaan = $data_perusahaan['id_perusahaan'] ?? 0;
$foto_perusahaan = $data_perusahaan['foto'] ?? 'default.png';

$query = "SELECT * FROM lowongan WHERE id_perusahaan = '$id_perusahaan' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/lowongan.css">

<div class="main-content">
    <div class="content-header">
        <h2>Kelola Lowongan Magang</h2>
        <p>Tambah, edit, atau hapus lowongan magang perusahaan Anda.</p>
    </div>

    <a href="tambah_lowongan.php" class="btn-add">+ Tambah Lowongan Baru</a>

    <div class="job-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="job-card">
                    <div class="card-header">
                        <img src="<?= $base_url; ?>img/<?= $foto_perusahaan; ?>" onerror="this.src='https://ui-avatars.com/api/?name=Company'" alt="Logo" class="company-logo">
                        <span class="badge-status status-<?= $row['status']; ?>"><?= $row['status']; ?></span>
                    </div>
                    <div class="card-body">
                        <h3 class="job-title"><?= htmlspecialchars($row['judul_lowongan']); ?></h3>
                        <p class="job-info">📅 <?= date('d M Y', strtotime($row['tanggal_mulai'])); ?> - <?= date('d M Y', strtotime($row['tanggal_selesai'])); ?></p>
                        <p class="job-info">📍 <?= htmlspecialchars($row['lokasi']); ?></p>
                        <p class="job-info">👤 Kuota: <?= $row['kuota']; ?> Orang</p>
                        <div class="job-desc">
                            <?= nl2br(htmlspecialchars(substr($row['persyaratan'], 0, 100))); ?>...
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="edit_lowongan.php?id=<?= $row['id_lowongan']; ?>" class="btn-edit">Edit</a>
                        <a href="proses_lowongan.php?action=delete&id=<?= $row['id_lowongan']; ?>" class="btn-delete" onclick="return confirm('Hapus lowongan ini?')">Hapus</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: #888;">Belum ada lowongan yang ditambahkan.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
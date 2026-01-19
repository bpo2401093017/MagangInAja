<?php
require_once '../templates/header_perusahaan.php';

$id_user = $_SESSION['user_id'];
$q_p = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan WHERE id_user = '$id_user'");
$d_p = mysqli_fetch_assoc($q_p);
$id_perusahaan = $d_p['id_perusahaan'];

$query = "SELECT p.*, m.nama_lengkap, m.nim, u.foto,
          (SELECT COUNT(*) FROM logbook l WHERE l.id_mahasiswa = m.id_mahasiswa AND l.status = 'pending') as log_pending
          FROM pengajuan p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN users u ON m.id_user = u.id_user
          WHERE p.id_perusahaan = '$id_perusahaan' AND p.status = 'diterima'
          ORDER BY m.nama_lengkap ASC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/pengajuan.css">

<div class="main-content">
    <div class="card-container">
        <h2 style="margin-bottom: 20px; color: #2E8B47;">Monitoring Mahasiswa Magang</h2>
        <p style="margin-bottom: 20px; color: #666;">Pantau aktivitas harian mahasiswa yang sedang aktif magang.</p>
        
        <div class="table-responsive">
            <table class="table-app">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Posisi Magang</th>
                        <th>Mulai Magang</th>
                        <th>Logbook Pending</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td>
                                    <div class="profile-sm">
                                        <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $row['foto'] ?? 'default.png'; ?>" class="thumb-img">
                                        <div>
                                            <div style="font-weight: bold;"><?= htmlspecialchars($row['nama_lengkap']); ?></div>
                                            <small><?= htmlspecialchars($row['nim']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                                <td><?= date('d M Y', strtotime($row['create_at'])); ?></td>
                                <td>
                                    <?php if ($row['log_pending'] > 0): ?>
                                        <span class="status-badge bg-warning"><?= $row['log_pending']; ?> Baru</span>
                                    <?php else: ?>
                                        <span class="status-badge bg-success">Up to date</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="lihat_logbook.php?id=<?= $row['id_mahasiswa']; ?>" class="btn-sm btn-blue">
                                        Lihat Progress
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 30px;">Belum ada mahasiswa yang aktif magang.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
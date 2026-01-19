<?php
require_once '../templates/header_perusahaan.php';

$id_user = $_SESSION['user_id'];
$q_p = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan WHERE id_user = '$id_user'");
$d_p = mysqli_fetch_assoc($q_p);
$id_perusahaan = $d_p['id_perusahaan'];

$query = "SELECT p.*, m.nama_lengkap, m.nim, l.judul_lowongan, u.foto 
          FROM pengajuan p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN users u ON m.id_user = u.id_user
          JOIN lowongan l ON p.id_lowongan = l.id_lowongan
          WHERE p.id_perusahaan = '$id_perusahaan' 
          AND p.status IN ('pending', 'diterima', 'ditolak')
          ORDER BY FIELD(p.status, 'pending', 'diterima', 'ditolak'), p.create_at DESC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/pengajuan.css">

<div class="main-content">
    <div class="card-container">
        <h2 style="margin-bottom: 20px; color: #2E8B47;">Daftar Pelamar Magang</h2>
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'processed'): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                Status pelamar berhasil diperbarui.
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table-app">
                <thead>
                    <tr>
                        <th>Pelamar</th>
                        <th>Posisi Dilamar</th>
                        <th>Tanggal Lamar</th>
                        <th>Status</th>
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
                                            <small style="color: #888;"><?= htmlspecialchars($row['nim']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['judul_lowongan']); ?></td>
                                <td><?= date('d/m/Y', strtotime($row['create_at'])); ?></td>
                                <td>
                                    <?php
                                    $bg = 'bg-warning'; 
                                    if ($row['status'] == 'diterima') $bg = 'bg-success';
                                    if ($row['status'] == 'ditolak') $bg = 'bg-danger';
                                    $label = ($row['status'] == 'pending') ? 'Perlu Seleksi' : $row['status'];
                                    ?>
                                    <span class="status-badge <?= $bg; ?>"><?= $label; ?></span>
                                </td>
                                <td>
                                    <a href="detail_lamaran.php?id=<?= $row['id_pengajuan']; ?>" class="btn-sm btn-blue">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 30px;">Belum ada pelamar masuk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
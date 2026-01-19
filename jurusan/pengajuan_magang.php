<?php
require_once '../templates/header_jurusan.php';

$id_user = $_SESSION['user_id'];
$q_jur = mysqli_query($conn, "SELECT id_jurusan FROM jurusan WHERE id_user = '$id_user'");
$d_jur = mysqli_fetch_assoc($q_jur);
$id_jurusan = $d_jur['id_jurusan'];

$query = "SELECT p.*, m.nama_lengkap, m.nim, l.judul_lowongan, pr.nama_perusahaan, u.foto 
          FROM pengajuan p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN users u ON m.id_user = u.id_user
          JOIN lowongan l ON p.id_lowongan = l.id_lowongan
          JOIN perusahaan pr ON p.id_perusahaan = pr.id_perusahaan
          WHERE m.id_jurusan = '$id_jurusan' AND p.status = 'menunggu_verifikasi'
          ORDER BY p.create_at ASC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/pengajuan.css">

<div class="main-content">
    <div class="card-container">
        <h2 style="margin-bottom: 20px; color: #2E8B47;">Verifikasi Pengajuan Magang</h2>
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'validated'): ?>
            <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                Pengajuan berhasil divalidasi dan diteruskan ke perusahaan.
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table-app">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Lowongan Dituju</th>
                        <th>Perusahaan</th>
                        <th>Tanggal</th>
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
                                <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                                <td><?= date('d/m/Y', strtotime($row['create_at'])); ?></td>
                                <td>
                                    <a href="proses_validasi_pengajuan.php?id=<?= $row['id_pengajuan']; ?>&action=approve" 
                                       class="btn-sm btn-green"
                                       onclick="return confirm('Validasi pengajuan ini? Data akan diteruskan ke perusahaan.')">
                                       Validasi
                                    </a>
                                    <a href="proses_validasi_pengajuan.php?id=<?= $row['id_pengajuan']; ?>&action=reject" 
                                       class="btn-sm btn-red"
                                       onclick="return confirm('Tolak pengajuan ini?')">
                                       Tolak
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 30px;">Tidak ada pengajuan baru yang perlu diverifikasi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
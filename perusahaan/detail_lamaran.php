<?php
require_once '../templates/header_perusahaan.php';

if (!isset($_GET['id'])) {
    header("Location: pengajuan_magang.php");
    exit;
}

$id_pengajuan = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT p.*, m.*, u.email as email_akun, u.no_hp as hp_akun, u.foto, l.judul_lowongan, j.nama_jurusan, pr.nama_prodi
          FROM pengajuan p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN users u ON m.id_user = u.id_user
          JOIN lowongan l ON p.id_lowongan = l.id_lowongan
          LEFT JOIN jurusan j ON m.id_jurusan = j.id_jurusan
          LEFT JOIN prodi pr ON m.id_prodi = pr.id_prodi
          WHERE p.id_pengajuan = '$id_pengajuan'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$id_user_mhs = $data['id_user'];
$q_berkas = mysqli_query($conn, "SELECT * FROM mahasiswa_berkas WHERE id_user = '$id_user_mhs'");
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/pengajuan.css">

<div class="main-content">
    <div style="margin-bottom: 20px;">
        <a href="pengajuan_magang.php" style="text-decoration: none; color: #666;">&larr; Kembali ke Daftar</a>
    </div>

    <div class="card-container">
        <div class="detail-wrapper">
            <aside class="sidebar-profile">
                <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $data['foto'] ?? 'default.png'; ?>" class="big-avatar">
                <h3 style="margin: 0; color: #333;"><?= htmlspecialchars($data['nama_lengkap']); ?></h3>
                <p style="margin: 5px 0 20px; color: #888;"><?= htmlspecialchars($data['nim']); ?></p>

                <div style="text-align: left;">
                    <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px;">Berkas Pelamar</h4>
                    <?php while($b = mysqli_fetch_assoc($q_berkas)): ?>
                        <a href="<?= $base_url; ?>uploads/mahasiswa/<?= $b['nama_file']; ?>" target="_blank" class="file-link">
                            📄 <?= strtoupper($b['jenis_berkas']); ?>
                        </a>
                    <?php endwhile; ?>
                    <?php if (mysqli_num_rows($q_berkas) == 0): ?>
                        <p style="font-size: 13px; color: #999;">Tidak ada berkas diunggah.</p>
                    <?php endif; ?>
                </div>
            </aside>

            <div class="main-profile">
                <h2 style="color: #2E8B47; margin-top: 0;">Detail Lamaran</h2>
                <div style="background: #f8faf8; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <small>Melamar Posisi:</small>
                    <div style="font-size: 18px; font-weight: bold;"><?= $data['judul_lowongan']; ?></div>
                    <small>Tanggal Pengajuan: <?= date('d F Y', strtotime($data['create_at'])); ?></small>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <label>Jurusan</label>
                        <div><?= $data['nama_jurusan']; ?></div>
                    </div>
                    <div class="info-box">
                        <label>Program Studi</label>
                        <div><?= $data['nama_prodi']; ?></div>
                    </div>
                    <div class="info-box">
                        <label>Email</label>
                        <div><?= $data['email_akun']; ?></div>
                    </div>
                    <div class="info-box">
                        <label>No. WhatsApp</label>
                        <div><?= $data['hp_akun']; ?></div>
                    </div>
                    <div class="info-box">
                        <label>Alamat Domisili</label>
                        <div><?= $data['alamat']; ?></div>
                    </div>
                    <div class="info-box">
                        <label>Angkatan</label>
                        <div><?= $data['angkatan']; ?></div>
                    </div>
                </div>

                <?php if ($data['status'] == 'pending'): ?>
                    <div class="action-bar">
                        <a href="proses_seleksi.php?id=<?= $data['id_pengajuan']; ?>&action=accept" 
                           class="btn-lg btn-green" 
                           onclick="return confirm('Terima mahasiswa ini untuk magang?')">
                           TERIMA LAMARAN
                        </a>
                        <a href="proses_seleksi.php?id=<?= $data['id_pengajuan']; ?>&action=reject" 
                           class="btn-lg btn-red" 
                           onclick="return confirm('Tolak lamaran ini?')">
                           TOLAK
                        </a>
                    </div>
                <?php else: ?>
                    <div style="margin-top: 30px; padding: 20px; text-align: center; background: #eee; border-radius: 8px; font-weight: bold; color: #555;">
                        Status: <?= strtoupper($data['status']); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
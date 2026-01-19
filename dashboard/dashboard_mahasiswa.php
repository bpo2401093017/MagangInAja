<?php
require_once '../auth/auth_mahasiswa.php'; 
require_once '../templates/header_mahasiswa.php';

$id_user = $_SESSION['user_id'];
$q_mhs = mysqli_query($conn, "SELECT id_mahasiswa, nama_lengkap FROM mahasiswa WHERE id_user = '$id_user'");
$d_mhs = mysqli_fetch_assoc($q_mhs);
$id_mahasiswa = $d_mhs['id_mahasiswa'];

// Cek status lamaran aktif
$q_status = mysqli_query($conn, "SELECT p.*, l.judul_lowongan, pr.nama_perusahaan 
                                 FROM pengajuan p
                                 JOIN lowongan l ON p.id_lowongan = l.id_lowongan
                                 JOIN perusahaan pr ON p.id_perusahaan = pr.id_perusahaan
                                 WHERE p.id_mahasiswa = '$id_mahasiswa' 
                                 ORDER BY p.create_at DESC LIMIT 1");
$lamaran = mysqli_fetch_assoc($q_status);

// Statistik Logbook
$q_log = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM logbook WHERE id_mahasiswa = '$id_mahasiswa'"));
$total_log = $q_log['total'];
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/dashboard_new.css">

<div class="main-content">
    <div class="welcome-section">
        <div class="welcome-text">
            <h1>Halo, <?= htmlspecialchars($d_mhs['nama_lengkap']); ?>!</h1>
            <p>Tetap semangat dan pantau terus status magangmu.</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">📌</div>
            <div class="stat-info">
                <h3><?= ($lamaran) ? '1' : '0'; ?></h3>
                <p>Lamaran Aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green">📝</div>
            <div class="stat-info">
                <h3><?= $total_log; ?></h3>
                <p>Logbook Terisi</p>
            </div>
        </div>
    </div>

    <?php if ($lamaran): ?>
        <div class="action-card" style="text-align: left;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: #2E8B47;">Status Terkini</h3>
                <span style="padding: 5px 15px; border-radius: 20px; font-weight: bold; text-transform: uppercase; font-size: 12px;
                    <?= ($lamaran['status']=='diterima') ? 'background:#d4edda; color:#155724;' : 
                       (($lamaran['status']=='ditolak') ? 'background:#f8d7da; color:#721c24;' : 'background:#fff3cd; color:#856404;'); ?>">
                    <?= str_replace('_', ' ', $lamaran['status']); ?>
                </span>
            </div>
            
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="margin-bottom: 5px;"><strong><?= htmlspecialchars($lamaran['judul_lowongan']); ?></strong></p>
                <p style="color: #666; margin-top: 0;"><?= htmlspecialchars($lamaran['nama_perusahaan']); ?></p>

                <?php if ($lamaran['status'] == 'diterima' && !empty($lamaran['file_balasan'])): ?>
                    <div style="margin-top: 20px; background: #e8f5e9; padding: 15px; border-radius: 8px; border: 1px solid #c8e6c9;">
                        <p style="margin: 0 0 10px 0; font-weight: bold; color: #2E8B47;">🎉 Selamat! Anda Diterima.</p>
                        <p style="font-size: 13px; margin: 0 0 10px 0;">Silakan unduh surat balasan dari perusahaan sebagai bukti penerimaan magang.</p>
                        <a href="<?= $base_url; ?>uploads/surat_balasan/<?= $lamaran['file_balasan']; ?>" target="_blank" class="btn-download">
                            📥 Download Surat Balasan
                        </a>
                    </div>
                <?php elseif ($lamaran['status'] == 'ditolak'): ?>
                    <p style="color: #c62828; margin-top: 10px;">Maaf, lamaran Anda belum diterima. Silakan cari lowongan lain.</p>
                    <a href="../mahasiswa/lowongan.php" class="btn-download" style="background: #ef6c00;">Cari Lowongan Lain</a>
                <?php else: ?>
                    <p style="color: #f57f17; margin-top: 10px;">Lamaran sedang diproses. Harap cek berkala.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="action-card">
            <img src="https://img.icons8.com/ios/100/2E8B47/search--v1.png" style="opacity: 0.5;">
            <p>Kamu belum melamar dimanapun.</p>
            <a href="../mahasiswa/lowongan.php" class="btn-download">Mulai Cari Magang</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
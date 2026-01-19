<?php
require_once '../auth/auth_mahasiswa.php';
require_once '../templates/header_mahasiswa.php';

$id_user = $_SESSION['user_id'];
$q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
$d_mhs = mysqli_fetch_assoc($q_mhs);
$id_mahasiswa = $d_mhs['id_mahasiswa'];

$query = "SELECT p.*, l.judul_lowongan 
          FROM pengajuan p 
          LEFT JOIN lowongan l ON p.id_lowongan = l.id_lowongan 
          WHERE p.id_mahasiswa = '$id_mahasiswa' 
          ORDER BY p.create_at DESC";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/lowongan.css">

<style>
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: capitalize;
    }
    .status-menunggu_verifikasi { background: #fff3cd; color: #856404; }
    .status-diterima { background: #d4edda; color: #155724; }
    .status-ditolak { background: #f8d7da; color: #721c24; }
    .status-verifikasi_ditolak { background: #f8d7da; color: #721c24; }
    
    .history-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        border-left: 5px solid #2E8B47;
    }
</style>

<div class="main-content">
    <div class="content-header">
        <h2>Riwayat Lamaran</h2>
        <p>Pantau status pengajuan magang Anda di sini.</p>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            Lamaran berhasil dikirim! Tunggu konfirmasi dari perusahaan.
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="history-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div>
                        <h3 style="margin: 0 0 5px 0; font-size: 18px;"><?= htmlspecialchars($row['judul_lowongan']); ?></h3>
                        <p style="margin: 0; color: #666; font-weight: 500;"><?= htmlspecialchars($row['nama_perusahaan']); ?></p>
                    </div>
                    <span class="status-badge status-<?= $row['status']; ?>">
                        <?= str_replace('_', ' ', $row['status']); ?>
                    </span>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; font-size: 14px; color: #555;">
                    <div>
                        <span style="display: block; color: #888; font-size: 12px;">Tanggal Pengajuan</span>
                        <?= date('d F Y, H:i', strtotime($row['create_at'])); ?> WIB
                    </div>
                    <div>
                        <span style="display: block; color: #888; font-size: 12px;">Jenis Pengajuan</span>
                        <span style="text-transform: capitalize;"><?= $row['jenis']; ?></span>
                    </div>
                </div>

                <?php if($row['status'] == 'ditolak' || $row['status'] == 'verifikasi_ditolak'): ?>
                    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #eee;">
                        <p style="margin: 0; font-size: 14px; color: #721c24;">
                            <i class="ph-bold ph-info"></i> Lamaran ini telah ditolak. Anda sekarang dapat melamar di lowongan lain.
                        </p>
                        <a href="lowongan.php" style="display: inline-block; margin-top: 10px; color: #2E8B47; font-weight: 600; text-decoration: none;">Cari Lowongan Baru &rarr;</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 50px; background: white; border-radius: 12px;">
            <p style="color: #888;">Anda belum memiliki riwayat lamaran magang.</p>
            <a href="lowongan.php" class="btn-search" style="text-decoration: none; display: inline-block; margin-top: 10px;">Mulai Cari Magang</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
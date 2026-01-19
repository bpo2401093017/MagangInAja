<?php
require_once '../auth/auth_mahasiswa.php';
require_once '../templates/header_mahasiswa.php';

if (!isset($_GET['id'])) {
    header("Location: lowongan.php");
    exit;
}

$id_lowongan = mysqli_real_escape_string($conn, $_GET['id']);
$id_mahasiswa_user = $_SESSION['user_id'];

$q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_mahasiswa_user'");
$d_mhs = mysqli_fetch_assoc($q_mhs);
$id_mahasiswa = $d_mhs['id_mahasiswa'];

$query = "SELECT l.*, p.nama_perusahaan, p.foto, p.alamat_perusahaan as alamat_kantor, p.id_perusahaan 
          FROM lowongan l 
          JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan 
          WHERE l.id_lowongan = '$id_lowongan'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Lowongan tidak ditemukan!'); window.location='lowongan.php';</script>";
    exit;
}

$cek_lamaran = mysqli_query($conn, "SELECT * FROM pengajuan 
                                    WHERE id_mahasiswa = '$id_mahasiswa' 
                                    AND status NOT IN ('ditolak', 'verifikasi_ditolak')");
$sedang_melamar = mysqli_num_rows($cek_lamaran) > 0;
$data_lamaran = mysqli_fetch_assoc($cek_lamaran);
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/detail_lowongan.css">

<div class="main-content">
    
    <div class="detail-container">
        <div class="detail-header">
            <img src="<?= $base_url; ?>img/<?= $data['foto']; ?>" 
                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($data['nama_perusahaan']); ?>&background=fff&color=2E8B47'" 
                 class="company-logo-large" alt="Logo">
            <div class="header-info">
                <h1><?= htmlspecialchars($data['judul_lowongan']); ?></h1>
                <h3><?= htmlspecialchars($data['nama_perusahaan']); ?></h3>
                <div class="header-meta">
                    <span>📍 <?= htmlspecialchars($data['lokasi']); ?></span>
                    <span>📅 Posting: <?= date('d M Y', strtotime($data['created_at'])); ?></span>
                </div>
            </div>
        </div>

        <div class="detail-body">
            <div class="main-info">
                <?php if ($sedang_melamar): ?>
                    <div class="alert-warning">
                        <strong>Perhatian:</strong> Anda sedang memiliki lamaran aktif di 
                        <u><?= ($data_lamaran['id_lowongan'] == $id_lowongan) ? 'Lowongan ini' : 'Perusahaan lain'; ?></u>. 
                        Sesuai peraturan, Anda hanya dapat melamar 1 lowongan dalam satu waktu sampai status diterima/ditolak.
                    </div>
                <?php endif; ?>

                <div class="section-title">Deskripsi & Persyaratan</div>
                <div class="description-box">
                    <?= nl2br(htmlspecialchars($data['persyaratan'])); ?>
                </div>

                <a href="lowongan.php" class="btn-back">← Kembali ke Daftar Lowongan</a>
            </div>

            <aside class="sidebar-box">
                <div class="info-item">
                    <label>Batas Pendaftaran</label>
                    <p><?= date('d M Y', strtotime($data['tanggal_selesai'])); ?></p>
                </div>
                <div class="info-item">
                    <label>Kuota Penerimaan</label>
                    <p><?= $data['kuota']; ?> Mahasiswa</p>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <p style="text-transform: capitalize; color: #2E8B47;"><?= $data['status']; ?></p>
                </div>
                
                <hr style="border: 0; border-top: 1px solid #e8f5e9; margin: 20px 0;">

                <?php if ($sedang_melamar): ?>
                    <button class="btn-disabled" disabled>
                        <?= ($data_lamaran['id_lowongan'] == $id_lowongan) ? 'Sudah Dilamar' : 'Lamaran Aktif Lain'; ?>
                    </button>
                <?php else: ?>
                    <?php if ($data['status'] == 'dibuka'): ?>
                        <form action="proses_lamar.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin melamar posisi ini? Anda tidak bisa melamar di tempat lain setelah ini.');">
                            <input type="hidden" name="id_lowongan" value="<?= $data['id_lowongan']; ?>">
                            <input type="hidden" name="id_perusahaan" value="<?= $data['id_perusahaan']; ?>">
                            <input type="hidden" name="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan']); ?>">
                            <input type="hidden" name="alamat_perusahaan" value="<?= htmlspecialchars($data['alamat_kantor']); ?>">
                            <button type="submit" name="lamar" class="btn-apply">Kirim Lamaran Sekarang</button>
                        </form>
                    <?php else: ?>
                        <button class="btn-disabled" disabled>Lowongan Ditutup</button>
                    <?php endif; ?>
                <?php endif; ?>
            </aside>
        </div>
    </div>

</div>
</body>
</html>
<?php
require_once '../templates/header_perusahaan.php';

if (!isset($_GET['id'])) {
    header("Location: pengajuan_magang.php");
    exit;
}

$id_pengajuan = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT p.*, m.nama_lengkap FROM pengajuan p 
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa 
          WHERE p.id_pengajuan = '$id_pengajuan'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/dashboard_new.css">

<div class="main-content">
    <div class="action-card" style="max-width: 600px; margin: 0 auto; text-align: left;">
        <h2 style="color: #2E8B47; text-align: center;">Konfirmasi Penerimaan</h2>
        <p style="text-align: center; color: #666;">
            Anda akan menerima <b><?= htmlspecialchars($data['nama_lengkap']); ?></b> sebagai peserta magang.
            Silakan upload Surat Balasan Resmi (PDF) untuk diunduh mahasiswa.
        </p>
        
        <form action="proses_seleksi.php" method="POST" enctype="multipart/form-data" style="margin-top: 30px;">
            <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan ?>">
            <input type="hidden" name="action" value="accept_with_file">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 10px;">Upload Surat Balasan (PDF)</label>
                <input type="file" name="file_balasan" required accept="application/pdf" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>

            <button type="submit" class="btn-download" style="background: #2E8B47; width: 100%; border: none; cursor: pointer;">
                Konfirmasi & Terima Mahasiswa
            </button>
            <a href="detail_lamaran.php?id=<?= $id_pengajuan ?>" style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
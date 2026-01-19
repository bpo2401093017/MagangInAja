<?php
require_once '../templates/header_perusahaan.php';

if (!isset($_GET['id'])) {
    header("Location: monitoring_mahasiswa.php");
    exit;
}

$id_mahasiswa = mysqli_real_escape_string($conn, $_GET['id']);
$id_user_perusahaan = $_SESSION['user_id'];
$q_p = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan WHERE id_user = '$id_user_perusahaan'");
$d_p = mysqli_fetch_assoc($q_p);
$id_perusahaan = $d_p['id_perusahaan'];

if (isset($_POST['approve_id'])) {
    $id_log = $_POST['approve_id'];
    mysqli_query($conn, "UPDATE logbook SET status = 'disetujui' WHERE id_logbook = '$id_log' AND id_perusahaan = '$id_perusahaan'");
}

$q_mhs = mysqli_query($conn, "SELECT nama_lengkap FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'");
$nama_mhs = mysqli_fetch_assoc($q_mhs)['nama_lengkap'];

$query = "SELECT * FROM logbook WHERE id_mahasiswa = '$id_mahasiswa' AND id_perusahaan = '$id_perusahaan' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/logbook.css">

<div class="main-content">
    <div class="logbook-header">
        <div>
            <h2>Logbook: <?= htmlspecialchars($nama_mhs); ?></h2>
            <a href="monitoring_mahasiswa.php" style="color: #666; text-decoration: none;">&larr; Kembali ke Daftar</a>
        </div>
    </div>

    <div class="timeline-container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="log-card <?= ($row['status'] == 'disetujui') ? 'approved' : 'pending'; ?>">
                    <div class="log-header">
                        <div class="log-date">
                            📅 <?= date('d F Y', strtotime($row['tanggal'])); ?>
                        </div>
                        
                        <?php if ($row['status'] == 'pending'): ?>
                            <form method="POST" style="margin: 0;">
                                <input type="hidden" name="approve_id" value="<?= $row['id_logbook']; ?>">
                                <button type="submit" class="btn-approve">✓ Setujui Kegiatan</button>
                            </form>
                        <?php else: ?>
                            <span class="status-tag tag-approved">Disetujui</span>
                        <?php endif; ?>
                    </div>
                    <div class="log-body">
                        <div class="log-content">
                            <?= nl2br(htmlspecialchars($row['kegiatan'])); ?>
                        </div>
                        <?php if ($row['dokumentasi']): ?>
                            <div class="log-img-box">
                                <a href="<?= $base_url; ?>uploads/logbook/<?= $row['dokumentasi']; ?>" target="_blank">
                                    <img src="<?= $base_url; ?>uploads/logbook/<?= $row['dokumentasi']; ?>" class="log-img">
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <p>Mahasiswa ini belum mengisi logbook.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
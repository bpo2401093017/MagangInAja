<?php
require_once '../auth/auth_mahasiswa.php';
require_once '../templates/header_mahasiswa.php';

$id_user = $_SESSION['user_id'];
$q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
$d_mhs = mysqli_fetch_assoc($q_mhs);
$id_mahasiswa = $d_mhs['id_mahasiswa'];

$q_status = mysqli_query($conn, "SELECT * FROM pengajuan WHERE id_mahasiswa = '$id_mahasiswa' AND status = 'diterima'");
$is_intern = mysqli_num_rows($q_status) > 0;
$data_magang = mysqli_fetch_assoc($q_status);

if ($is_intern) {
    $query = "SELECT * FROM logbook WHERE id_mahasiswa = '$id_mahasiswa' ORDER BY tanggal DESC, created_at DESC";
    $result = mysqli_query($conn, $query);
}
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/logbook.css">

<div class="main-content">
    <?php if (!$is_intern): ?>
        <div class="empty-state">
            <img src="https://img.icons8.com/ios/100/cccccc/lock.png" alt="Locked">
            <h3>Fitur Terkunci</h3>
            <p>Menu Logbook hanya tersedia untuk mahasiswa yang sudah <b>DITERIMA</b> magang.</p>
        </div>
    <?php else: ?>
        
        <div class="logbook-header">
            <div>
                <h2>Logbook Kegiatan Magang</h2>
                <p>Lokasi: <b><?= htmlspecialchars($data_magang['nama_perusahaan']); ?></b></p>
            </div>
            <a href="tambah_logbook.php" class="btn-add-log">+ Catat Kegiatan Hari Ini</a>
        </div>

        <div class="timeline-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="log-card <?= ($row['status'] == 'disetujui') ? 'approved' : 'pending'; ?>">
                        <div class="log-header">
                            <div class="log-date">
                                📅 <?= date('l, d F Y', strtotime($row['tanggal'])); ?>
                            </div>
                            <span class="status-tag tag-<?= ($row['status'] == 'disetujui') ? 'approved' : 'pending'; ?>">
                                <?= ($row['status'] == 'disetujui') ? 'Disetujui Mentor' : 'Menunggu Persetujuan'; ?>
                            </span>
                        </div>
                        <div class="log-body">
                            <div class="log-content">
                                <?= nl2br(htmlspecialchars($row['kegiatan'])); ?>
                            </div>
                            <?php if ($row['dokumentasi']): ?>
                                <div class="log-img-box">
                                    <a href="<?= $base_url; ?>uploads/logbook/<?= $row['dokumentasi']; ?>" target="_blank">
                                        <img src="<?= $base_url; ?>uploads/logbook/<?= $row['dokumentasi']; ?>" class="log-img" alt="Dokumentasi">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>Belum ada catatan kegiatan. Mulai isi logbook hari pertamamu!</p>
                </div>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>
</body>
</html>
<?php
require_once '../templates/header_jurusan.php';

$id_user_admin = $_SESSION['user_id'];
$query_info_jurusan = mysqli_query($conn, "SELECT id_jurusan FROM jurusan WHERE id_user = '$id_user_admin'");
$data_jurusan = mysqli_fetch_assoc($query_info_jurusan);

if (!$data_jurusan) {
    echo "<div class='alert-danger'>Error: Akun Admin Jurusan ini belum terhubung ke Data Jurusan. Hubungi Super Admin.</div>";
    exit; 
}

$id_jurusan_session = $data_jurusan['id_jurusan'];

$q_pending = "SELECT m.*, u.status, p.nama_prodi, u.id_user as uid 
              FROM mahasiswa m
              JOIN users u ON m.id_user = u.id_user
              JOIN prodi p ON m.id_prodi = p.id_prodi
              WHERE p.id_jurusan = '$id_jurusan_session' 
              AND u.status = 'Pending'
              ORDER BY m.create_at ASC"; 
$res_pending = mysqli_query($conn, $q_pending);

$q_aktif = "SELECT m.*, u.status, p.nama_prodi, u.email, u.id_user as uid
            FROM mahasiswa m
            JOIN users u ON m.id_user = u.id_user
            JOIN prodi p ON m.id_prodi = p.id_prodi
            WHERE p.id_jurusan = '$id_jurusan_session' 
            AND u.status = 'Verified'
            ORDER BY m.nama_lengkap ASC";
$res_aktif = mysqli_query($conn, $q_aktif);

$total_pending = mysqli_num_rows($res_pending);
$total_aktif = mysqli_num_rows($res_aktif);
?>

<div class="main-content">
    
    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'sukses_verifikasi'): ?>
        <div class="alert-success">
            Berhasil memverifikasi mahasiswa! Mahasiswa kini dapat login.
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'sukses_tolak'): ?>
        <div class="alert-danger">
            Mahasiswa telah ditolak.
        </div>
    <?php endif; ?>

    <div class="welcome-banner">
        <h2>Selamat Datang, Admin Jurusan!</h2>
        <p>Anda memiliki <strong class="highlight-red"><?= $total_pending; ?> mahasiswa baru</strong> yang menunggu verifikasi.</p>
    </div>

    <div class="dashboard-section">
        <div class="section-header danger-header">
            <h3>Pendaftar Baru (Perlu Verifikasi)</h3>
            <p>Pastikan nama dan NIM sesuai dengan data jurusan sebelum diverifikasi.</p>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Tgl Daftar</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Prodi</th>
                        <th>Kontak</th>
                        <th class="text-center">Aksi Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($total_pending > 0): ?>
                        <?php 
                        while($row = mysqli_fetch_assoc($res_pending)): 
                        ?>
                        <tr class="row-pending">
                            <td><?= date('d/m/Y', strtotime($row['create_at'])); ?></td>
                            <td><span class="nim-badge"><?= htmlspecialchars($row['nim']); ?></span></td>
                            <td><strong><?= htmlspecialchars($row['nama_lengkap']); ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_prodi']); ?></td>
                            <td><?= htmlspecialchars($row['no_hp']); ?></td>
                            <td class="text-center">
                                <a href="../jurusan/proses_verifikasi.php?id=<?= $row['uid']; ?>" 
                                   class="btn-action btn-verify"
                                   onclick="return confirm('Apakah data mahasiswa ini (<?= $row['nama_lengkap']; ?>) VALID dan boleh login?')">
                                    Terima
                                </a>
                                <a href="../jurusan/proses_tolak.php?id=<?= $row['uid']; ?>" 
                                   class="btn-action btn-reject"
                                   onclick="return confirm('Tolak pendaftaran ini?')">
                                    Tolak
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty-data">Tidak ada pendaftar baru saat ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <br>

    <div class="dashboard-section">
        <div class="section-header success-header">
            <h3>Data Mahasiswa Aktif</h3>
            <p>Daftar mahasiswa yang sudah diverifikasi dan dapat login.</p>
        </div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Prodi</th>
                        <th>Email</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($total_aktif > 0): ?>
                        <?php 
                        while($row = mysqli_fetch_assoc($res_aktif)): 
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nim']); ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row['nama_lengkap']); ?></strong>
                            </td>
                            <td><?= htmlspecialchars($row['nama_prodi']); ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? '-'); ?></td>
                            <td class="text-center">
                                <span class="badge-active">Verified</span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty-data">Belum ada mahasiswa aktif.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
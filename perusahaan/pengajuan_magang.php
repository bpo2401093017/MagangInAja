<?php
require_once '../templates/header_perusahaan.php';

$id_user = $_SESSION['user_id'];
$query_prs = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan WHERE id_user = '$id_user'");
$data_prs = mysqli_fetch_assoc($query_prs);

if (!$data_prs) {
    echo "<div class='main-content'><h3>Harap lengkapi Profil Perusahaan terlebih dahulu.</h3></div>";
    exit;
}
$id_perusahaan = $data_prs['id_perusahaan'];

// --- PERBAIKAN QUERY (BACA TABEL PENGAJUAN) ---
// Mengambil data dari tabel 'pengajuan' (bukan 'lamaran')
// JOIN ke mahasiswa untuk nama yang benar
// JOIN ke prodi & user untuk detail lain
$query = "SELECT p.*, 
                 m.nama_lengkap, m.nim,
                 pr.nama_prodi,
                 l.judul_lowongan,
                 u.foto
          FROM pengajuan p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN prodi pr ON m.id_prodi = pr.id_prodi
          JOIN users u ON m.id_user = u.id_user
          LEFT JOIN lowongan l ON p.id_lowongan = l.id_lowongan
          WHERE p.id_perusahaan = '$id_perusahaan' 
          ORDER BY p.create_at DESC";

$result = mysqli_query($conn, $query);
?>

<div class="main-content">
    <div class="content-header">
        <h2>Seleksi Pelamar Magang</h2>
        <p>Daftar mahasiswa yang melamar ke lowongan Anda.</p>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div style="margin-bottom: 20px; padding: 15px; border-radius: 8px; 
            <?= strpos($_GET['msg'], 'berhasil') !== false ? 'background:#d4edda; color:#155724;' : 'background:#f8d7da; color:#721c24;'; ?>">
            <?= htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-card" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                        <th style="padding: 15px; text-align: left;">Mahasiswa</th>
                        <th style="padding: 15px; text-align: left;">Posisi Dilamar</th>
                        <th style="padding: 15px; text-align: left;">Tanggal Pengajuan</th>
                        <th style="padding: 15px; text-align: center;">Status</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 15px;">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $row['foto'] ?? 'default.png'; ?>" 
                                             style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;"
                                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($row['nama_lengkap']); ?>'">
                                        <div>
                                            <div style="font-weight: bold;"><?= htmlspecialchars($row['nama_lengkap']); ?></div>
                                            <div style="font-size: 12px; color: #666;"><?= htmlspecialchars($row['nama_prodi']); ?></div>
                                            <div style="font-size: 11px; color: #888;">NIM: <?= htmlspecialchars($row['nim']); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <td style="padding: 15px;">
                                    <strong><?= htmlspecialchars($row['judul_lowongan'] ?? 'Pengajuan Mandiri'); ?></strong>
                                </td>

                                <td style="padding: 15px; color: #666;">
                                    <?= date('d M Y', strtotime($row['create_at'])); ?>
                                </td>

                                <td style="padding: 15px; text-align: center;">
                                    <?php
                                    $status = $row['status'];
                                    $badgeColor = '#ffc107'; 
                                    $statusText = 'Menunggu';

                                    if ($status == 'diterima') {
                                        $badgeColor = '#28a745'; 
                                        $statusText = 'Diterima';
                                    } elseif ($status == 'ditolak' || $status == 'verifikasi_ditolak') {
                                        $badgeColor = '#dc3545'; 
                                        $statusText = 'Ditolak';
                                    } elseif ($status == 'menunggu_verifikasi') {
                                        $badgeColor = '#17a2b8';
                                        $statusText = 'Verifikasi';
                                    }
                                    ?>
                                    <span style="background: <?= $badgeColor; ?>; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                        <?= $statusText; ?>
                                    </span>
                                </td>

                                <td style="padding: 15px; text-align: center;">
    <td style="padding: 15px; text-align: center;">
    <?php 
    // Kita buat agar tombol muncul jika statusnya 'menunggu_verifikasi' ATAU masih kosong
    if ($status == 'menunggu_verifikasi' || empty($status) || $status == 'menunggu'): 
    ?>
        <div style="display: flex; gap: 5px; justify-content: center;">
            <a href="proses_seleksi.php?id=<?= $row['id_pengajuan']; ?>&aksi=terima" 
               onclick="return confirm('Terima mahasiswa ini?')"
               style="background: #28a745; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                <i class="fas fa-check"></i> Terima
            </a>
            
            <a href="proses_seleksi.php?id=<?= $row['id_pengajuan']; ?>&aksi=tolak" 
               onclick="return confirm('Tolak pengajuan ini?')"
               style="background: #dc3545; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px;">
                <i class="fas fa-times"></i> Tolak
            </a>
        </div>
    <?php else: ?>
        <span style="color: #666; font-size: 12px;">
            <i class="fas fa-info-circle"></i> Selesai (<?= ucfirst($status); ?>)
        </span>
    <?php endif; ?>
</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="padding: 40px; text-align: center; color: #888;">
                                <i class="fas fa-inbox" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                Belum ada pelamar masuk.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
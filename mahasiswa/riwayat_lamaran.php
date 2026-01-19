<?php
require_once '../templates/header_mahasiswa.php';

// Ambil ID Mahasiswa
$id_user = $_SESSION['user_id'];
$q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
$d_mhs = mysqli_fetch_assoc($q_mhs);
$id_mahasiswa = $d_mhs['id_mahasiswa'];

// QUERY BENAR (Membaca tabel 'pengajuan' sesuai database Anda)
$query = "SELECT p.*, l.judul_lowongan, pr.foto 
          FROM pengajuan p
          LEFT JOIN lowongan l ON p.id_lowongan = l.id_lowongan
          LEFT JOIN perusahaan pr ON p.id_perusahaan = pr.id_perusahaan
          WHERE p.id_mahasiswa = '$id_mahasiswa'
          ORDER BY p.create_at DESC";

$result = mysqli_query($conn, $query);
?>

<div class="main-content">
    <div style="margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 15px;">
        <h2 style="color: #2E8B47; margin: 0;">Riwayat Pengajuan</h2>
        <p style="color: #666; margin-top: 5px;">Status pengajuan magang Anda.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 15px;">
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                
                <?php 
                    // Logika Status Badge & Warna
                    $status_db = $row['status'];
                    $status_label = 'Menunggu';
                    $bg_color = '#fff3cd'; // Kuning
                    $text_color = '#856404';

                    if ($status_db == 'diterima') {
                        $status_label = 'Diterima';
                        $bg_color = '#d4edda'; // Hijau
                        $text_color = '#155724';
                    } elseif ($status_db == 'ditolak' || $status_db == 'verifikasi_ditolak') {
                        $status_label = 'Ditolak';
                        $bg_color = '#f8d7da'; // Merah
                        $text_color = '#721c24';
                    } elseif ($status_db == 'menunggu_verifikasi') {
                        $status_label = 'Menunggu Verifikasi';
                    }

                    // Handle Judul Lowongan (Jika null berarti magang mandiri)
                    $judul = $row['judul_lowongan'] ?? 'Pengajuan Mandiri';
                    $nama_pt = $row['nama_perusahaan'];
                ?>

                <div style="display: flex; align-items: center; justify-content: space-between; background: white; padding: 20px; border-radius: 10px; border: 1px solid #eee; box-shadow: 0 2px 5px rgba(0,0,0,0.03);">
                    
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <img src="<?= $base_url; ?>img/profile_perusahaan/<?= $row['foto'] ?? 'default.png'; ?>" 
                             style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid #eee;"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($nama_pt); ?>'">
                        
                        <div>
                            <h4 style="margin: 0; color: #333; font-size: 16px;"><?= htmlspecialchars($judul); ?></h4>
                            <div style="color: #666; font-size: 14px; margin-top: 3px;">
                                <i class="fas fa-building"></i> <?= htmlspecialchars($nama_pt); ?>
                            </div>
                            <small style="color: #999; font-size: 12px;">
                                <i class="far fa-clock"></i> <?= date('d M Y', strtotime($row['create_at'])); ?>
                            </small>
                        </div>
                    </div>

                    <div>
                        <span style="background: <?= $bg_color; ?>; color: <?= $text_color; ?>; padding: 8px 15px; border-radius: 30px; font-weight: bold; font-size: 12px; display: inline-flex; align-items: center; gap: 5px;">
                            <i class="fas fa-info-circle"></i> <?= ucfirst($status_label); ?>
                        </span>
                    </div>

                </div>

            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; color: #999;">
                <h3>Belum ada riwayat pengajuan.</h3>
            </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
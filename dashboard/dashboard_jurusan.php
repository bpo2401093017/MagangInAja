<?php
require_once '../templates/header_jurusan.php';


// --- LOGIKA QUERY DATA ---

// 1. Ambil ID Jurusan dari Admin yang sedang login
$id_user_admin = $_SESSION['user_id'];
$query_info_jurusan = mysqli_query($conn, "SELECT id_jurusan FROM jurusan WHERE id_user = '$id_user_admin'");
$data_jurusan = mysqli_fetch_assoc($query_info_jurusan);
$id_jurusan_session = $data_jurusan['id_jurusan'];

// 2. Query Tabel 1: Mahasiswa PENDING (Belum Verifikasi)
// Filter berdasarkan id_jurusan admin & status users = 'Pending'
$q_pending = "SELECT m.*, u.status, p.nama_prodi 
              FROM mahasiswa m
              JOIN users u ON m.id_user = u.id_user
              JOIN prodi p ON m.id_prodi = p.id_prodi
              WHERE p.id_jurusan = '$id_jurusan_session' 
              AND u.status = 'Pending'
              ORDER BY m.create_at ASC"; // Yang lama daftar muncul duluan
$res_pending = mysqli_query($conn, $q_pending);

// 3. Query Tabel 2: Mahasiswa AKTIF (Sudah Verifikasi)
// Filter berdasarkan id_jurusan admin & status users = 'Aktif'
$q_aktif = "SELECT m.*, u.status, p.nama_prodi 
            FROM mahasiswa m
            JOIN users u ON m.id_user = u.id_user
            JOIN prodi p ON m.id_prodi = p.id_prodi
            WHERE p.id_jurusan = '$id_jurusan_session' 
            AND u.status = 'Aktif'
            ORDER BY m.nama_lengkap ASC";
$res_aktif = mysqli_query($conn, $q_aktif);

// Hitung jumlah untuk statistik ringkas (Opsional, biar dashboard cantik)
$total_pending = mysqli_num_rows($res_pending);
$total_aktif = mysqli_num_rows($res_aktif);
?>

<div class="main-content">
    
    <div class="welcome-banner" style="margin-bottom: 30px;">
        <h2>Selamat Datang, Admin Jurusan!</h2>
        <p>Anda memiliki <strong style="color: #c62828;"><?= $total_pending; ?> mahasiswa baru</strong> yang menunggu verifikasi.</p>
    </div>

    <div class="dashboard-section">
        <div class="section-header danger-header">
            <h3><i class="fas fa-user-clock"></i> Pendaftar Baru (Perlu Verifikasi)</h3>
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
                        // Reset pointer query karena tadi dipakai ngitung row
                        mysqli_data_seek($res_pending, 0); 
                        while($row = mysqli_fetch_assoc($res_pending)): 
                        ?>
                        <tr class="row-pending">
                            <td><?= date('d/m/Y', strtotime($row['create_at'])); ?></td>
                            <td><span class="nim-badge"><?= $row['nim']; ?></span></td>
                            <td><strong><?= $row['nama_lengkap']; ?></strong></td>
                            <td><?= $row['nama_prodi']; ?></td>
                            <td>
                                <i class="fas fa-phone"></i> <?= $row['no_hp']; ?>
                            </td>
                            <td class="text-center">
                                <a href="../jurusan/proses_verifikasi.php?id=<?= $row['id_user']; ?>" 
                                   class="btn-action btn-verify"
                                   onclick="return confirm('Apakah data mahasiswa ini (<?= $row['nama_lengkap']; ?>) VALID?')">
                                    <i class="fas fa-check"></i> Verifikasi
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
            <h3><i class="fas fa-users"></i> Data Mahasiswa Aktif</h3>
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
                        <th class="text-center">Kontrol Akun</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($total_aktif > 0): ?>
                        <?php 
                        mysqli_data_seek($res_aktif, 0);
                        while($row = mysqli_fetch_assoc($res_aktif)): 
                        ?>
                        <tr>
                            <td><?= $row['nim']; ?></td>
                            <td>
                                <strong><?= $row['nama_lengkap']; ?></strong>
                                <i class="fas fa-check-circle verified-icon" title="Terverifikasi"></i>
                            </td>
                            <td><?= $row['nama_prodi']; ?></td>
                            <td><?= $row['email'] ?? '-'; ?></td>
                            <td class="text-center">
                                <a href="../jurusan/form_reset_password.php?id=<?= $row['id_user']; ?>&nama=<?= urlencode($row['nama_lengkap']); ?>" 
                                   class="btn-action btn-reset">
                                    <i class="fas fa-key"></i> Reset Pass
                                </a>
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

<style>
    /* Styling Container */
    .dashboard-section {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 30px;
    }

    /* Header Section */
    .section-header { padding: 20px; color: white; }
    .section-header h3 { margin: 0; font-size: 18px; display: flex; align-items: center; gap: 10px; }
    .section-header p { margin: 5px 0 0; font-size: 13px; opacity: 0.9; }
    
    .danger-header { background: linear-gradient(to right, #e53935, #ef5350); } /* Merah untuk Pending */
    .success-header { background: linear-gradient(to right, #2E8B47, #43a047); } /* Hijau untuk Aktif */

    /* Table Styling */
    .table-custom { width: 100%; border-collapse: collapse; }
    .table-custom th { background: #f9f9f9; color: #555; font-weight: 600; padding: 15px; text-align: left; border-bottom: 2px solid #eee; }
    .table-custom td { padding: 15px; border-bottom: 1px solid #eee; color: #444; vertical-align: middle; }
    
    /* Rows Highlight */
    .row-pending { background-color: #fff8f8; } /* Highlight merah tipis */
    .row-pending:hover { background-color: #ffebee; }

    /* Badges & Icons */
    .nim-badge { background: #eee; padding: 4px 8px; border-radius: 4px; font-family: monospace; font-weight: bold; font-size: 13px; }
    .verified-icon { color: #2E8B47; font-size: 12px; margin-left: 5px; }

    /* Buttons */
    .btn-action { padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold; display: inline-block; transition: 0.2s; }
    
    .btn-verify { background: #2E8B47; color: white; border: 1px solid #2E8B47; }
    .btn-verify:hover { background: #236c36; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(46,139,71,0.2); }
    
    .btn-reset { background: #fff; color: #f57c00; border: 1px solid #f57c00; }
    .btn-reset:hover { background: #f57c00; color: white; }

    .empty-data { text-align: center; padding: 30px; font-style: italic; color: #999; }
    .text-center { text-align: center; }
</style>

</body>
</html>
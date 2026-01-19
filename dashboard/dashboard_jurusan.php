<?php
require_once '../templates/header_jurusan.php';

// 1. Ambil ID User yang sedang login
$id_user_admin = $_SESSION['user_id'];

// 2. Cek apakah data jurusan ada?
$query_info_jurusan = mysqli_query($conn, "SELECT id_jurusan FROM jurusan WHERE id_user = '$id_user_admin'");
$data_jurusan = mysqli_fetch_assoc($query_info_jurusan);

// --- FITUR SELF-HEALING (PERBAIKAN OTOMATIS) ---
if (!$data_jurusan) {
    // Jika tombol perbaiki diklik
    if (isset($_POST['fix_account'])) {
        $username_fix = $_SESSION['username'];
        // Masukkan data default agar akun bisa jalan
        $query_fix = "INSERT INTO jurusan (id_user, nama_jurusan, kode) VALUES ('$id_user_admin', 'Jurusan $username_fix', '-')";
        if (mysqli_query($conn, $query_fix)) {
            echo "<script>alert('Data berhasil diperbaiki! Selamat bekerja.'); window.location.href='dashboard_jurusan.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbaiki: " . mysqli_error($conn) . "');</script>";
        }
    }
?>
    <div class="main-content">
        <div style="background: #fff3cd; color: #856404; padding: 30px; border-radius: 10px; border: 1px solid #ffeeba; text-align: center; margin-top: 50px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 50px; margin-bottom: 20px;"></i>
            <h2>Data Akun Tidak Lengkap</h2>
            <p>Halo <b><?= $_SESSION['username']; ?></b>, akun Login Anda aktif, tetapi data profil Jurusan belum terhubung.</p>
            <p>Ini mungkin terjadi karena kesalahan saat registrasi sebelumnya.</p>
            
            <form method="POST" style="margin-top: 20px;">
                <button type="submit" name="fix_account" style="background: #2E8B47; color: white; padding: 12px 25px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 16px;">
                    <i class="fas fa-tools"></i> Perbaiki Data Saya Sekarang
                </button>
            </form>
        </div>
    </div>
<?php
    // Stop script di sini agar tidak lanjut load tabel error
    require_once '../templates/footer.php'; // Opsional jika ada footer
    exit; 
}
// --- AKHIR FITUR SELF-HEALING ---

$id_jurusan_session = $data_jurusan['id_jurusan'];

// 3. Query Tabel 1: Pendaftar PENDING
$q_pending = "SELECT m.*, u.status, p.nama_prodi, u.id_user as uid 
              FROM mahasiswa m
              JOIN users u ON m.id_user = u.id_user
              JOIN prodi p ON m.id_prodi = p.id_prodi
              WHERE p.id_jurusan = '$id_jurusan_session' 
              AND u.status = 'Pending'
              ORDER BY m.create_at ASC"; 
$res_pending = mysqli_query($conn, $q_pending);

// 4. Query Tabel 2: Mahasiswa AKTIF
$q_aktif = "SELECT m.*, u.status, p.nama_prodi, u.email
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

<style>
    .dashboard-card { background: white; border-radius: 10px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .card-header-title { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
    .card-header-title h3 { margin: 0; color: #333; font-size: 18px; }
    .table-responsive { overflow-x: auto; }
    .table-custom { width: 100%; border-collapse: collapse; min-width: 600px; }
    .table-custom th { background: #f8f9fa; color: #555; font-weight: 600; padding: 12px 15px; text-align: left; border-bottom: 2px solid #ddd; }
    .table-custom td { padding: 12px 15px; border-bottom: 1px solid #eee; color: #444; vertical-align: middle; }
    .btn-action { padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; font-weight: bold; display: inline-block; margin-right: 5px; cursor: pointer; border: none; }
    .btn-accept { background: #2E8B47; color: white; }
    .btn-reject { background: #c62828; color: white; }
    .badge-status { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: bold; background: #e8f5e9; color: #2E8B47; }
</style>

<div class="main-content">
    
    <div style="margin-bottom: 30px;">
        <h2 style="color: #2E8B47; margin: 0;">Dashboard Jurusan</h2>
        <p style="color: #666;">Selamat datang kembali! Berikut ringkasan data mahasiswa Anda.</p>
    </div>

    <?php if(isset($_GET['pesan'])): ?>
        <div style="padding: 15px; border-radius: 8px; margin-bottom: 20px; 
            <?= ($_GET['pesan'] == 'sukses_verifikasi') ? 'background:#d4edda; color:#155724;' : 'background:#f8d7da; color:#721c24;'; ?>">
            <?= ($_GET['pesan'] == 'sukses_verifikasi') ? 'Berhasil memverifikasi mahasiswa!' : 'Aksi selesai.'; ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-card">
        <div class="card-header-title">
            <h3 style="color: #c62828;"><i class="fas fa-user-clock"></i> Pendaftar Baru (Perlu Verifikasi)</h3>
            <span style="background: #ffebee; color: #c62828; padding: 5px 10px; border-radius: 10px; font-weight: bold; font-size: 12px;">
                <?= $total_pending; ?> Menunggu
            </span>
        </div>
        
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Prodi</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($total_pending > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($res_pending)): ?>
                        <tr style="background: #fffafa;">
                            <td><strong><?= htmlspecialchars($row['nim']); ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($row['nama_prodi']); ?></td>
                            <td><?= htmlspecialchars($row['no_hp']); ?></td>
                            <td>
                                <a href="../jurusan/proses_verifikasi.php?id=<?= $row['uid']; ?>" 
                                   class="btn-action btn-accept"
                                   onclick="return confirm('Verifikasi mahasiswa ini?')">
                                    <i class="fas fa-check"></i> Terima
                                </a>
                                <a href="../jurusan/proses_tolak.php?id=<?= $row['uid']; ?>" 
                                   class="btn-action btn-reject"
                                   onclick="return confirm('Tolak pendaftaran ini?')">
                                    <i class="fas fa-times"></i> Tolak
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 20px;">Tidak ada pendaftar baru.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header-title">
            <h3 style="color: #2E8B47;"><i class="fas fa-users"></i> Data Mahasiswa Aktif</h3>
            <span style="background: #e8f5e9; color: #2E8B47; padding: 5px 10px; border-radius: 10px; font-weight: bold; font-size: 12px;">
                <?= $total_aktif; ?> Aktif
            </span>
        </div>

        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Prodi</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($total_aktif > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($res_aktif)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nim']); ?></td>
                            <td><strong><?= htmlspecialchars($row['nama_lengkap']); ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_prodi']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><span class="badge-status">Verified <i class="fas fa-check-circle"></i></span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888; padding: 20px;">Belum ada mahasiswa aktif.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>
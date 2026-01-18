<?php
require_once '../../templates/header_mahasiswa.php';

$id_user = $_SESSION['user_id'] ?? null;
if (!$id_user) {
    die("Akses tidak valid");
}

/* DATA UTAMA */
$query = "SELECT 
    u.username, u.email, u.no_hp, u.foto,
    j.nama_jurusan, p.nama_prodi, m.nim,
    m.nama_lengkap, m.tanggal_lahir, m.jenis_kelamin,
    m.alamat, m.angkatan, m.kelas
FROM users u
LEFT JOIN mahasiswa m ON m.id_user = u.id_user
LEFT JOIN jurusan j ON m.id_jurusan = j.id_jurusan
LEFT JOIN prodi p ON m.id_prodi = p.id_prodi
WHERE u.id_user = ?";



$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    die("Data mahasiswa tidak ditemukan");
}

/* DATA BERKAS */
$sqlBerkas = "
SELECT jenis_berkas, nama_file
FROM mahasiswa_berkas
WHERE id_user = ?
";
$stmtBerkas = mysqli_prepare($conn, $sqlBerkas);
mysqli_stmt_bind_param($stmtBerkas, "i", $id_user);
mysqli_stmt_execute($stmtBerkas);
$resultBerkas = mysqli_stmt_get_result($stmtBerkas);

$berkas = [];
while ($row = mysqli_fetch_assoc($resultBerkas)) {
    $berkas[$row['jenis_berkas']] = $row['nama_file'];
}
?>


<link rel="stylesheet" href="../../css/data_mahasiswa.css">

<div class="main-content">

    <div class="page-header">
        <h1>Data Mahasiswa</h1>
        <p>Informasi akun, profil, dan berkas mahasiswa</p>
    </div>

    <!-- GRID UTAMA -->
    <div class="grid-2">

        <!-- KATEGORI UMUM -->
        <div class="card">
            <h2>Kategori Umum</h2>

            <div class="photo-section">
                <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $data['foto'] ?? 'default.png'; ?>"
                     class="mini-avatar"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($data['username']); ?>&background=fff&color=2E8B47'">
            </div>

            <div class="info-list">
                <p><span>Username</span><?= $data['username']; ?></p>
                <p><span>NIM</span><?= $data['nim']; ?></p>
                <p><span>Email</span><?= $data['email']; ?></p>
                <p><span>No HP</span><?= $data['no_hp']; ?></p>
                <p><span>Jurusan</span><?= $data['nama_jurusan']; ?></p>
                <p><span>Program Studi</span><?= $data['nama_prodi']; ?></p>
            </div>
        </div>

        <!-- PROFIL MAHASISWA -->
        <div class="card">
            <h2>Profil Mahasiswa</h2>

            <div class="info-list">
                <p><span>Nama Lengkap</span><?= $data['nama_lengkap'] ?? '-'; ?></p>
                <p><span>Tanggal Lahir</span><?= $data['tanggal_lahir'] ?? '-'; ?></p>
                <p><span>Jenis Kelamin</span><?= $data['jenis_kelamin'] ?? '-'; ?></p>
                <p><span>Alamat</span><?= $data['alamat'] ?? '-'; ?></p>
                <p><span>Angkatan</span><?= $data['angkatan'] ?? '-'; ?></p>
                <p><span>Kelas</span><?= $data['kelas'] ?? '-'; ?></p>
            </div>
        </div>

    </div>

    <!-- BERKAS -->
    <div class="card">
        <h2>Berkas Mahasiswa</h2>

        <div class="berkas-grid">
            <div class="berkas-item">
                <span>Curriculum Vitae (CV)</span>
                <?php if (!empty($berkas['cv'])): ?>
                    <a href="<?= $base_url; ?>uploads/berkas/<?= $berkas['cv']; ?>" target="_blank">
                        Lihat Berkas
                    </a>
                <?php else: ?>
                    <em>Belum diunggah</em>
                <?php endif; ?>
            </div>

            <div class="berkas-item">
                <span>Proposal</span>
                <?php if (!empty($berkas['proposal'])): ?>
                    <a href="<?= $base_url; ?>uploads/berkas/<?= $berkas['proposal']; ?>" target="_blank">
                        Lihat Berkas
                    </a>
                <?php else: ?>
                    <em>Belum diunggah</em>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="form-action">
        <a href="form_data_mahasiswa.php" class="btn-primary">
            Edit Data
        </a>
    </div>

</div>

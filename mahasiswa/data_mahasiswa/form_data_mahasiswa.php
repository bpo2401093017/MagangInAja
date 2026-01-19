<?php

require_once '../../templates/header_mahasiswa.php';

// mengambil ID User dari session
$id_user = $_SESSION['user_id'] ?? null;

if (!$id_user) {
    header("Location: ../../auth/login.php");
    exit();
}


$query = "
SELECT 
    u.username, u.email, u.no_hp, u.foto,
    j.nama_jurusan,
    m.nim, m.nama_lengkap, 
    m.tanggal_lahir, m.jenis_kelamin, m.alamat, m.angkatan, m.kelas
FROM users u
LEFT JOIN mahasiswa m ON m.id_user = u.id_user
LEFT JOIN jurusan j ON m.id_jurusan = j.id_jurusan -- Tambahkan JOIN ini
WHERE u.id_user = ?
";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    
    if (!$data) {
        die("Data profil mahasiswa belum lengkap atau tidak ditemukan di database.");
    }
} else {
    die("Gagal menyiapkan query: " . mysqli_error($conn));
}
?>

<link rel="stylesheet" href="../../css/data_mahasiswa.css">

<form action="edit_data_mahasiswa.php" method="POST" enctype="multipart/form-data">
    <div class="main-content">
        <div class="page-header">
            <h1>Data Mahasiswa</h1>
            <p>Kelola informasi akun dan profil pribadi Anda</p>
        </div>

        <div class="card">
            <h2>Kategori Umum</h2>
            <div class="photo-section">
                <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $data['foto'] ?? 'default.png'; ?>"
                     class="mini-avatar" alt="User">
                <div>
                    <input type="file" name="foto">
                    <small>Foto profil dapat diganti</small>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" value="<?= htmlspecialchars($data['username']); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" value="<?= htmlspecialchars($data['nim'] ?? '-'); ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>">
                </div>
                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>">
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Profil Saya</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_lengkap'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir']; ?>">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin">
                        <option value="Laki-laki" <?= (strtolower($data['jenis_kelamin'] ?? '') == "laki-laki") ? "selected" : ""; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= (strtolower($data['jenis_kelamin'] ?? '') == "perempuan") ? "selected" : ""; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Angkatan</label>
                    <input type="number" name="angkatan" value="<?= $data['angkatan']; ?>">
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas'] ?? ''); ?>">
                </div>
            </div>
        </div>

        <div class="card">
            <h2>Berkas Mahasiswa</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>CV (PDF)</label>
                    <input type="file" name="cv" accept=".pdf">
                </div>
                <div class="form-group">
                    <label>Proposal (PDF)</label>
                    <input type="file" name="proposal" accept=".pdf">
                </div>
            </div>
        </div>

        <div class="form-action">
            <button class="btn-primary" type="submit" name="simpan">Simpan Perubahan</button>
        </div>
    </div>
</form>
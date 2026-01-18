<?php

require_once '../../templates/header_mahasiswa.php';

$id_user = $_SESSION['user_id'] ?? null;



$query = "
SELECT 
    u.username,
    u.email,
    u.no_hp,
    u.foto,
    u.nama_jurusan,
    u.nama_prodi,
    u.nim,

    m.nama_lengkap,
    m.tanggal_lahir,
    m.jenis_kelamin,
    m.alamat,
    m.angkatan,
    m.kelas
FROM users u
LEFT JOIN mahasiswa m ON m.id_user = u.id_user
WHERE u.id_user = ?
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data mahasiswa tidak ditemukan");
}
?>
?>
<header>
     <link rel="stylesheet" href="../../css/data_mahasiswa.css">
</header>
<div class="main-content">
        
    <div class="page-header">
        <h1>Data Mahasiswa</h1>
        <p>Kelola informasi akun dan profil pribadi Anda</p>
    </div>

    <!-- KATEGORI UMUM -->
    <div class="card">
        <h2>Kategori Umum</h2>

        <div class="photo-section">
            <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $_SESSION['foto'] ?? 'default.png'; ?>" 
                     class="mini-avatar" 
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'"
                     alt="User">
            <div>
                <input type="file">
                <small>Foto profil dapat diganti</small>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Username</label>
                <input type="text" value="<?= $data['username']; ?>" disabled>
            </div>

            <div class="form-group">
                <label>NIM</label>
                <input type="text" value="<?= $data['nim']; ?>" disabled>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?= $data['email']; ?>">
            </div>

            <div class="form-group">
                <label>No HP</label>
                <input type="text" value="<?= $data['no_hp']; ?>">
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" value="<?= $data['nama_jurusan']; ?>" disabled>
            </div>

            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" value="<?= $data['nama_prodi']; ?>" disabled>
            </div>
        </div>
    </div>

    <!-- PROFIL MAHASISWA -->
    <div class="card">
        <h2>Profil Saya</h2>

        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" value="<?= $data['nama_lengkap']; ?>">
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" value="<?= $data['tanggal_lahir']; ?>">
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select>
                    <option value="">Pilih...</option>
                    <option <?= $data['jenis_kelamin']=="Laki-laki"?"selected":""; ?>>Laki-laki</option>
                    <option <?= $data['jenis_kelamin']=="Perempuan"?"selected":""; ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Alamat Rumah</label>
                <textarea><?= $data['alamat']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Angkatan</label>
                <input type="number" value="<?= $data['angkatan']; ?>">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" value="<?= $data['kelas']; ?>">
            </div>
        </div>
    </div>

    <div class="form-action">
        <button class="btn-primary">Simpan Perubahan</button>
    </div>

</div>

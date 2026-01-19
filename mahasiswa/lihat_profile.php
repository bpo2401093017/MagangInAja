<?php
require_once '../config.php';
include_once '../auth/auth_mahasiswa.php';

$id_user = $_SESSION['user_id'];

// 2. Gunakan query yang kolomnya sesuai dengan tabel di database Anda
$query = "SELECT u.username, u.email, u.no_hp, m.nim, u.foto, j.nama_jurusan, p.nama_prodi FROM users u JOIN mahasiswa m ON u.id_user = m.id_user JOIN jurusan j ON m.id_jurusan = j.id_jurusan JOIN prodi p ON m.id_prodi = p.id_prodi WHERE u.id_user = '$id_user'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);


// 3. Tambahkan proteksi jika data tidak ditemukan agar tidak error null
if (!$data) {
    die("Error: Data pengguna tidak ditemukan di database.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SIPADEKPNP</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/profile.css">
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <h2>Profil Mahasiswa</h2>
        <p>Kategori Umum Akun</p>
    </div>

    <form action="proses_edit_profile.php" method="POST" enctype="multipart/form-data">
        
        <div class="avatar-wrapper">
    <img src="<?= $data['foto'] ? $base_url . 'img/profile_mahasiswa/' . $data['foto'] : 'https://ui-avatars.com/api/?name=Mahasiswa&background=fff&color=2E8B47'; ?>" 
         alt="Avatar" 
         class="avatar" 
         id="img-preview">
    
    <input type="file" name="foto" id="foto-input" accept="image/*" style="font-size: 12px; color: #888;">
</div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" value="<?= $data['username']; ?>" class="readonly" readonly>
        </div>

        <div class="form-group">
            <label>NIM</label>
            <input type="text" value="<?= $data['nim']; ?>" class="readonly" readonly>
        </div>

        <div class="form-group">
            <label>Alamat Email</label>
            <input type="email" name="email" value="<?= $data['email']; ?>" required>
        </div>

        <div class="form-group">
            <label>Nomor WhatsApp</label>
            <input type="text" name="no_hp" value="<?= $data['no_hp']; ?>" required>
        </div>

        <div class="form-group">
            <label>Jurusan</label>
            <input type="text" value="<?= $data['nama_jurusan']; ?>" class="readonly" readonly>
        </div>

        <div class="form-group">
            <label>Program Studi</label>
            <input type="text" value="<?= $data['nama_prodi']; ?>" class="readonly" readonly>
        </div>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
        <a href="<?= $base_url; ?>dashboard/dashboard_mahasiswa.php" class="btn-back">Kembali ke Dashboard</a>
    </form>
</div>
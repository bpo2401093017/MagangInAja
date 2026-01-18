<?php
require_once '../config.php';
include_once '../auth/auth_jurusan.php';

$id_user = $_SESSION['user_id'];

// 2. Gunakan query yang kolomnya sesuai dengan tabel di database Anda
$query = "SELECT username, email, no_hp, nama_jurusan, foto FROM users WHERE id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

$Jquery = "SELECT nama_jurusan FROM jurusan WHERE id_user = '$id_user'";
$Jresult = mysqli_query($conn, $Jquery);
$Jdata = mysqli_fetch_assoc($Jresult);

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
            <input type="text" name="username" value="<?= $data['username']; ?>" required>
        </div>

      <div class="form-group">
            <label>Jurusan</label>
            <input type="text" name="nama_jurusan" value="<?= $Jdata['nama_jurusan']; ?>" required>
        </div>

        <div class="form-group">
            <label>Alamat Email</label>
            <input type="email" name="email" value="<?= $data['email']; ?>" required>
        </div>

        <div class="form-group">
            <label>Nomor WhatsApp</label>
            <input type="text" name="no_hp" value="<?= $data['no_hp']; ?>" required>
        </div>       
       

        <button type="submit" class="btn-save">Simpan Perubahan</button>
        <a href="<?= $base_url; ?>dashboard/dashboard_jurusan.php" class="btn-back">Kembali ke Dashboard</a>
    </form>
</div>
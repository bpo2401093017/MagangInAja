<?php
require_once '../config.php';
include_once '../auth/auth_mahasiswa.php';

$id_user = $_SESSION['user_id'];

// 1. AMBIL DATA MAHASISWA
$query = "SELECT 
            u.username, u.foto, u.email as email_login,
            m.*
          FROM users u 
          LEFT JOIN mahasiswa m ON u.id_user = m.id_user 
          WHERE u.id_user = '$id_user'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Default value
$nim            = $data['nim'] ?? '';
$nama_lengkap   = $data['nama_lengkap'] ?? '';
$tgl_lahir      = $data['tanggal_lahir'] ?? '';
$jenis_kelamin  = $data['jenis_kelamin'] ?? '';
$alamat         = $data['alamat'] ?? '';
$angkatan       = $data['angkatan'] ?? '';
$kelas          = $data['kelas'] ?? '';
$email          = !empty($data['email']) ? $data['email'] : $data['email_login'];
$no_hp          = $data['no_hp'] ?? '';
$id_jurusan_mhs = $data['id_jurusan'] ?? 0;
$id_prodi_mhs   = $data['id_prodi'] ?? 0;

// 2. AMBIL DATA JURUSAN & PRODI UNTUK DROPDOWN
$q_jurusan = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
$q_prodi   = mysqli_query($conn, "SELECT * FROM prodi ORDER BY nama_prodi ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata Lengkap</title>
    <link rel="stylesheet" href="../css/profile.css">
    <style>
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full-width { grid-column: span 2; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .full-width { grid-column: span 1; } }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="profile-header">
        <h2>Biodata Mahasiswa</h2>
        <p>Lengkapi data diri Anda dengan benar.</p>
    </div>

    <form action="proses_edit_profile.php" method="POST" enctype="multipart/form-data">
        
        <div class="avatar-wrapper" style="text-align: center; margin-bottom: 25px;">
            <?php 
                $fotoUrl = !empty($data['foto']) ? "../img/profile_mahasiswa/" . $data['foto'] : "https://ui-avatars.com/api/?name=".urlencode($data['username']);
            ?>
            <img src="<?= $fotoUrl; ?>" id="img-preview" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #eee;">
            <br>
            <label for="foto-input" style="cursor: pointer; color: #2E8B47; font-size: 13px; font-weight: bold;">
                <i class="fas fa-camera"></i> Ganti Foto
            </label>
            <input type="file" name="foto" id="foto-input" accept="image/*" style="display: none;">
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Username</label>
                <input type="text" value="<?= $data['username']; ?>" readonly style="background: #f0f0f0;">
            </div>

            <div class="form-group">
                <label>NIM</label>
                <input type="text" name="nim" value="<?= $nim; ?>" placeholder="Contoh: 2201092001" required>
            </div>

            <div class="form-group full-width">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= $nama_lengkap; ?>" placeholder="Nama sesuai KTM" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= $email; ?>" required>
            </div>

            <div class="form-group">
                <label>No. WhatsApp</label>
                <input type="text" name="no_hp" value="<?= $no_hp; ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= $tgl_lahir; ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" <?= ($jenis_kelamin == 'Laki-laki' || $jenis_kelamin == 'laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($jenis_kelamin == 'Perempuan' || $jenis_kelamin == 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <select name="id_jurusan" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <?php while($j = mysqli_fetch_assoc($q_jurusan)): ?>
                        <option value="<?= $j['id_jurusan']; ?>" <?= ($id_jurusan_mhs == $j['id_jurusan']) ? 'selected' : ''; ?>>
                            <?= $j['nama_jurusan']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Program Studi</label>
                <select name="id_prodi" required>
                    <option value="">-- Pilih Prodi --</option>
                    <?php while($p = mysqli_fetch_assoc($q_prodi)): ?>
                        <option value="<?= $p['id_prodi']; ?>" <?= ($id_prodi_mhs == $p['id_prodi']) ? 'selected' : ''; ?>>
                            <?= $p['nama_prodi']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Angkatan</label>
                <input type="number" name="angkatan" value="<?= $angkatan; ?>" placeholder="Tahun Masuk (2022)" required>
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" value="<?= $kelas; ?>" placeholder="Contoh: 2A">
            </div>

            <div class="form-group full-width">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="3" placeholder="Alamat domisili saat ini..."><?= $alamat; ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn-save" style="margin-top: 25px; width: 100%; padding: 12px; background: #2E8B47; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
            SIMPAN PERUBAHAN
        </button>

        <div style="margin-top: 15px; text-align: center;">
            <a href="../dashboard/dashboard_mahasiswa.php" style="text-decoration: none; color: #666;">Kembali ke Dashboard</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('foto-input').onchange = function (evt) {
        var tgt = evt.target || window.event.srcElement, files = tgt.files;
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () { document.getElementById('img-preview').src = fr.result; }
            fr.readAsDataURL(files[0]);
        }
    }
</script>

</body>
</html>
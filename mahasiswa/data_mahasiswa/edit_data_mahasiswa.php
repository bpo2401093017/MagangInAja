<?php
require_once '../../auth/auth_mahasiswa.php';
require_once '../../templates/header_mahasiswa.php';

$id_user = $_SESSION['user_id'];
$query = "SELECT m.*, u.email, u.foto, j.nama_jurusan, p.nama_prodi 
          FROM mahasiswa m
          JOIN users u ON m.id_user = u.id_user
          LEFT JOIN jurusan j ON m.id_jurusan = j.id_jurusan
          LEFT JOIN prodi p ON m.id_prodi = p.id_prodi
          WHERE m.id_user = '$id_user'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/profil_mhs.css">

<div class="main-content">
    <div class="profile-container" style="max-width: 800px; margin: 0 auto;">
        <div class="profile-body">
            <h3 style="margin-top: 0; color: #2E8B47;">Edit Biodata</h3>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">

            <form action="proses_data.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_mahasiswa" value="<?= $data['id_mahasiswa']; ?>">
                
                <div style="margin-bottom: 20px; text-align: center;">
                    <label style="display: block; margin-bottom: 10px;">Foto Profil</label>
                    <img src="<?= $base_url; ?>img/profile_mahasiswa/<?= $data['foto'] ?? 'default.png'; ?>" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                    <input type="file" name="foto_profil" accept="image/*">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">NIM</label>
                        <input type="text" value="<?= htmlspecialchars($data['nim']); ?>" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #eee;" readonly>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">No. WhatsApp</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Alamat Domisili</label>
                    <textarea name="alamat" rows="3" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required><?= htmlspecialchars($data['alamat']); ?></textarea>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Angkatan</label>
                    <input type="number" name="angkatan" value="<?= htmlspecialchars($data['angkatan']); ?>" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
                </div>

                <button type="submit" name="update_profil" style="width: 100%; padding: 12px; background: #2E8B47; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Simpan Perubahan</button>
                <a href="data_mahasiswa.php" style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
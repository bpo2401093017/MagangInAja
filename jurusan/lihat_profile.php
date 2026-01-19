<?php
require_once '../templates/header_jurusan.php';

$id_user = $_SESSION['user_id'];

// Ambil data jurusan & user gabungan
$query = "SELECT j.*, u.username, u.email, u.no_hp, u.foto 
          FROM jurusan j 
          JOIN users u ON j.id_user = u.id_user 
          WHERE u.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<div class="main-content">
    <div class="dashboard-card" style="max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
            <div style="position: relative; display: inline-block;">
                <img src="<?= $base_url; ?>img/profile_jurusan/<?= $data['foto'] ?? 'default.png'; ?>" 
                     style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #2E8B47;"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= $_SESSION['username']; ?>&background=fff&color=2E8B47'">
            </div>
            <h2 style="margin: 15px 0 5px; color: #333;"><?= htmlspecialchars($data['nama_jurusan']); ?></h2>
            <p style="color: #666; margin: 0; font-size: 14px;">Administrator Jurusan</p>
        </div>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #c3e6cb; text-align: center;">
                <i class="fas fa-check-circle"></i> Profil berhasil diperbarui!
            </div>
        <?php endif; ?>

        <form action="proses_edit_profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_jurusan" value="<?= $data['id_jurusan']; ?>">

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">Username (Tidak dapat diubah)</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 15px; top: 13px; color: #888;"></i>
                    <input type="text" name="username" value="<?= htmlspecialchars($data['username']); ?>" 
                           readonly 
                           style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid #ddd; border-radius: 8px; background-color: #f2f2f2; color: #777; cursor: not-allowed; font-weight: bold; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Email Resmi</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" value="<?= htmlspecialchars($data['nama_jurusan']); ?>" required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">No. Telepon / WhatsApp</label>
                <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Ganti Foto Profil (Opsional)</label>
                <input type="file" name="foto_profil" accept="image/*"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; background: #fff; box-sizing: border-box;">
                <small style="color: #888; display: block; margin-top: 5px;">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
            </div>

            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <button type="submit" name="update" 
                        style="flex: 2; padding: 14px; background: #2E8B47; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; font-size: 16px;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="../dashboard/dashboard_jurusan.php" 
                   style="flex: 1; text-align: center; padding: 14px; background: #f8f9fa; color: #333; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
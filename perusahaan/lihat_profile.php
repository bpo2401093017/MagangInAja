<?php
require_once '../templates/header_perusahaan.php';

$id_user = $_SESSION['user_id'];

// Ambil data perusahaan join users
$query = "SELECT p.*, u.username, u.email, u.no_hp, u.foto 
          FROM perusahaan p 
          JOIN users u ON p.id_user = u.id_user 
          WHERE u.id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<div class="main-content">
    <div class="dashboard-card" style="max-width: 900px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
        
        <div style="text-align: center; margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 25px;">
            <div style="position: relative; display: inline-block;">
                <img src="<?= $base_url; ?>img/profile_perusahaan/<?= $data['foto'] ?? 'default.png'; ?>" 
                     style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #2E8B47;"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($data['nama_perusahaan']); ?>&background=fff&color=2E8B47'">
            </div>
            <h2 style="margin: 15px 0 5px; color: #333;"><?= htmlspecialchars($data['nama_perusahaan']); ?></h2>
            <p style="color: #666; margin: 0; font-size: 14px;">Mitra Perusahaan</p>
        </div>

        <?php if(isset($_GET['msg'])): ?>
            <?php if($_GET['msg'] == 'success'): ?>
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #c3e6cb; text-align: center;">
                    <i class="fas fa-check-circle"></i> Profil berhasil diperbarui!
                </div>
            <?php elseif($_GET['msg'] == 'error'): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid #f5c6cb; text-align: center;">
                    <i class="fas fa-exclamation-circle"></i> Gagal memperbarui profil.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="proses_edit_profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_perusahaan" value="<?= $data['id_perusahaan']; ?>">

            <h3 style="color: #2E8B47; font-size: 16px; margin-bottom: 15px; border-bottom: 2px solid #e8f5e9; padding-bottom: 5px;">Informasi Akun</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #555;">Username (Dikunci)</label>
                    <div style="position: relative;">
                        <i class="fas fa-lock" style="position: absolute; left: 15px; top: 13px; color: #888;"></i>
                        <input type="text" value="<?= htmlspecialchars($data['username']); ?>" 
                               readonly 
                               style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid #ddd; border-radius: 8px; background-color: #f2f2f2; color: #777; cursor: not-allowed; font-weight: bold; box-sizing: border-box;">
                    </div>
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Email Perusahaan</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
            </div>

            <h3 style="color: #2E8B47; font-size: 16px; margin-bottom: 15px; border-bottom: 2px solid #e8f5e9; padding-bottom: 5px; margin-top: 30px;">Detail Perusahaan</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Nama Perusahaan</label>
                    <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan']); ?>" required
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" required
                          style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: inherit;"><?= htmlspecialchars($data['alamat_perusahaan']); ?></textarea>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Update Logo Perusahaan</label>
                <input type="file" name="foto_profil" accept="image/*"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa; box-sizing: border-box;">
                <small style="color: #888; display: block; margin-top: 5px;">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" name="update" 
                        style="flex: 2; padding: 14px; background: #2E8B47; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; font-size: 16px;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="../dashboard/dashboard_perusahaan.php" 
                   style="flex: 1; text-align: center; padding: 14px; background: #f8f9fa; color: #333; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 16px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/admin.css">

<div class="main-content">
    <div class="dashboard-card" style="max-width: 800px; margin: 0 auto;">
        <div style="border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 30px; text-align: center;">
            <h2 style="margin: 0; color: #2E8B47;">Registrasi Jurusan Baru</h2>
            <p style="color: #666; margin-top: 5px;">Buat akun untuk Admin Jurusan</p>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'failed_user'): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    Gagal membuat User! Username atau Email mungkin sudah terdaftar.
                </div>
            <?php elseif ($_GET['status'] == 'failed_jurusan'): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    Gagal menyimpan Data Jurusan! Silakan coba lagi.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="proses_register_jurusan.php" method="POST">
            
            <h4 style="color: #333; margin-bottom: 15px; border-left: 4px solid #2E8B47; padding-left: 10px;">Akses Login</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">Username</label>
                    <input type="text" name="username" placeholder="Username login" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" placeholder="••••••••" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>

            <h4 style="color: #333; margin-bottom: 15px; border-left: 4px solid #2E8B47; padding-left: 10px;">Identitas Jurusan</h4>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" placeholder="Contoh: Teknologi Informasi" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">Email Resmi</label>
                    <input type="email" name="email" placeholder="jurusan@campus.ac.id" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">No. Telepon / WA</label>
                    <input type="text" name="no_hp" placeholder="0812xxxxxxxx" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" name="submit" style="background: #2E8B47; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
                <a href="../data_perusahaan.php" style="background: #6c757d; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
</body>
</html>
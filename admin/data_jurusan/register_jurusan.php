<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 
?>

<style>
    .form-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        padding: 40px;
        max-width: 900px;
        margin: 0 auto;
        border: 1px solid #eee;
    }
    .form-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #2E8B47;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e8f5e9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }
    .input-group {
        display: flex;
        flex-direction: column;
    }
    .input-group label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #444;
        font-size: 14px;
    }
    .input-wrapper {
        position: relative;
    }
    .input-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #2E8B47;
    }
    .input-wrapper input {
        width: 100%;
        padding: 12px 15px 12px 45px; /* Padding kiri besar untuk ikon */
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box; /* Agar padding tidak merusak lebar */
        transition: 0.3s;
    }
    .input-wrapper input:focus {
        border-color: #2E8B47;
        outline: none;
        box-shadow: 0 0 0 3px rgba(46, 139, 71, 0.1);
    }
    .btn-container {
        margin-top: 30px;
        display: flex;
        gap: 15px;
        border-top: 1px solid #eee;
        padding-top: 25px;
    }
    .btn-save {
        background: #2E8B47;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-save:hover { background: #24753a; }
    .btn-cancel {
        background: #f3f4f6;
        color: #4b5563;
        padding: 12px 30px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        border: 1px solid #e5e7eb;
    }
</style>

<div class="main-content">
    
    <div style="margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2 style="margin: 0; color: #333;">Registrasi Jurusan</h2>
            <p style="margin: 5px 0 0; color: #666;">Formulir penambahan data Jurusan baru</p>
        </div>
    </div>

    <div class="form-card">
        
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'failed_user'): ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-triangle"></i> Username atau Email sudah digunakan!
                </div>
            <?php elseif ($_GET['status'] == 'failed_jurusan'): ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <i class="fas fa-times-circle"></i> Gagal menyimpan data jurusan.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="proses_register_jurusan.php" method="POST">
            
            <div class="form-section-title">
                <i class="fas fa-user-shield"></i> Akses Login Admin
            </div>
            
            <div class="form-grid">
                <div class="input-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Buat username" required autocomplete="off">
                    </div>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
            </div>

            <div class="form-section-title" style="margin-top: 10px;">
                <i class="fas fa-university"></i> Informasi Jurusan
            </div>

            <div class="input-group" style="margin-bottom: 25px;">
                <label>Nama Jurusan</label>
                <div class="input-wrapper">
                    <i class="fas fa-graduation-cap"></i>
                    <input type="text" name="nama_jurusan" placeholder="Contoh: Teknologi Informasi" required>
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Email Resmi Jurusan</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="jurusan@campus.ac.id" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>No. Telepon / WhatsApp</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>
            </div>

            <div class="btn-container">
                <button type="submit" name="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Jurusan
                </button>
                <a href="../data_perusahaan.php" class="btn-cancel">Batal</a>
            </div>

        </form>
    </div>

</div>
</body>
</html>
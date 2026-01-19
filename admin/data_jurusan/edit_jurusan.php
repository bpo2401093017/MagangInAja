<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 

// 1. Cek apakah ada ID di URL
if (!isset($_GET['id'])) {
    header("Location: ../data_perusahaan.php");
    exit;
}

$id_jurusan = mysqli_real_escape_string($conn, $_GET['id']);

// 2. Ambil Data Jurusan & User sekaligus (JOIN)
$query = "SELECT j.*, u.username, u.email, u.no_hp 
          FROM jurusan j 
          JOIN users u ON j.id_user = u.id_user 
          WHERE j.id_jurusan = '$id_jurusan'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='../data_perusahaan.php';</script>";
    exit;
}
?>

<div class="main-content">
    
    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h2 style="color: #2E8B47; margin: 0;">Edit Data Jurusan</h2>
            <p style="color: #666; margin: 5px 0 0;">Perbarui informasi akun dan profil jurusan.</p>
        </div>
        <a href="../data_perusahaan.php" style="background: #fff; color: #333; padding: 10px 20px; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; font-weight: bold;">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="dashboard-card" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        
        <form action="proses_edit_jurusan.php" method="POST">
            <input type="hidden" name="id_jurusan" value="<?= $data['id_jurusan']; ?>">
            <input type="hidden" name="id_user" value="<?= $data['id_user']; ?>">

            <h4 style="color: #2E8B47; margin-bottom: 20px; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px;">
                <i class="fas fa-user-cog"></i> Informasi Akun
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">Username (Tidak bisa diubah)</label>
                    <input type="text" value="<?= htmlspecialchars($data['username']); ?>" readonly 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; background: #eee; color: #777; border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">Password Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Isi jika ingin ganti password" 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            </div>

            <h4 style="color: #2E8B47; margin-bottom: 20px; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px;">
                <i class="fas fa-university"></i> Detail Jurusan
            </h4>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">Nama Jurusan</label>
                <input type="text" name="nama_jurusan" value="<?= htmlspecialchars($data['nama_jurusan']); ?>" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-bottom: 30px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">Email Resmi</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px;">No. Telepon / WA</label>
                    <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" name="update" style="background: #2E8B47; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="../data_perusahaan.php" style="background: #f3f4f6; color: #333; padding: 12px 30px; border: 1px solid #ddd; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
</body>
</html>
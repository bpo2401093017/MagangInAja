<?php
require_once '../config.php';
require_once '../templates/header_admin.php';

// Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: data_perusahaan.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM perusahaan WHERE id_perusahaan = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_perusahaan.php';</script>";
    exit;
}
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_perusahaan.css">

<main class="main-content">
    <div class="form-container">
        
        <div class="form-header">
            <div>
                <h2>Edit Profil Mitra</h2>
                <p>Perbarui informasi utama mitra industri SIPADEKPNP</p>
            </div>
            <div class="header-icon" style="background: #fff3e0; padding: 12px; border-radius: 12px;">
                <svg width="32" height="32" fill="none" stroke="#FFA000" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
        </div>

        <form action="proses_edit_perusahaan.php" method="POST">
            <input type="hidden" name="id_perusahaan" value="<?= $data['id_perusahaan']; ?>">
            
            <div class="section-title">Detail Perusahaan</div>
            
            <div class="form-grid">
                <div class="input-box full-width">
                    <label>Nama Perusahaan (PT/Instansi)</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan']); ?>" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Email Resmi</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>No. Telepon / WhatsApp</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required>
                    </div>
                </div>

                <div class="input-box full-width">
                    <label>Staff / Penanggung Jawab (PIC)</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <input type="text" name="contact_person" value="<?= htmlspecialchars($data['contact_person']); ?>" required>
                    </div>
                </div>
            </div>

            <div style="margin-top: 40px; display: flex; gap: 15px;">
                <button type="submit" name="update" class="btn-submit" style="margin-top: 0; flex: 2;">Simpan Perubahan</button>
                <a href="data_perusahaan.php" class="btn-theme-white" style="flex: 1; display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 15px; font-weight: 700;">Batal</a>
            </div>
        </form>
    </div>
</main>

</div> </body>
</html>
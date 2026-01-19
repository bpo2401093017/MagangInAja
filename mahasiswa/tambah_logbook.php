<?php
require_once '../auth/auth_mahasiswa.php';
require_once '../templates/header_mahasiswa.php';
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/logbook.css">

<div class="main-content">
    <div class="logbook-header">
        <h2>Tambah Catatan Harian</h2>
    </div>

    <div class="form-log">
        <form action="proses_logbook.php" method="POST" enctype="multipart/form-data">
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 8px; font-weight: bold;">Tanggal Kegiatan</label>
                <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d'); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 8px; font-weight: bold;">Deskripsi Kegiatan</label>
                <textarea name="kegiatan" rows="6" class="form-control" required placeholder="Jelaskan apa yang Anda kerjakan hari ini..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"></textarea>
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display:block; margin-bottom: 8px; font-weight: bold;">Foto Dokumentasi (Wajib)</label>
                <input type="file" name="dokumentasi" required accept="image/*" style="width: 100%;">
                <small style="color: #888;">Format: JPG, PNG, JPEG. Max 2MB.</small>
            </div>

            <button type="submit" name="simpan" class="btn-add-log" style="width: 100%; justify-content: center; border: none; cursor: pointer;">Simpan Logbook</button>
            <a href="logbook.php" style="display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #666;">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
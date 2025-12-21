<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_perusahaan.css">

<main class="main-content">
    <div class="form-container">
        <div class="form-header">
            <div>
                <h2>Profil Mitra Industri</h2>
                <p>Data Perusahaan untuk Kerjasama & Magang</p>
            </div>
            <div class="header-icon">
                <svg width="32" height="32" fill="none" stroke="#64bc6e" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <form action="proses_register.php" method="POST" enctype="multipart/form-data">
            
            <div class="section-title">Informasi Akun</div>
            <div class="form-grid">
                <div class="input-box">
                    <label>Username Akses</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <input type="text" name="username" placeholder="Username untuk login mitra" required>
                    </div>
                </div>
                <div class="input-box">
                    <label>Password</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
            </div>

            <div class="section-title">Informasi Umum</div>
            <div class="form-grid">
                <div class="input-box full-width">
                    <label>Nama Perusahaan / Instansi</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input type="text" name="nama_perusahaan" placeholder="Contoh: PT. Teknologi Nusantara" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Email Resmi</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input type="email" name="email" placeholder="hrd@perusahaan.com" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>No. Telepon / WhatsApp</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <input type="text" name="no_hp" placeholder="(021) xxxxxxx / 0812xxxx" required>
                    </div>
                </div>

                <div class="input-box full-width">
                    <label>Logo Perusahaan</label>
                    <div class="upload-wrapper">
                        <div class="upload-preview">
                            <svg width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="upload-box" onclick="document.getElementById('file-upload').click();">
                            <svg width="24" height="24" fill="none" stroke="#64bc6e" stroke-width="2" viewBox="0 0 24 24" style="margin-bottom:5px; vertical-align:middle;"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <span>Klik untuk upload Logo (PNG/JPG)</span>
                            <input type="file" id="file-upload" name="foto" style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="input-box full-width">
                    <label>Deskripsi & Profil Singkat</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="align-self: flex-start; margin-top: 5px;"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <textarea name="alamat_perusahaan" rows="4" placeholder="Tuliskan alamat lengkap atau deskripsi singkat perusahaan..."></textarea>
                    </div>
                </div>
            </div>

            <div class="section-title">Person In Charge (PIC)</div>
            <div class="input-box full-width">
                <label>Nama PIC / Contact Person</label>
                <div class="input-field">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <input type="text" name="contact_person" placeholder="Nama lengkap staf penanggung jawab" required>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-submit">Simpan Profil Perusahaan</button>
        </form>
    </div>
</main>

</div> 
</body>
</html>
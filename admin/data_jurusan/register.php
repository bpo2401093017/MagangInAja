<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_perusahaan.css">

<main class="main-content">
    <div class="form-container">
        <div class="form-header">
            <div>
                <h2>Registrasi Jurusan Baru</h2>
                <p>Lengkapi 6 data utama untuk pendaftaran </p>
            </div>
            <div class="header-icon">
                <svg width="32" height="32" fill="none" stroke="#64bc6e" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>

        <form action="proses_register.php" method="POST">
            
            <div class="section-title">Akses Login</div>
            <div class="form-grid">
                <div class="input-box">
                    <label>Username</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <input type="text" name="username" placeholder="Username jurusan" required>
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

            <div class="section-title">Detail Jurusan</div>
            <div class="form-grid">
                <div class="input-box full-width">
                    <label>Nama Jurusan</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <input type="text" name="nama_jurusan" placeholder="Contoh: Teknologi Informasi" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Email Resmi</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <input type="email" name="email" placeholder="mesin@pjurusan.com" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>No. Telepon / WhatsApp</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <input type="text" name="no_hp" placeholder="0812xxxxxxxx" required>
                    </div>
                </div>

                <div class="input-box full-width">
                    <label>Kode Jurusan</label>
                    <div class="input-field">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <input type="text" name="kode" placeholder="Kode jurusan" required>
                    </div>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-submit">Simpan Data Jurusan</button>
        </form>
    </div>
</main>

</div> 
</body>
</html>
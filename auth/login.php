<?php
require_once '../config.php';

$error = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPADEKPNP</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="login-page">

    <a href="../index.php" class="btn-home-fixed">
        &larr; Kembali ke Beranda
    </a>

    <div class="login-card">
        <div class="login-header">
            <h2>Masuk SIPADEKPNP</h2>
            <p>Silakan masuk untuk melanjutkan aktivitas magang</p>
        </div>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="prosesLogin.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk Sekarang</button>
            
            <div style="margin-top: 25px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
                <p style="font-size: 14px; color: #666; margin-bottom: 10px;">Mahasiswa belum punya akun?</p>
                <a href="register_mahasiswa.php" style="font-weight: bold; text-decoration: none; color: #2E8B47;">
                    Daftar Sebagai Mahasiswa
                </a>
            </div>
        </form>
    </div>

</body>
</html>
<?php
require_once '../config.php';
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

    <a href="../index.php" class="btn-home">
        &larr; Kembali ke Beranda
    </a>

    <div class="login-card">
        <div class="login-header">
            <h2>Selamat Datang</h2>
            <p>Masuk untuk melanjutkan aktivitas magangmu</p>
        </div>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert">
                <?= htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="prosesLogin.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk Sekarang</button>
            
            <div style="margin-top: 25px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;">
                <p style="font-size: 14px; color: #666; margin-bottom: 10px;">Mahasiswa belum punya akun?</p>
                <a href="register_mahasiswa.php" style="font-weight: bold; text-decoration: none;">
                    Daftar Sebagai Mahasiswa
                </a>
            </div>
        </form>
    </div>

</body>
</html>
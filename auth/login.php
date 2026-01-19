<?php
require_once '../config.php';

$error = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body class="login-page">
    <div style="position: absolute; top: 20px; right: 20px;">
        <a href="../index.php" class="btn-theme-white" style="padding: 10px 20px; text-decoration: none; border-radius: 8px; border: 1px solid #ddd;">Ke Beranda</a>
    </div>

    <div class="login-card">
        <div class="login-header">
            <h2>Login</h2>
            <p>Silakan masuk untuk mengelola sistem</p>
        </div>
        
        <?php if($error): ?>
            <div class="alert"><?= $error ?></div>
        <?php endif; ?>

        <form action="prosesLogin.php" method="POST">
            <?php if (isset($_GET['error'])): ?>
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; border: 1px solid #fecaca; text-align: center;">
                    <i class="ph-bold ph-warning-circle"></i> 
                    <?= htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label>Secure Password</label>
                <div class="input-wrapper">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk ke Sistem</button>
            <div style="margin-top: 20px; text-align: center; font-size: 14px; color: #666;">
    Belum memiliki akun? 
    <a href="../../auth/register_mahasiswa.php" style="color: #059669; font-weight: 600; text-decoration: none;">Sign In Disini</a>
</div>
        </form>
    </div>

</body>
</html>
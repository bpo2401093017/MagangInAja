<?php
require_once "../config.php";

// 1. Ambil Data Jurusan untuk Dropdown
$jurusan_query = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
$prodi_query = mysqli_query($conn, "SELECT * FROM prodi ORDER BY nama_prodi ASC");

// Simpan data prodi ke array PHP untuk dikirim ke Javascript
$prodi_data = [];
while ($row = mysqli_fetch_assoc($prodi_query)) {
    $prodi_data[] = $row;
}

// 2. Proses Registrasi
if (isset($_POST['register'])) {
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($conn, $_POST['username']);
    $nim          = mysqli_real_escape_string($conn, $_POST['nim']);
    $email        = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp        = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $password     = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id_jurusan   = mysqli_real_escape_string($conn, $_POST['id_jurusan']); 
    $id_prodi     = mysqli_real_escape_string($conn, $_POST['id_prodi']);

    // Cek Duplikasi
    $check = mysqli_query($conn, "SELECT * FROM users JOIN mahasiswa ON users.id_user = mahasiswa.id_user 
                                  WHERE users.username = '$username' OR users.email = '$email' OR mahasiswa.nim = '$nim'");
    
    if (mysqli_num_rows($check) > 0) {
        $error = "Username, Email, atau NIM sudah terdaftar!";
    } else {
        // Insert User
        $q_user = "INSERT INTO users (username, email, password, roles, status, created_at) 
                   VALUES ('$username', '$email', '$password', 'mahasiswa', 'Pending', NOW())";
        
        if (mysqli_query($conn, $q_user)) {
            $id_user = mysqli_insert_id($conn); 
            // Insert Mahasiswa
            $q_mhs = "INSERT INTO mahasiswa (id_user, nim, nama_lengkap, no_hp, id_prodi, create_at) 
                      VALUES ('$id_user', '$nim', '$nama_lengkap', '$no_hp', '$id_prodi', NOW())";
            
            if (mysqli_query($conn, $q_mhs)) {
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location.href='login.php';</script>";
                exit;
            } else {
                mysqli_query($conn, "DELETE FROM users WHERE id_user = '$id_user'");
                $error = "Gagal menyimpan data mahasiswa.";
            }
        } else {
            $error = "Gagal membuat akun sistem.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Mahasiswa - SIPADEKPNP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>

<div class="register-container">
    <div class="register-header">
        <h2><i class="fas fa-user-graduate"></i> Registrasi Mahasiswa</h2>
        <p>Lengkapi biodata sesuai KTM untuk akses sistem magang</p>
    </div>

    <form action="" method="POST" class="register-form">
        
        <?php if(isset($error)): ?>
            <div class="alert-error">
                <i class="fas fa-exclamation-triangle"></i> <?= $error; ?>
            </div>
        <?php endif; ?>

        <div class="form-grid">
            <div class="left-col">
                <div class="input-group">
                    <label>Nama Lengkap (Sesuai KTM)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>NIM</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="number" name="nim" placeholder="Nomor Induk Mahasiswa" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <i class="fas fa-at"></i>
                        <input type="text" name="username" placeholder="Username login" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
            </div>

            <div class="right-col">
                <div class="input-group">
                    <label>Email (Gmail Aktif)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="nama@gmail.com" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>No. Handphone (WhatsApp)</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone"></i>
                        <input type="number" name="no_hp" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>

                <div class="input-group">
                    <label>Jurusan</label>
                    <div class="input-wrapper">
                        <i class="fas fa-university"></i>
                        <select name="id_jurusan" id="jurusanSelect" onchange="filterProdi()" required>
                            <option value="">-- Pilih Jurusan --</option>
                            <?php mysqli_data_seek($jurusan_query, 0); ?>
                            <?php while($j = mysqli_fetch_assoc($jurusan_query)): ?>
                                <option value="<?= $j['id_jurusan']; ?>"><?= $j['nama_jurusan']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label>Program Studi</label>
                    <div class="input-wrapper">
                        <i class="fas fa-graduation-cap"></i>
                        <select name="id_prodi" id="prodiSelect" disabled required>
                            <option value="">-- Pilih Jurusan Dahulu --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" name="register" class="btn-submit">Daftar Sekarang</button>

        <div class="auth-footer">
            Sudah punya akun? <a href="login.php">Login disini</a>
        </div>
    </form>
</div>

<script>
    const dataProdi = <?= json_encode($prodi_data); ?>;

    function filterProdi() {
        const jurusanSelect = document.getElementById('jurusanSelect');
        const prodiSelect = document.getElementById('prodiSelect');
        const selectedJurusanId = jurusanSelect.value;

        prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
        prodiSelect.disabled = true;

        if (selectedJurusanId) {
            const filteredProdi = dataProdi.filter(item => item.id_jurusan == selectedJurusanId);
            filteredProdi.forEach(prodi => {
                const option = document.createElement('option');
                option.value = prodi.id_prodi;
                option.textContent = prodi.nama_prodi;
                prodiSelect.appendChild(option);
            });

            if (filteredProdi.length > 0) {
                prodiSelect.disabled = false;
            } else {
                prodiSelect.innerHTML = '<option value="">Tidak ada prodi di jurusan ini</option>';
            }
        }
    }
</script>

</body>
</html>
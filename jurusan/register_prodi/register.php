<?php

require_once "../../templates/header_jurusan.php"; 
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_prodi.css">

<main class="main-content">
    <div class="form-card">
        <h2>Registrasi Program Studi Baru</h2>
        <p>Lengkapi data utama untuk pendaftaran program studi</p>

        <form action="proses_register.php" method="POST">
            <div class="form-group">
                <label for="nama_prodi">Nama Program Studi</label>
                <input type="text" id="nama_prodi" name="nama_prodi" placeholder="Masukkan Nama Program Studi" required>
            </div>

            <div class="form-group radio-box">
                <label>Status</label>
                <div class="input-field">
                    <label><input type="radio" name="status" value="aktif" required> Aktif</label>
                    <label><input type="radio" name="status" value="tidak aktif"> Tidak Aktif</label>
                </div>
            </div>

            <button type="submit" class="btn-submit">Simpan Data Program Studi</button>
        </form>
    </div>
</main>


</div> 
</body>
</html>
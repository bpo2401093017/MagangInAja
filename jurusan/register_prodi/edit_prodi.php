<?php
require_once '../../templates/header_jurusan.php';

// Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: data_prodi.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM prodi WHERE id_prodi = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_prodi.php';</script>";
    exit;
}
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/data_prodi.css">

<main class="main-content">
    <div class="form-card">
        <h2>Edit Program Studi</h2>
        <p>Perbarui informasi utama program studi</p>

        <form action="proses_edit_prodi.php" method="POST">
            <input type="hidden" name="id_prodi" value="<?= $data['id_prodi']; ?>">

            <div class="form-group">
                <label for="nama_prodi">Nama Program Studi</label>
                <input type="text" id="nama_prodi" name="nama_prodi" value="<?= htmlspecialchars($data['nama_prodi']); ?>" required>
            </div>

            <div class="form-group radio-box">
                <label>Status</label>
                <div class="input-field">
                    <label>
                        <input type="radio" name="status" value="aktif" <?= ($data['status'] === 'aktif') ? 'checked' : ''; ?> required>
                        Aktif
                    </label>
                    <label>
                        <input type="radio" name="status" value="tidak aktif" <?= ($data['status'] === 'tidak aktif') ? 'checked' : ''; ?>>
                        Tidak Aktif
                    </label>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" name="update" class="btn-submit" style="flex: 2;">Simpan Perubahan</button>
                <a href="data_prodi.php" class="btn-theme-white" style="flex: 1; display: flex; align-items: center; justify-content: center; text-decoration: none; border-radius: 15px; font-weight: 700;">Batal</a>
            </div>
        </form>
    </div>
</main>

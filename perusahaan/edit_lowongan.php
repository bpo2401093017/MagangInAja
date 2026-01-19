<?php
require_once '../templates/header_perusahaan.php';

if (!isset($_GET['id'])) {
    header("Location: lowongan.php");
    exit;
}

$id_lowongan = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM lowongan WHERE id_lowongan = '$id_lowongan'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: lowongan.php");
    exit;
}

$q_jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
?>
<link rel="stylesheet" href="<?= $base_url; ?>css/lowongan.css">

<div class="main-content">
    <div class="content-header">
        <h2>Edit Lowongan</h2>
    </div>

    <div class="form-container">
        <form action="proses_lowongan.php" method="POST">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id_lowongan" value="<?= $data['id_lowongan']; ?>">
            
            <div class="form-group">
                <label>Judul Lowongan</label>
                <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul_lowongan']); ?>" required>
            </div>

            <div class="form-group">
                <label>Lokasi / Alamat</label>
                <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($data['lokasi']); ?>" required>
            </div>

            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?= $data['tanggal_mulai']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="<?= $data['tanggal_selesai']; ?>" required>
                </div>
            </div>

            <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Kuota Penerimaan</label>
                    <input type="number" name="kuota" class="form-control" value="<?= $data['kuota']; ?>" required min="1">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="dibuka" <?= $data['status'] == 'dibuka' ? 'selected' : ''; ?>>Dibuka</option>
                        <option value="ditutup" <?= $data['status'] == 'ditutup' ? 'selected' : ''; ?>>Ditutup</option>
                        <option value="penuh" <?= $data['status'] == 'penuh' ? 'selected' : ''; ?>>Penuh</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Target Jurusan</label>
                <select name="id_jurusan" class="form-control">
                    <?php while($j = mysqli_fetch_assoc($q_jurusan)): ?>
                        <option value="<?= $j['id_jurusan']; ?>" <?= $data['id_jurusan'] == $j['id_jurusan'] ? 'selected' : ''; ?>>
                            <?= $j['nama_jurusan']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" name="id_prodi" value="0"> 

            <div class="form-group">
                <label>Persyaratan & Deskripsi</label>
                <textarea name="persyaratan" class="form-control" rows="5" required><?= htmlspecialchars($data['persyaratan']); ?></textarea>
            </div>

            <button type="submit" class="btn-submit">Simpan Perubahan</button>
            <a href="lowongan.php" style="display: block; text-align: center; margin-top: 15px; color: #666; text-decoration: none;">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
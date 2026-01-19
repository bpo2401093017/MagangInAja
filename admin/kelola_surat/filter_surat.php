<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 

// Tangkap tipe surat dari URL
$tipe = isset($_GET['tipe']) ? $_GET['tipe'] : 'permohonan';
$judul = ($tipe == 'pelaksanaan') ? 'Surat Pelaksanaan Magang' : 'Surat Permohonan Magang';
$action_url = ($tipe == 'pelaksanaan') ? 'cetak_pelaksanaan.php' : 'cetak_permohonan.php';

// Ambil Data Perusahaan & Jurusan untuk Dropdown
$q_mitra = mysqli_query($conn, "SELECT * FROM perusahaan ORDER BY nama_perusahaan ASC");
$q_jurusan = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY nama_jurusan ASC");
?>

<div class="main-content">
    <div class="content-header">
        <h2>Buat <?= $judul; ?></h2>
        <p>Lengkapi formulir di bawah ini untuk mencetak surat.</p>
    </div>

    <div style="background: white; padding: 40px; border-radius: 12px; max-width: 700px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        
        <form action="<?= $action_url; ?>" method="POST" target="_blank">
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">1. Pilih Perusahaan Tujuan</label>
                <select name="id_perusahaan" required 
                        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; background: #fafafa;">
                    <option value="">-- Pilih Mitra Industri --</option>
                    <?php mysqli_data_seek($q_mitra, 0); ?>
                    <?php while($row = mysqli_fetch_assoc($q_mitra)): ?>
                        <option value="<?= $row['id_perusahaan']; ?>"><?= $row['nama_perusahaan']; ?></option>
                    <?php endwhile; ?>
                </select>
                <small style="color: #666; display: block; margin-top: 5px;">*Lokasi & Nama Perusahaan akan otomatis terisi di surat.</small>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">2. Pilih Jurusan Mahasiswa</label>
                <select name="id_jurusan" required 
                        style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; background: #fafafa;">
                    <option value="">-- Pilih Jurusan --</option>
                    <?php mysqli_data_seek($q_jurusan, 0); ?>
                    <?php while($row = mysqli_fetch_assoc($q_jurusan)): ?>
                        <option value="<?= $row['id_jurusan']; ?>"><?= $row['nama_jurusan']; ?></option>
                    <?php endwhile; ?>
                </select>
                <small style="color: #666; display: block; margin-top: 5px;">*Sistem akan mengambil semua mahasiswa dari jurusan ini yang melamar ke perusahaan di atas.</small>
            </div>

            <hr style="margin: 30px 0; border: 0; border-top: 2px dashed #eee;">

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">3. Nomor Surat</label>
                <input type="text" name="nomor_surat" placeholder="Contoh: 232 /DST/PL9/PP.02.10/2026" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Tanggal Mulai Magang</label>
                    <input type="date" name="tgl_mulai" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 8px; color: #333;">Tanggal Selesai Magang</label>
                    <input type="date" name="tgl_selesai" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px;">
                </div>
            </div>

            <div style="background: #e8f5e9; padding: 15px; border-radius: 6px; color: #2E8B47; font-size: 14px; margin-bottom: 25px;">
                <i class="fas fa-info-circle"></i> Tanggal surat otomatis diset <b>Hari Ini (<?= date('d F Y'); ?>)</b>.
            </div>

            <button type="submit" 
                    style="background: #2E8B47; color: white; padding: 15px 30px; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-print"></i> Generate Surat (PDF)
            </button>
        </form>
    </div>
</div>

</div> </body>
</html>
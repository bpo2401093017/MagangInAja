<?php
// Matikan pelaporan error agar tidak bingung
error_reporting(0);

// Panggil koneksi database (langsung satu folder)
require_once 'config.php';

// Jika gagal koneksi (karena path config salah), coba path alternatif
if (!isset($conn)) {
    if (file_exists('../config.php')) {
        require_once '../config.php';
    } else {
        die("<h3>❌ Gagal memanggil config.php. Pastikan file ini ada di folder 'MagangInAja'</h3>");
    }
}

echo "<h2>🛠️ SCRIPT PENYELAMAT DATA (PERBAIKAN)</h2>";
echo "<p>Sedang memeriksa database...</p>";

// 1. PASTIKAN TABEL LAMARAN ADA
$sql_table = "CREATE TABLE IF NOT EXISTS `lamaran` (
  `id_lamaran` int(11) NOT NULL AUTO_INCREMENT,
  `id_mahasiswa` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `tgl_lamar` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `file_cv` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_lamaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $sql_table);


// 2. CEK & ISI PERUSAHAAN (Jika Kosong)
$q_cek_prs = mysqli_query($conn, "SELECT id_perusahaan FROM perusahaan LIMIT 1");
if (mysqli_num_rows($q_cek_prs) == 0) {
    // Buat User PT
    mysqli_query($conn, "INSERT INTO users (username, password, email, roles, status) VALUES ('pt_demo', '123', 'pt@demo.com', 'perusahaan', 'Verified')");
    $id_user_prs = mysqli_insert_id($conn);
    // Buat Data PT
    $sql_prs = "INSERT INTO perusahaan (id_user, nama_perusahaan, alamat_perusahaan) 
                VALUES ('$id_user_prs', 'PT Teknologi Maju Jaya', 'Jl. Sudirman No. 1 Jakarta')";
    mysqli_query($conn, $sql_prs);
    $id_perusahaan = mysqli_insert_id($conn);
    echo "✅ Berhasil membuat Perusahaan Dummy.<br>";
} else {
    $d_prs = mysqli_fetch_assoc($q_cek_prs);
    $id_perusahaan = $d_prs['id_perusahaan'];
    echo "✅ Data Perusahaan sudah ada.<br>";
}

// 3. CEK & ISI LOWONGAN (Jika Kosong/Tutup)
$q_cek_loker = mysqli_query($conn, "SELECT id_lowongan FROM lowongan WHERE status='buka'");
if (mysqli_num_rows($q_cek_loker) == 0) {
    // Masukkan Lowongan Baru
    $sql_loker = "INSERT INTO lowongan (id_perusahaan, judul_lowongan, deskripsi, status) 
                  VALUES ('$id_perusahaan', 'Programmer Magang', 'Dibutuhkan segera.', 'buka')";
    if (mysqli_query($conn, $sql_loker)) {
        echo "✅ Berhasil membuat Lowongan Dummy.<br>";
    } else {
        echo "❌ Gagal buat lowongan: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "✅ Lowongan tersedia.<br>";
}

echo "<hr>";
echo "<h3>🎉 PERBAIKAN SELESAI!</h3>";
echo "Silakan coba langkah ini sekarang:<br>";
echo "1. <a href='mahasiswa/lowongan.php'>Buka Menu Cari Lowongan</a><br>";
echo "2. Klik Tombol <b>Lamar Sekarang</b>.<br>";
echo "3. Cek <a href='mahasiswa/riwayat_lamaran.php'>Riwayat Lamaran</a>.";
?>
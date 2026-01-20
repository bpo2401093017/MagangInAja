<?php
session_start();
require_once '../config.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// 2. Cek apakah ada ID Lowongan yang dikirim
if (isset($_GET['id_lowongan'])) {

    $id_lowongan = mysqli_real_escape_string($conn, $_GET['id_lowongan']);
    $id_user = $_SESSION['user_id'];

    // AMBIL DATA PERUSAHAAN DARI TABEL LOWONGAN (Pastikan kolom-kolom ini ada di tabel lowongan)
    // Kita gunakan JOIN ke tabel perusahaan jika nama/alamat ada di sana, 
    // atau langsung ambil jika kolomnya ada di tabel lowongan.
    $q_low = mysqli_query($conn, "SELECT l.id_perusahaan, p.nama_perusahaan, p.alamat_perusahaan 
                                  FROM lowongan l 
                                  JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan 
                                  WHERE l.id_lowongan = '$id_lowongan'");
    
    $d_low = mysqli_fetch_assoc($q_low);


    if (!$d_low) {
        echo "<script>alert('Data lowongan tidak ditemukan!'); window.location='lowongan.php';</script>";
        exit;
    }
    $q_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
$d_mhs = mysqli_fetch_assoc($q_mhs);

if (!$d_mhs) {
    // Jika tidak ketemu, berarti user ini belum isi data profil mahasiswa
    echo "<script>alert('Lengkapi Biodata Mahasiswa Dulu!'); window.location='lihat_profile.php';</script>";
    exit;
}

// Simpan ke variabel agar bisa dipakai di INSERT
$id_mahasiswa = $d_mhs['id_mahasiswa'];

    // Definisikan variabel agar bisa dipakai di INSERT
    $id_perusahaan     = $d_low['id_perusahaan'];
    $nama_perusahaan   = $d_low['nama_perusahaan'];
    $alamat_perusahaan = $d_low['alamat_perusahaan'];

    // ... (Bagian 3 & 4 tetap sama)

    // 5. INSERT DATA KE DATABASE
    $query_insert = "INSERT INTO pengajuan (id_perusahaan, id_mahasiswa, nama_perusahaan, alamat_perusahaan, id_lowongan, create_at, status, jenis) 
                     VALUES ('$id_perusahaan', '$id_mahasiswa', '$nama_perusahaan', '$alamat_perusahaan', '$id_lowongan', NOW(), 'menunggu_verifikasi')";

    if (mysqli_query($conn, $query_insert)) {
        // SUKSES
        echo "<script>
            alert('Berhasil Melamar!');
            window.location = 'riwayat_lamaran.php';
        </script>";
    } else {
        echo "Error Database: " . mysqli_error($conn);
    }
}
?>
<?php
session_start();
require_once '../../config/koneksi.php';

$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    die("Akses tidak valid");
}
$sqlUser = "
SELECT nim, email, no_hp, nama_jurusan, nama_prodi
FROM users
WHERE id_user = ?
";

$stmtUser = mysqli_prepare($conn, $sqlUser);
mysqli_stmt_bind_param($stmtUser, "i", $id_user);
mysqli_stmt_execute($stmtUser);

$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtUser));
if (!$user) {
    die("Data pengguna tidak ditemukan");
}

$sqlCek = "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = ?";
$stmtCek = mysqli_prepare($conn, $sqlCek);
mysqli_stmt_bind_param($stmtCek, "i", $id_user);
mysqli_stmt_execute($stmtCek);

$resultCek = mysqli_stmt_get_result($stmtCek);
$mahasiswa = mysqli_fetch_assoc($resultCek);

$adaMahasiswa = $mahasiswa ? true : false;

if (isset($_POST['simpan'])) {

    $nama          = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat        = $_POST['alamat'];
    $angkatan      = $_POST['angkatan'];

    $now = date('Y-m-d H:i:s');

    if (!$adaMahasiswa) {
        // ===== INSERT PERTAMA KALI =====
        $sqlInsert = "
        INSERT INTO mahasiswa
        (id_user, nim, nama, jenis_kelamin, alamat, nama_jurusan, nama_prodi, angkatan, email, no_hp, create_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = mysqli_prepare($conn, $sqlInsert);
        mysqli_stmt_bind_param(
            $stmt,
            "issssssisss",
            $id_user,
            $user['nim'],
            $nama,
            $jenis_kelamin,
            $alamat,
            $user['nama_jurusan'],
            $user['nama_prodi'],
            $angkatan,
            $user['email'],
            $user['no_hp'],
            $now
        );

        mysqli_stmt_execute($stmt);

    } else {
        // ===== UPDATE =====
        $sqlUpdate = "
        UPDATE mahasiswa SET
            nama = ?,
            jenis_kelamin = ?,
            alamat = ?,
            angkatan = ?
        WHERE id_user = ?
        ";

        $stmt = mysqli_prepare($conn, $sqlUpdate);
        mysqli_stmt_bind_param(
            $stmt,
            "sssii",
            $nama,
            $jenis_kelamin,
            $alamat,
            $angkatan,
            $id_user
        );

        mysqli_stmt_execute($stmt);
    }

    header("Location: data_mahasiswa.php?status=success");
    exit;
}
?>
<form method="POST">

    <!-- KATEGORI UMUM (users) -->
    <input type="text" value="<?= $user['nim']; ?>" disabled>
    <input type="text" value="<?= $user['nama_jurusan']; ?>" disabled>
    <input type="text" value="<?= $user['nama_prodi']; ?>" disabled>
    <input type="email" value="<?= $user['email']; ?>" disabled>
    <input type="text" value="<?= $user['no_hp']; ?>" disabled>

    <!-- PROFIL MAHASISWA -->
    <input type="text" name="nama" required>
    
    <select name="jenis_kelamin" required>
        <option value="laki-laki">Laki-laki</option>
        <option value="perempuan">Perempuan</option>
    </select>

    <textarea name="alamat" required></textarea>

    <input type="number" name="angkatan" required>

    <button type="submit" name="simpan">Simpan</button>
</form>

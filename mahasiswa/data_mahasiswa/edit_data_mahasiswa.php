<?php
session_start();
require_once '../../config.php';

$id_user = $_SESSION['user_id'] ?? null;
if (!$id_user) {
    die("Akses tidak valid");
}

/* ===============================
   AMBIL DATA USER
================================ */
$sqlUser = "SELECT email, no_hp FROM users WHERE id_user = ?";
$stmtUser = mysqli_prepare($conn, $sqlUser);
mysqli_stmt_bind_param($stmtUser, "i", $id_user);
mysqli_stmt_execute($stmtUser);

$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtUser));

if (!$user) {
    die("Data pengguna tidak ditemukan");
}

/* ===============================
   CEK DATA MAHASISWA
================================ */
$sqlCek = "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = ?";
$stmtCek = mysqli_prepare($conn, $sqlCek);
mysqli_stmt_bind_param($stmtCek, "i", $id_user);
mysqli_stmt_execute($stmtCek);
$mahasiswa = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtCek));

$adaMahasiswa = $mahasiswa ? true : false;

/* ===============================
   PROSES SIMPAN
================================ */
if (isset($_POST['simpan'])) {

    // ---- DATA FORM ----
    $nama_lengkap  = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat        = $_POST['alamat'];
    $angkatan      = $_POST['angkatan'];
    $kelas         = $_POST['kelas'];
    $nama_jurusan  = $_POST['nama_jurusan'];
    $nama_prodi    = $_POST['nama_prodi'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $nim           = $_POST['nim'];

    $now = date('Y-m-d H:i:s');

    /* ===============================
       INSERT / UPDATE MAHASISWA
    ================================ */
            if (!$adaMahasiswa) {

                $sqlInsert = "
            INSERT INTO mahasiswa
            (id_user, nim, nama_lengkap, tanggal_lahir, jenis_kelamin, alamat, nama_jurusan, nama_prodi, angkatan, kelas, email, no_hp, create_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = mysqli_prepare($conn, $sqlInsert);
        mysqli_stmt_bind_param(
            $stmt,
            "issssssssisss",
            $id_user,
            $nim,
            $nama_lengkap,
            $tanggal_lahir,
            $jenis_kelamin,
            $alamat,
            $nama_jurusan,
            $nama_prodi,
            $angkatan,
            $kelas,
            $user['email'],
            $user['no_hp'],
            $now
        );

        mysqli_stmt_execute($stmt);


    } else {

        $sqlUpdate = "
            UPDATE mahasiswa SET
                nama_lengkap = ?,
                tanggal_lahir = ?,
                jenis_kelamin = ?,
                alamat = ?,
                nama_jurusan = ?,
                nama_prodi = ?,
                angkatan = ?,
                kelas = ?
            WHERE id_user = ?
        ";

        $stmt = mysqli_prepare($conn, $sqlUpdate);
                    mysqli_stmt_bind_param(
                $stmt,
                "sssssssii",
                $nama_lengkap,
                $tanggal_lahir,
                $jenis_kelamin,
                $alamat,
                $nama_jurusan,
                $nama_prodi,
                $angkatan,
                $kelas,
                $id_user
            );

        mysqli_stmt_execute($stmt);
    }

    /* ===============================
       UPLOAD BERKAS (CV & PROPOSAL)
    ================================ */
    $folder = "../../uploads/mahasiswa/";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $jenisBerkas = ['cv', 'proposal'];

    foreach ($jenisBerkas as $jenis) {
        if (!empty($_FILES[$jenis]['name'])) {

            $ext = pathinfo($_FILES[$jenis]['name'], PATHINFO_EXTENSION);
            $namaFile = $jenis . "_" . $id_user . "_" . time() . "." . $ext;
            $path = $folder . $namaFile;

            if (move_uploaded_file($_FILES[$jenis]['tmp_name'], $path)) {

                // hapus lama (optional)
                $hapus = "DELETE FROM mahasiswa_berkas WHERE id_user = ? AND jenis_berkas = ?";
                $stmtDel = mysqli_prepare($conn, $hapus);
                mysqli_stmt_bind_param($stmtDel, "is", $id_user, $jenis);
                mysqli_stmt_execute($stmtDel);

                // insert baru
                $sqlFile = "
                    INSERT INTO mahasiswa_berkas
                    (id_user, jenis_berkas, nama_file, created_at)
                    VALUES (?, ?, ?, ?)
                ";
                $stmtFile = mysqli_prepare($conn, $sqlFile);
                mysqli_stmt_bind_param(
                    $stmtFile,
                    "isss",
                    $id_user,
                    $jenis,
                    $namaFile,
                    $now
                );
                mysqli_stmt_execute($stmtFile);
            }
        }
    }

    header("Location: data_mahasiswa.php?status=success");
    exit;
}
?>

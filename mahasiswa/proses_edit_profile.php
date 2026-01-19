<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['user_id'];
    
    // 1. TANGKAP DATA (PERBAIKAN NAMA VARIABEL)
    $nim            = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama_lengkap   = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp          = mysqli_real_escape_string($conn, $_POST['no_hp']);
    
    // INI YANG TADI SALAH (name='tanggal_lahir', bukan 'tgl_lahir')
    $tgl_lahir      = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']); 
    
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $angkatan       = mysqli_real_escape_string($conn, $_POST['angkatan']);
    $kelas          = mysqli_real_escape_string($conn, $_POST['kelas']);
    $alamat         = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    // TAMBAHAN: Tangkap Jurusan & Prodi
    $id_jurusan     = mysqli_real_escape_string($conn, $_POST['id_jurusan']);
    $id_prodi       = mysqli_real_escape_string($conn, $_POST['id_prodi']);

    // 2. PROSES UPDATE FOTO
    $q_old = mysqli_query($conn, "SELECT foto FROM users WHERE id_user = '$id_user'");
    $d_old = mysqli_fetch_assoc($q_old);
    $nama_foto = $d_old['foto']; 

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp  = $_FILES['foto']['tmp_name'];
        $ext       = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($ext, ['jpg', 'jpeg', 'png']) && $_FILES['foto']['size'] <= 2000000) {
            $nama_foto = "profile_" . $id_user . "_" . time() . "." . $ext;
            move_uploaded_file($file_tmp, "../img/profile_mahasiswa/" . $nama_foto);
        }
    }

    // 3. UPDATE TABEL USERS
    $sql_user = "UPDATE users SET email='$email', no_hp='$no_hp', foto='$nama_foto' WHERE id_user='$id_user'";
    mysqli_query($conn, $sql_user);

    // 4. CEK & UPDATE TABEL MAHASISWA
    $cek_mhs = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user='$id_user'");
    
    if (mysqli_num_rows($cek_mhs) > 0) {
        // UPDATE (Sekarang termasuk jurusan & prodi)
        $sql_mhs = "UPDATE mahasiswa SET 
                    nim = '$nim',
                    nama_lengkap = '$nama_lengkap',
                    email = '$email',
                    no_hp = '$no_hp',
                    tanggal_lahir = '$tgl_lahir',
                    jenis_kelamin = '$jenis_kelamin',
                    angkatan = '$angkatan',
                    kelas = '$kelas',
                    alamat = '$alamat',
                    id_jurusan = '$id_jurusan',
                    id_prodi = '$id_prodi'
                    WHERE id_user = '$id_user'";
    } else {
        // INSERT BARU (Jika belum ada)
        $sql_mhs = "INSERT INTO mahasiswa (
                        id_user, nim, nama_lengkap, email, no_hp, 
                        tanggal_lahir, jenis_kelamin, angkatan, kelas, alamat, 
                        id_jurusan, id_prodi, create_at
                    ) VALUES (
                        '$id_user', '$nim', '$nama_lengkap', '$email', '$no_hp', 
                        '$tgl_lahir', '$jenis_kelamin', '$angkatan', '$kelas', '$alamat', 
                        '$id_jurusan', '$id_prodi', NOW()
                    )";
    }

    // Eksekusi
    if (mysqli_query($conn, $sql_mhs)) {
        echo "<script>
                alert('Biodata Berhasil Disimpan!');
                window.location.href = 'lihat_profile.php';
              </script>";
    } else {
        echo "Gagal menyimpan: " . mysqli_error($conn);
    }
}
?>
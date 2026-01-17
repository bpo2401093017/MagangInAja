<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .readonly-input { background-color: #e9ecef !important; cursor: not-allowed; }
        .profile-img { width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <form action="update_proses.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">Kategori Umum</div>
                    <div class="card-body text-center">
                        <img src="uploads/<?php echo $user['foto']; ?>" class="profile-img mb-3" alt="Foto Profil">
                        <div class="mb-3">
                            <label class="form-label small">Ubah Foto Profile</label>
                            <input type="file" name="foto_profile" class="form-control form-control-sm">
                        </div>
                        <hr>
                        <div class="text-start">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control readonly-input" value="<?php echo $user['username']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="text" class="form-control readonly-input" value="<?php echo $user['nim']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gmail</label>
                                <input type="email" name="gmail" class="form-control" value="<?php echo $user['gmail']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="<?php echo $user['no_hp']; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" class="form-control readonly-input" value="<?php echo $user['jurusan']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Prodi</label>
                                <input type="text" class="form-control readonly-input" value="<?php echo $user['prodi']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">Profil Saya</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $mhs['nama_lengkap']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $mhs['tanggal_lahir']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki" <?php if($mhs['jenis_kelamin'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                    <option value="Perempuan" <?php if($mhs['jenis_kelamin'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Alamat Rumah</label>
                                <textarea name="alamat" class="form-control" rows="3"><?php echo $mhs['alamat']; ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Angkatan</label>
                                <input type="number" name="angkatan" class="form-control" value="<?php echo $mhs['angkatan']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="<?php echo $mhs['kelas']; ?>">
                            </div>
                        </div>
                        <div class="mt-4 border-top pt-3 text-end">
                            <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
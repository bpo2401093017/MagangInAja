<?php
require_once "../../config.php";
require_once "../../templates/header_admin.php"; 
?>

<div class="main-content">
    <div class="content-header">
        <h2>Kelola Surat Magang</h2>
        <p>Cetak surat resmi untuk keperluan administrasi mahasiswa magang.</p>
    </div>

    <style>
        .surat-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        .surat-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }
        .surat-card:hover {
            transform: translateY(-5px);
            border-color: #2E8B47;
            box-shadow: 0 10px 25px rgba(46, 139, 71, 0.15);
        }
        .surat-icon {
            font-size: 60px;
            color: #2E8B47;
            margin-bottom: 25px;
        }
        .surat-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .surat-desc {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-surat {
            display: inline-block;
            padding: 12px 30px;
            background: #2E8B47;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-surat:hover {
            background: #1e5c2e;
        }
    </style>

    <div class="surat-container">
        <div class="surat-card">
            <i class="fas fa-file-contract surat-icon"></i>
            <div class="surat-title">Surat Permohonan Magang</div>
            <p class="surat-desc">
                Dibuat saat mahasiswa telah disetujui oleh Jurusan. Surat ini diajukan ke perusahaan sebagai permohonan resmi.
            </p>
            <a href="filter_surat.php?tipe=permohonan" class="btn-surat">Buat Permohonan</a>
        </div>

        <div class="surat-card">
            <i class="fas fa-file-signature surat-icon"></i>
            <div class="surat-title">Surat Pelaksanaan Magang</div>
            <p class="surat-desc">
                Dibuat saat mahasiswa diterima oleh Perusahaan. Surat ini berisi konfirmasi pelaksanaan dan daftar nama mahasiswa.
            </p>
            <a href="filter_surat.php?tipe=pelaksanaan" class="btn-surat">Buat Pelaksanaan</a>
        </div>
    </div>
</div>

</div> </body>
</html>
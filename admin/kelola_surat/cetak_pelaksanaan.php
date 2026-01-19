<?php
require_once "../../config.php";

// 1. Tangkap Input
$id_perusahaan = $_POST['id_perusahaan'];
$id_jurusan    = $_POST['id_jurusan'];
$nomor_surat   = $_POST['nomor_surat'];
$tgl_mulai     = date('d F Y', strtotime($_POST['tgl_mulai']));
$tgl_selesai   = date('d F Y', strtotime($_POST['tgl_selesai']));

$bulan = [
    'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April',
    'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus',
    'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];
$tgl_surat = date('d') . ' ' . $bulan[date('F')] . ' ' . date('Y');

$q_prs = mysqli_query($conn, "SELECT * FROM perusahaan WHERE id_perusahaan = '$id_perusahaan'");
$d_prs = mysqli_fetch_assoc($q_prs);

// 2. Query Data Mahasiswa (TANPA NO HP)
$query_mhs = "SELECT m.nama_lengkap, m.nim, p.nama_prodi
              FROM mahasiswa m
              JOIN prodi p ON m.id_prodi = p.id_prodi
              WHERE p.id_jurusan = '$id_jurusan'
              ORDER BY m.nama_lengkap ASC";
$res_mhs = mysqli_query($conn, $query_mhs);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Pelaksanaan</title>
    <style>
        /* STYLE SAMA DENGAN PERMOHONAN */
        @page { size: A4; margin: 2cm; }
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.5; color: #000; background: #fff; }
        .kop-header { display: flex; align-items: center; justify-content: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .logo-img { width: 90px; height: auto; position: absolute; left: 2cm; }
        .kop-text { flex: 1; text-align: center; }
        .kop-text h4 { margin: 0; font-size: 12pt; font-weight: normal; text-transform: uppercase; }
        .kop-text h2 { margin: 0; font-size: 14pt; font-weight: bold; text-transform: uppercase; }
        .kop-text p { margin: 0; font-size: 10pt; font-style: italic; }
        .nomor-area, .tujuan-area { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table, th, td { border: 1px solid black; }
        th { background-color: #f0f0f0; text-align: center; padding: 5px; font-weight: bold; }
        td { padding: 5px 8px; }
        p { text-align: justify; margin-bottom: 10px; }
        .indent { text-indent: 40px; }
        .ttd-area { float: right; width: 300px; margin-top: 40px; text-align: left; }
        .ttd-area p { margin: 0; }
        .no-print { position: fixed; top: 0; left: 0; width: 100%; background: #333; color: white; text-align: center; padding: 10px; font-family: sans-serif; z-index: 9999; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        Tekan <b>Ctrl + P</b> atau klik kanan -> Print, lalu pilih <b>Save as PDF</b>.
    </div>

    <div class="kop-header">
        <img src="../../img/logo_pnp.png" class="logo-img" alt="Logo" onerror="this.style.display='none'">
        <div class="kop-text">
            <h4>KEMENTERIAN PENDIDIKAN TINGGI, SAINS DAN TEKNOLOGI</h4>
            <h2>POLITEKNIK NEGERI PADANG</h2>
            <p>Kampus Politeknik Negeri Padang Limau Manis, Padang, Sumatera Barat</p>
            <p>Telepon : (0751) 72590, Faks. (0751) 72576</p>
            <p>Laman : http://www.pnp.ac.id, mail : info@pnp.ac.id</p>
        </div>
    </div>

    <div class="nomor-area">
        <table style="border: none; width: 100%; margin: 0;">
            <tr style="border: none;">
                <td style="border: none; width: 60px;">No</td>
                <td style="border: none;">: <?= htmlspecialchars($nomor_surat); ?></td>
                <td style="border: none; text-align: right;">Padang, <?= $tgl_surat; ?></td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">Hal</td>
                <td style="border: none;" colspan="2">: <b>Pelaksanaan Magang</b></td>
            </tr>
        </table>
    </div>

    <div class="tujuan-area">
        Kepada Yth :<br>
        Bapak/Ibu Pimpinan <b><?= htmlspecialchars($d_prs['nama_perusahaan']); ?></b><br>
        Di Tempat
    </div>

    <p>Dengan hormat,</p>

    <p class="indent">
        Kami mendoakan semoga Bapak berada dalam keadaan sehat wal’afiat, lancar dalam melaksanakan segala aktivitas dan selalu dalam lindungan Allah SWT. Amin.
    </p>

    <p class="indent">
        Sebelumnya kami mengucapkan terima kasih atas kesediaan Bapak menerima mahasiswa kami untuk melaksanakan Magang pada perusahaan/instansi yang Bapak kelola mulai dari tanggal <b><?= $tgl_mulai; ?> s.d <?= $tgl_selesai; ?></b>. Adapun mahasiswa kami yang akan Magang sebagai berikut:
    </p>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(mysqli_num_rows($res_mhs) > 0) {
                while($mhs = mysqli_fetch_assoc($res_mhs)) {
                    echo "<tr>
                        <td style='text-align:center'>$no</td>
                        <td>{$mhs['nama_lengkap']}</td>
                        <td style='text-align:center'>{$mhs['nim']}</td>
                        <td>{$mhs['nama_prodi']}</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; padding: 20px;'>Belum ada data mahasiswa</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <p class="indent">
        Sehubungan dengan itu, kami memohon kepada Bapak beserta staf agar dapat membimbing mahasiswa kami tersebut selama pelaksanaan Magang.
    </p>
    <p class="indent">
        Sekiranya terjadi segala sesuatu hal dalam pelaksanaan Magang tersebut kami mohon kepada Bapak/Ibu untuk menginformasikannya kepada kami.
    </p>

    <p class="indent">
        Demikianlah hal ini kami sampaikan atas bantuan dan kerjasamanya kami ucapkan terima kasih.
    </p>

    <div class="ttd-area">
        <p>Hormat kami</p>
        <p>Wakil Direktur Bidang Kerjasama</p>
        <br><br><br><br>
        <p style="text-decoration: underline; font-weight: bold;">Ihsan Lumasa Rimra</p>
        <p>Nip. 197811252003121002</p>
    </div>

</body>
</html>
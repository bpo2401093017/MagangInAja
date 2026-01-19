<?php
require_once '../templates/header_mahasiswa.php';

// 1. Ambil ID Mahasiswa
$id_user = $_SESSION['user_id'];
$q_mhs   = mysqli_query($conn, "SELECT id_mahasiswa FROM mahasiswa WHERE id_user = '$id_user'");
$d_mhs   = mysqli_fetch_assoc($q_mhs);
$id_mahasiswa = $d_mhs['id_mahasiswa'] ?? 0;

// 2. Query Logbook
$query = "SELECT * FROM logbook WHERE id_mahasiswa = '$id_mahasiswa' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="../css/logbook.css">

<div class="main-content">
    
    <div class="logbook-header">
        <div>
            <h2>Buku Harian Kegiatan</h2>
            <p>Catat aktivitas magang Anda setiap hari.</p>
        </div>
        <a href="tambah_logbook.php" class="btn-add">
            <i class="fas fa-plus"></i> Tulis Logbook
        </a>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table-logbook">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="40%">Kegiatan</th>
                        <th width="15%">Dokumentasi</th>
                        <th width="15%">Status</th>
                        <th width="10%" style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++; ?></td>
                                
                                <td>
                                    <b><?= date('d M Y', strtotime($row['tanggal'])); ?></b>
                                </td>
                                
                                <td style="line-height: 1.6;">
                                    <?php 
                                        // Cek ketersediaan kolom untuk menghindari error undefined
                                        $isi_kegiatan = $row['kegiatan'] ?? $row['deskripsi'] ?? '-';
                                        echo nl2br(htmlspecialchars($isi_kegiatan)); 
                                    ?>
                                </td>

                                <td style="text-align: center;">
                                    <?php if (!empty($row['dokumentasi'])): ?>
                                        <img src="<?= $base_url; ?>img/logbook/<?= $row['dokumentasi']; ?>" 
                                             class="thumb-img" 
                                             onclick="viewImage(this.src)"
                                             alt="Bukti">
                                    <?php else: ?>
                                        <span style="font-size: 12px; color: #999;">-</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php 
                                        $st = $row['status'];
                                        if($st == 'approved') echo '<span class="badge badge-approve">Disetujui</span>';
                                        else if($st == 'rejected') echo '<span class="badge badge-reject">Ditolak</span>';
                                        else echo '<span class="badge badge-pending">Menunggu</span>';
                                    ?>
                                </td>

                                <td style="text-align: center;">
                                    <?php if ($st == 'pending'): ?>
                                        <a href="proses_logbook.php?aksi=hapus&id=<?= $row['id_logbook']; ?>" 
                                           class="btn-delete"
                                           onclick="return confirm('Hapus catatan ini?')">
                                           <i class="fas fa-trash-alt"></i>
                                        </a>
                                    <?php else: ?>
                                        <i class="fas fa-lock" style="color: #ccc;" title="Terkunci"></i>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                                Belum ada catatan kegiatan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="imageModal" class="modal-img">
    <span class="close-img" onclick="closeModal()">&times;</span>
    <img class="modal-content-img" id="imgFull">
</div>

<script>
    function viewImage(src) {
        document.getElementById('imgFull').src = src;
        document.getElementById('imageModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Tutup jika klik luar gambar
    window.onclick = function(event) {
        var modal = document.getElementById('imageModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>
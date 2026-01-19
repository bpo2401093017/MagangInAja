<?php
require_once '../templates/header_mahasiswa.php';

// Panggil CSS Bawaan Project
echo '<link rel="stylesheet" href="../css/lowongan.css">';

// Query Data Lowongan
// Kita ambil data lowongan + nama perusahaan + foto
// PERBAIKAN: Pastikan mengambil kolom 'persyaratan'
$query = "SELECT l.*, p.nama_perusahaan, p.foto 
          FROM lowongan l
          JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
          ORDER BY l.id_lowongan DESC";

$result = mysqli_query($conn, $query);
?>

<div class="main-content">
    <div class="container-lowongan">
        
        <h2 class="page-title" style="color: #2E8B47; margin-bottom: 20px;">Daftar Lowongan Magang</h2>

        <div class="grid-lowongan" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    
                    <div class="card-lowongan" style="background: #fff; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        
                        <div class="card-body" style="padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                                <img src="<?= $base_url; ?>img/profile_perusahaan/<?= $row['foto'] ?? 'default.png'; ?>" 
                                     alt="Logo"
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 1px solid #eee;"
                                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($row['nama_perusahaan']); ?>'">
                                <div>
                                    <h4 style="margin: 0; font-size: 18px; color: #333;"><?= htmlspecialchars($row['judul_lowongan']); ?></h4>
                                    <span style="font-size: 13px; color: #666;"><?= htmlspecialchars($row['nama_perusahaan']); ?></span>
                                </div>
                            </div>

                            <p style="color: #555; font-size: 14px; line-height: 1.5; margin-bottom: 20px; height: 60px; overflow: hidden;">
                                <?php 
                                    // PERBAIKAN DI SINI: Ganti 'deskripsi' jadi 'persyaratan'
                                    // Sesuai dengan nama kolom di database Anda (magang.sql)
                                    $desk = !empty($row['persyaratan']) ? strip_tags($row['persyaratan']) : "Belum ada persyaratan yang diisi.";
                                    echo substr($desk, 0, 90) . "..."; 
                                ?>
                            </p>

                            <div style="display: flex; gap: 10px;">
                                <a href="detail_lowongan.php?id=<?= $row['id_lowongan']; ?>" 
                                   class="btn-detail" 
                                   style="flex: 1; text-align: center; padding: 10px; border: 1px solid #2E8B47; color: #2E8B47; border-radius: 5px; text-decoration: none; font-weight: bold;">
                                   Detail
                                </a>

                                <a href="proses_lamar.php?id_lowongan=<?= $row['id_lowongan']; ?>" 
                                   class="btn-lamar"
                                   onclick="return confirm('Yakin ingin melamar?')"
                                   style="flex: 1; text-align: center; padding: 10px; background: #2E8B47; color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">
                                   Lamar
                                </a>
                            </div>
                        </div>

                    </div>
                    <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; color: #777;">
                    <h3>Belum ada lowongan yang tersedia.</h3>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php
require_once '../auth/auth_mahasiswa.php';
require_once '../templates/header_mahasiswa.php';

// --- LOGIKA PENCARIAN & FILTER ---
$keyword = "";
$lokasi_filter = "";
$where_clause = "WHERE l.status = 'dibuka'"; // Hanya tampilkan yang dibuka

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['search']);
    $where_clause .= " AND (l.judul_lowongan LIKE '%$keyword%' OR p.nama_perusahaan LIKE '%$keyword%')";
}

if (isset($_GET['lokasi']) && !empty($_GET['lokasi'])) {
    $lokasi_filter = mysqli_real_escape_string($conn, $_GET['lokasi']);
    $where_clause .= " AND l.lokasi LIKE '%$lokasi_filter%'";
}

// --- QUERY DATA LOWONGAN DARI DATABASE ---
// Menggabungkan tabel lowongan dengan perusahaan untuk dapat nama & logo
$query = "SELECT l.*, p.nama_perusahaan, p.foto 
          FROM lowongan l 
          JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan 
          $where_clause 
          ORDER BY l.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="<?= $base_url; ?>css/lowongan.css">

<div class="main-content">
    <div class="content-header">
        <h2>Cari Lowongan Magang</h2>
        <p>Temukan kesempatan magang yang sesuai dengan minat dan bakatmu.</p>
    </div>

    <div class="search-section">
        <form action="" method="GET" class="search-container">
            <input type="text" name="search" value="<?= htmlspecialchars($keyword); ?>" placeholder="Cari posisi atau perusahaan..." class="search-input">
            
            <select name="lokasi" class="filter-select">
                <option value="">Semua Lokasi</option>
                <option value="Jakarta" <?= $lokasi_filter == 'Jakarta' ? 'selected' : ''; ?>>Jakarta</option>
                <option value="Bandung" <?= $lokasi_filter == 'Bandung' ? 'selected' : ''; ?>>Bandung</option>
                <option value="Surabaya" <?= $lokasi_filter == 'Surabaya' ? 'selected' : ''; ?>>Surabaya</option>
                <option value="Padang" <?= $lokasi_filter == 'Padang' ? 'selected' : ''; ?>>Padang</option>
                <option value="Remote" <?= $lokasi_filter == 'Remote' ? 'selected' : ''; ?>>Remote</option>
            </select>
            
            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>

    <div class="job-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="job-card">
                    <div class="card-header">
                        <img src="<?= !empty($row['foto']) ? $base_url . 'img/profile_perusahaan/' . $row['foto'] : 'https://ui-avatars.com/api/?name=' . urlencode($row['nama_perusahaan']) . '&background=random'; ?>" 
                             alt="Logo" class="company-logo" 
                             style="object-fit: cover;">
                        
                        <span class="badge-type">Dibuka</span>
                    </div>
                    
                    <div class="card-body">
                        <h3 class="job-title"><?= htmlspecialchars($row['judul_lowongan']); ?></h3>
                        <p class="company-name"><?= htmlspecialchars($row['nama_perusahaan']); ?></p>
                        <p class="job-location">📍 <?= htmlspecialchars($row['lokasi']); ?></p>
                        
                        <div class="job-tags" style="margin-top: 10px; font-size: 13px; color: #666;">
                            📅 Deadline: <?= date('d M Y', strtotime($row['tanggal_selesai'])); ?>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <a href="detail_lowongan.php?id=<?= $row['id_lowongan']; ?>" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: #888; background: white; border-radius: 10px;">
                <p>Tidak ada lowongan ditemukan dengan kriteria tersebut.</p>
                <a href="lowongan.php" style="color: #2E8B47; text-decoration: none; font-weight: bold;">Reset Pencarian</a>
            </div>
        <?php endif; ?>
    </div>

    </div> </div> </body>
</html>
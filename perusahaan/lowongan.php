<?php
require_once '../auth/auth_perusahaan.php';
require_once '../templates/header_perusahaan.php';

// Simulasi Data (Nantinya data ini diambil dari Database)
$lowongan_dummy = [
    [
        'posisi' => 'Web Developer Intern',
        'perusahaan' => 'PT. Teknologi Maju',
        'lokasi' => 'Jakarta (Remote)',
        'gaji' => 'Paid',
        'logo' => 'https://ui-avatars.com/api/?name=TM&background=2E8B47&color=fff',
        'tags' => ['PHP', 'MySQL', 'Bootstrap']
    ],
    [
        'posisi' => 'UI/UX Designer',
        'perusahaan' => 'Creative Studio',
        'lokasi' => 'Bandung',
        'gaji' => 'Paid',
        'logo' => 'https://ui-avatars.com/api/?name=CS&background=FF7675&color=fff',
        'tags' => ['Figma', 'Prototyping']
    ],
    [
        'posisi' => 'Social Media Specialist',
        'perusahaan' => 'Startup Hub',
        'lokasi' => 'Surabaya',
        'gaji' => 'Unpaid',
        'logo' => 'https://ui-avatars.com/api/?name=SH&background=0984e3&color=fff',
        'tags' => ['Copywriting', 'Canva']
    ]
];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Lowongan Magang - MagangInAja</title>
    <link rel="stylesheet" href="<?= $base_url; ?>css/lowongan.css">
<div class="main-content">
    <div class="content-header">
        <h2>Cari Lowongan Magang</h2>
        <p>Temukan kesempatan magang yang sesuai dengan minat dan bakatmu.</p>
    </div>

    <div class="search-section">
        <form action="" method="GET" class="search-container">
            <input type="text" name="search" placeholder="Cari posisi atau perusahaan..." class="search-input">
            <select name="lokasi" class="filter-select">
                <option value="">Semua Lokasi</option>
                <option value="jakarta">Jakarta</option>
                <option value="remote">Remote</option>
            </select>
            <button type="submit" class="btn-search">Cari</button>
        </form>
    </div>

    <div class="job-grid">
        <?php foreach ($lowongan_dummy as $job) : ?>
            <div class="job-card">
                <div class="card-header">
                    <img src="<?= $job['logo']; ?>" alt="Logo" class="company-logo">
                    <span class="badge-type"><?= $job['gaji']; ?></span>
                </div>
                <div class="card-body">
                    <h3 class="job-title"><?= $job['posisi']; ?></h3>
                    <p class="company-name"><?= $job['perusahaan']; ?></p>
                    <p class="job-location">📍 <?= $job['lokasi']; ?></p>
                    <div class="job-tags">
                        <?php foreach ($job['tags'] as $tag) : ?>
                            <span class="tag"><?= $tag; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn-detail">Lihat Detail</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="footer">
        &copy; 2024 MagangInAja - Platform Magang Mahasiswa
    </footer>
</div>
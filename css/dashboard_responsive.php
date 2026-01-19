/* --- GLOBAL DASHBOARD STYLE --- */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7f6;
    overflow-x: hidden; /* Mencegah scroll horizontal */
}

/* Sidebar Desktop (Default) */
.sidebar {
    width: 250px;
    height: 100vh;
    background: #ffffff;
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 2px 0 10px rgba(0,0,0,0.05);
    z-index: 1000;
    transition: all 0.3s ease;
    padding-top: 20px;
    overflow-y: auto;
}

.sidebar h2 {
    text-align: center;
    color: #2E8B47;
    font-size: 22px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    padding: 0 20px;
    margin-bottom: 10px;
}

.sidebar ul li a {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 20px;
    text-decoration: none;
    color: #555;
    border-radius: 8px;
    transition: 0.3s;
    font-weight: 500;
}

.sidebar ul li a:hover, 
.sidebar ul li a.active {
    background: #e8f5e9;
    color: #2E8B47;
}

.sidebar ul li a i {
    width: 20px;
    text-align: center;
}

/* Main Content Desktop */
.main-content {
    margin-left: 250px; /* Memberi ruang untuk sidebar */
    padding: 30px;
    transition: all 0.3s ease;
}

/* Tombol Burger (Hidden di Desktop) */
.mobile-toggle {
    display: none;
    position: fixed;
    top: 15px;
    left: 20px;
    z-index: 1100;
    background: #2E8B47;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

/* --- TAMPILAN MOBILE (HP/Tablet) --- */
@media screen and (max-width: 768px) {
    
    /* Munculkan Tombol Burger */
    .mobile-toggle {
        display: block;
    }

    /* Sembunyikan Sidebar ke Kiri Layar */
    .sidebar {
        left: -260px; 
    }

    /* Class untuk Memunculkan Sidebar (via JS) */
    .sidebar.active {
        left: 0; 
        box-shadow: 5px 0 15px rgba(0,0,0,0.2);
    }

    /* Main Content Full Width */
    .main-content {
        margin-left: 0;
        padding: 20px;
        padding-top: 70px; /* Supaya konten tidak ketutup tombol burger */
    }

    /* Overlay Gelap saat Menu Terbuka (Opsional, efek bagus) */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 900;
    }

    .sidebar.active + .sidebar-overlay {
        display: block;
    }
}
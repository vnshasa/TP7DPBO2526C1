<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Mengatur karakter, skala layar, dan judul tab browser. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#173d34">
    <title>Perpustakaan Mini | Pengelolaan Koleksi</title>

    <!-- Memanggil CSS utama untuk seluruh halaman website. -->
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Layout utama membagi halaman menjadi sidebar dan area kerja. -->
    <div class="app-shell">
        <aside class="sidebar">
            <!-- Identitas aplikasi pada bagian atas sidebar. -->
            <a class="brand" href="index.php?page=beranda" aria-label="Perpustakaan Mini - Beranda">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 32 32" role="img">
                        <path d="M5.5 7.5c4.2-1.4 7.5-.7 10.5 1.6v16c-3-2.3-6.3-3-10.5-1.6z" />
                        <path d="M26.5 7.5C22.3 6.1 19 6.8 16 9.1v16c3-2.3 6.3-3 10.5-1.6z" />
                        <path d="M16 9.1v16" />
                    </svg>
                </span>
                <span class="brand-copy">
                    <strong>RuangBaca</strong>
                    <small>PERPUSTAKAAN MINI</small>
                </span>
            </a>

            <div class="sidebar-rule"></div>

            <!-- Navigasi utama menuju halaman CRUD setiap entitas. -->
            <p class="sidebar-label">MENU UTAMA</p>
            <nav class="side-navigation" aria-label="Navigasi utama">
                <!-- Beranda menjadi halaman pertama yang dibuka saat website diakses. -->
                <a href="index.php?page=beranda" class="side-link <?php echo $page === 'beranda' ? 'active' : ''; ?>">
                    <span class="nav-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="m3 10 9-7 9 7"/><path d="M5.5 9.5V21h13V9.5M9 21v-7h6v7"/></svg>
                    </span>
                    <span>Beranda</span>
                </a>
                <!-- Setiap menu data membuka halaman CRUD yang terpisah. -->
                <a href="index.php?page=buku" class="side-link <?php echo $page === 'buku' ? 'active' : ''; ?>">
                    <span class="nav-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21z"/><path d="M4 5.5v13A2.5 2.5 0 0 1 6.5 16H20M8 7h8M8 10h8"/></svg>
                    </span>
                    <span>Buku</span>
                    <span class="nav-count"><?php echo count($books); ?></span>
                </a>
                <a href="index.php?page=kategori" class="side-link <?php echo $page === 'kategori' ? 'active' : ''; ?>">
                    <span class="nav-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><rect x="4" y="4" width="6" height="6" rx="1.5"/><rect x="14" y="4" width="6" height="6" rx="1.5"/><rect x="4" y="14" width="6" height="6" rx="1.5"/><rect x="14" y="14" width="6" height="6" rx="1.5"/></svg>
                    </span>
                    <span>Kategori</span>
                    <span class="nav-count"><?php echo count($categories); ?></span>
                </a>
                <a href="index.php?page=penulis" class="side-link <?php echo $page === 'penulis' ? 'active' : ''; ?>">
                    <span class="nav-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20v-1.4a5.5 5.5 0 0 1 11 0V20zM16 5.2a3.2 3.2 0 0 1 0 6.2M17 14.8a5.4 5.4 0 0 1 3.5 5.2"/></svg>
                    </span>
                    <span>Penulis</span>
                    <span class="nav-count"><?php echo count($authors); ?></span>
                </a>
            </nav>

            <!-- Kartu kecil sebagai pengingat fungsi aplikasi. -->
            <div class="sidebar-note">
                <span class="note-spark" aria-hidden="true">✦</span>
                <p class="note-title">Ruang untuk ide hebat.</p>
                <p class="note-copy">Simpan dan kelola koleksi buku dengan lebih teratur.</p>
                <div class="note-books" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
            </div>

            <!-- Identitas praktikum pada bagian bawah sidebar. -->
            <div class="sidebar-bottom">
                <span class="sidebar-bottom-dot"></span>
                <span>DPBO · MODUL 08</span>
            </div>
        </aside>

        <div class="workspace">
            <!-- Header halaman berisi konteks aplikasi dan identitas pengguna. -->
            <header class="topbar">
                <div class="topbar-context">
                    <?php if ($page === 'beranda'): ?>
                        <p class="topbar-kicker">RUANGBACA · SISTEM PENGELOLAAN KOLEKSI</p>
                        <p class="topbar-location"><strong>Beranda</strong> <span>·</span> Ringkasan perpustakaan</p>
                    <?php else: ?>
                        <p class="topbar-kicker">MENU PENGELOLAAN DATA</p>
                        <p class="topbar-location"><a href="index.php?page=beranda">Beranda</a> <span>/</span> <strong><?php echo ucfirst($page); ?></strong></p>
                    <?php endif; ?>
                </div>
                <div class="profile-chip">
                    <span class="profile-avatar">RB</span>
                    <span class="profile-copy"><strong>RuangBaca</strong><small>Administrator</small></span>
                    <span class="profile-chevron">⌄</span>
                </div>
            </header>

            <!-- Pesan ditampilkan setelah proses tambah, ubah, atau hapus dilakukan. -->
            <?php if ($flash): ?>
                <div class="alert <?php echo !empty($flash['success']) ? 'success' : 'error'; ?>">
                    <span class="alert-mark" aria-hidden="true"><?php echo !empty($flash['success']) ? '✓' : '!'; ?></span>
                    <span><?php echo e($flash['message']); ?></span>
                </div>
            <?php endif; ?>

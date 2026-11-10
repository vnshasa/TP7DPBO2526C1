<main class="home-page">
    <!-- Beranda menjadi halaman pembuka yang merangkum isi perpustakaan. -->
    <section class="welcome-banner">
        <div class="welcome-copy">
            <span class="welcome-tag"><span></span> SELAMAT DATANG DI RUANG BACA</span>
            <h2>Setiap buku punya<br><em>cerita untuk disimpan.</em></h2>
            <p>Kelola koleksi bacaan, kelompok kategori, dan informasi penulis dalam satu tempat yang nyaman.</p>
            <a class="welcome-link" href="index.php?page=buku">Jelajahi koleksi <span aria-hidden="true">→</span></a>
        </div>
        <div class="welcome-art" aria-hidden="true">
            <div class="art-orbit orbit-one"></div>
            <div class="art-orbit orbit-two"></div>
            <div class="art-sun"></div>
            <div class="book-stack stack-back"><span></span></div>
            <div class="book-stack stack-middle"><span></span></div>
            <div class="book-stack stack-front"><span></span></div>
            <div class="art-leaf leaf-one"></div>
            <div class="art-leaf leaf-two"></div>
            <div class="art-caption">READ · GROW · REPEAT</div>
        </div>
    </section>

    <!-- Statistik diambil dari database agar selalu mengikuti jumlah data terbaru. -->
    <section class="stats-grid" aria-label="Ringkasan koleksi">
        <article class="stat-card stat-books">
            <span class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21z"/><path d="M4 5.5v13A2.5 2.5 0 0 1 6.5 16H20M8 7h8M8 10h8"/></svg>
            </span>
            <span class="stat-label">Total Buku</span>
            <strong class="stat-number"><?php echo count($books); ?></strong>
            <span class="stat-foot">Judul tersimpan</span>
        </article>
        <article class="stat-card stat-categories">
            <span class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><rect x="4" y="4" width="6" height="6" rx="1.5"/><rect x="14" y="4" width="6" height="6" rx="1.5"/><rect x="4" y="14" width="6" height="6" rx="1.5"/><rect x="14" y="14" width="6" height="6" rx="1.5"/></svg>
            </span>
            <span class="stat-label">Kategori</span>
            <strong class="stat-number"><?php echo count($categories); ?></strong>
            <span class="stat-foot">Kelompok koleksi</span>
        </article>
        <article class="stat-card stat-authors">
            <span class="stat-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20v-1.4a5.5 5.5 0 0 1 11 0V20zM16 5.2a3.2 3.2 0 0 1 0 6.2M17 14.8a5.4 5.4 0 0 1 3.5 5.2"/></svg>
            </span>
            <span class="stat-label">Penulis</span>
            <strong class="stat-number"><?php echo count($authors); ?></strong>
            <span class="stat-foot">Kontributor koleksi</span>
        </article>
    </section>

    <!-- Kartu pintasan membawa pengguna ke halaman CRUD masing-masing entitas. -->
    <section class="home-section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">MULAI MENJELAJAH</p>
                <h2>Kelola koleksi perpustakaan</h2>
                <p class="muted">Pilih bagian yang ingin kamu kelola. Setiap menu memiliki halaman tersendiri.</p>
            </div>
        </div>

        <div class="home-shortcuts">
            <a class="shortcut-card shortcut-book" href="index.php?page=buku">
                <span class="shortcut-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21z"/><path d="M4 5.5v13A2.5 2.5 0 0 1 6.5 16H20M8 7h8M8 10h8"/></svg></span>
                <span class="shortcut-count"><?php echo count($books); ?> data</span>
                <strong>Data Buku</strong>
                <span class="shortcut-description">Tambah, lihat, ubah, dan hapus koleksi buku.</span>
                <span class="shortcut-action">Buka halaman <b aria-hidden="true">→</b></span>
            </a>
            <a class="shortcut-card shortcut-category" href="index.php?page=kategori">
                <span class="shortcut-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="4" width="6" height="6" rx="1.5"/><rect x="14" y="4" width="6" height="6" rx="1.5"/><rect x="4" y="14" width="6" height="6" rx="1.5"/><rect x="14" y="14" width="6" height="6" rx="1.5"/></svg></span>
                <span class="shortcut-count"><?php echo count($categories); ?> data</span>
                <strong>Data Kategori</strong>
                <span class="shortcut-description">Atur kelompok atau jenis buku agar koleksi rapi.</span>
                <span class="shortcut-action">Buka halaman <b aria-hidden="true">→</b></span>
            </a>
            <a class="shortcut-card shortcut-author" href="index.php?page=penulis">
                <span class="shortcut-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20v-1.4a5.5 5.5 0 0 1 11 0V20zM16 5.2a3.2 3.2 0 0 1 0 6.2M17 14.8a5.4 5.4 0 0 1 3.5 5.2"/></svg></span>
                <span class="shortcut-count"><?php echo count($authors); ?> data</span>
                <strong>Data Penulis</strong>
                <span class="shortcut-description">Kelola nama dan informasi penulis buku.</span>
                <span class="shortcut-action">Buka halaman <b aria-hidden="true">→</b></span>
            </a>
        </div>
    </section>

    <!-- Ringkasan koleksi terbaru membantu pengguna melihat isi perpustakaan dari beranda. -->
    <section class="panel home-recent-panel">
        <div class="home-recent-heading">
            <div>
                <p class="eyebrow">KOLEKSI TERSIMPAN</p>
                <h2>Buku dalam perpustakaan</h2>
            </div>
            <a class="button secondary" href="index.php?page=buku">Lihat semua buku</a>
        </div>
        <?php if (count($books) > 0): ?>
            <div class="recent-book-list">
                <?php foreach ($books as $bookIndex => $book): ?>
                    <?php if ($bookIndex >= 4) { break; } ?>
                    <div class="recent-book-row">
                        <span class="recent-book-mark" aria-hidden="true">B</span>
                        <span class="recent-book-info">
                            <strong><?php echo e($book['judul']); ?></strong>
                            <small><?php echo e($book['nama_penulis']); ?> · <?php echo e($book['nama_kategori']); ?></small>
                        </span>
                        <span class="recent-book-year"><?php echo e($book['tahun_terbit']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="empty">Belum ada buku di dalam koleksi.</p>
        <?php endif; ?>
    </section>
</main>

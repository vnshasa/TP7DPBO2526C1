<main>
    <!-- Judul halaman dan jumlah buku yang tersimpan. -->
    <section class="section-heading">
        <div>
            <p class="eyebrow">DATA UTAMA</p>
            <h2>Data Buku</h2>
            <p class="muted">Data buku terhubung dengan kategori dan penulis.</p>
        </div>
        <span class="count-label"><?php echo count($books); ?> buku</span>
    </section>

    <!-- Buku tidak dapat dibuat sebelum tersedia kategori dan penulis. -->
    <section class="panel form-panel">
        <h3><?php echo $bukuEdit ? 'Ubah Buku' : 'Tambah Buku'; ?></h3>
        <?php if (count($categories) === 0 || count($authors) === 0): ?>
            <p class="notice">Tambahkan minimal satu kategori dan satu penulis terlebih dahulu agar buku dapat disimpan.</p>
        <?php endif; ?>

        <!-- Form mengirim data buku ke index.php untuk diproses class Buku. -->
        <form method="POST" action="index.php">
            <input type="hidden" name="entity" value="buku">
            <input type="hidden" name="action" value="<?php echo $bukuEdit ? 'update' : 'create'; ?>">

            <?php if ($bukuEdit): ?>
                <input type="hidden" name="id_buku" value="<?php echo e($bukuEdit['id_buku']); ?>">
            <?php endif; ?>

            <div class="form-grid">
                <!-- Judul menjadi identitas buku dan wajib diisi. -->
                <label>Judul buku
                    <input type="text" name="judul" required maxlength="150"
                           value="<?php echo e((isset($bukuEdit['judul']) ? $bukuEdit['judul'] : '')); ?>" placeholder="Masukkan judul buku">
                </label>

                <!-- Pilihan kategori berasal dari tabel kategori, bukan diketik manual. -->
                <label>Kategori
                    <select name="id_kategori" required>
                        <option value="">Pilih kategori</option>
                        <!-- Perulangan membuat option dari seluruh kategori yang tersedia. -->
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo e($category['id_kategori']); ?>"
                                <?php echo ($bukuEdit && $bukuEdit['id_kategori'] == $category['id_kategori']) ? 'selected' : ''; ?>>
                                <?php echo e($category['nama_kategori']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <!-- Pilihan penulis berasal dari tabel penulis. Nilai yang dikirim adalah ID penulis. -->
                <label>Penulis
                    <select name="id_penulis" required>
                        <option value="">Pilih penulis</option>
                        <!-- Perulangan membuat option dari seluruh penulis yang tersedia. -->
                        <?php foreach ($authors as $author): ?>
                            <option value="<?php echo e($author['id_penulis']); ?>"
                                <?php echo ($bukuEdit && $bukuEdit['id_penulis'] == $author['id_penulis']) ? 'selected' : ''; ?>>
                                <?php echo e($author['nama_penulis']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <!-- Tahun terbit dibatasi sesuai rentang tipe YEAR pada database MySQL. -->
                <label>Tahun terbit
                    <input type="number" name="tahun_terbit" min="1901" max="2155" required
                           value="<?php echo e((isset($bukuEdit['tahun_terbit']) ? $bukuEdit['tahun_terbit'] : '')); ?>" placeholder="Contoh: 2024">
                </label>

                <!-- Stok hanya menerima bilangan nol atau lebih. Pemeriksaan server juga dilakukan di index.php. -->
                <label>Stok
                    <input type="number" name="stok" min="0" required
                           value="<?php echo e((isset($bukuEdit['stok']) ? $bukuEdit['stok'] : '')); ?>" placeholder="Jumlah buku">
                </label>
            </div>

            <div class="form-actions">
                <!-- Tombol menyimpan buku baru atau perubahan data buku. -->
                <button type="submit" class="button primary"><?php echo $bukuEdit ? 'Simpan Perubahan' : 'Tambah Buku'; ?></button>
                <?php if ($bukuEdit): ?>
                    <a href="index.php?page=buku" class="button secondary">Batal</a>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <!-- Daftar buku menampilkan nama kategori dan penulis dari hasil JOIN. -->
    <section class="panel table-panel">
        <h3>Daftar Buku</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Judul</th><th>Kategori</th><th>Penulis</th>
                        <th>Tahun</th><th>Stok</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($books) > 0): ?>
                    <!-- Perulangan menampilkan setiap buku beserta kategori dan penulis hasil JOIN. -->
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo e($book['id_buku']); ?></td>
                            <td><?php echo e($book['judul']); ?></td>
                            <td><?php echo e($book['nama_kategori']); ?></td>
                            <td><?php echo e($book['nama_penulis']); ?></td>
                            <td><?php echo e($book['tahun_terbit']); ?></td>
                            <td><?php echo e($book['stok']); ?></td>
                            <td class="actions">
                                <!-- Link edit mengirim ID buku yang akan diubah. -->
                                <!-- Link Edit membawa ID buku untuk mengisi form dengan data lama. -->
                                <a class="button small secondary" href="index.php?page=buku&edit=<?php echo e($book['id_buku']); ?>">Edit</a>

                                <!-- Form hapus mengirim ID buku melalui POST. -->
                                <!-- Form Hapus mengirim ID buku kepada index.php melalui POST. -->
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="entity" value="buku">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_buku" value="<?php echo e($book['id_buku']); ?>">
                                    <button type="submit" class="button small danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="empty">Belum ada data buku.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

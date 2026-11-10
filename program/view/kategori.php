<main>
    <!-- Judul halaman dan jumlah data kategori yang tersedia. -->
    <section class="section-heading">
        <div>
            <p class="eyebrow">DATA MASTER</p>
            <h2>Data Kategori</h2>
            <p class="muted">Tambah, ubah, tampilkan, dan hapus kategori buku.</p>
        </div>
        <span class="count-label"><?php echo count($categories); ?> kategori</span>
    </section>

    <!-- Form digunakan untuk menambah kategori atau mengubah kategori yang dipilih. -->
    <section class="panel form-panel">
        <h3><?php echo $kategoriEdit ? 'Ubah Kategori' : 'Tambah Kategori'; ?></h3>
        <form method="POST" action="index.php">
            <!-- Hidden input memberi tahu index.php bahwa form ini untuk kategori. -->
            <input type="hidden" name="entity" value="kategori">
            <input type="hidden" name="action" value="<?php echo $kategoriEdit ? 'update' : 'create'; ?>">

            <!-- ID hanya dikirim jika pengguna sedang mengubah data. -->
            <?php if ($kategoriEdit): ?>
                <input type="hidden" name="id_kategori" value="<?php echo e($kategoriEdit['id_kategori']); ?>">
            <?php endif; ?>

            <div class="form-grid">
                <!-- Input nama kategori menjadi nilai utama yang disimpan ke tabel kategori. -->
                <label>Nama kategori
                    <input type="text" name="nama_kategori" required maxlength="100"
                           value="<?php echo e((isset($kategoriEdit['nama_kategori']) ? $kategoriEdit['nama_kategori'] : '')); ?>" placeholder="Contoh: Pemrograman">
                </label>
                <!-- Deskripsi bersifat opsional, sehingga tidak menggunakan atribut required. -->
                <label>Deskripsi
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat kategori"><?php echo e((isset($kategoriEdit['deskripsi']) ? $kategoriEdit['deskripsi'] : '')); ?></textarea>
                </label>
            </div>

            <div class="form-actions">
                <!-- Tombol mengirim form untuk proses tambah atau ubah sesuai nilai hidden action. -->
                <button type="submit" class="button primary"><?php echo $kategoriEdit ? 'Simpan Perubahan' : 'Tambah Kategori'; ?></button>
                <?php if ($kategoriEdit): ?>
                    <a href="index.php?page=kategori" class="button secondary">Batal</a>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <!-- Tabel menampilkan semua kategori yang diperoleh dari class Kategori. -->
    <section class="panel table-panel">
        <h3>Daftar Kategori</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama Kategori</th><th>Deskripsi</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if (count($categories) > 0): ?>
                    <!-- Perulangan menampilkan setiap kategori sebagai satu baris tabel. -->
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo e($category['id_kategori']); ?></td>
                            <td><?php echo e($category['nama_kategori']); ?></td>
                            <td><?php echo e($category['deskripsi']); ?></td>
                            <td class="actions">
                                <!-- Link edit mengirim ID kategori melalui parameter GET. -->
                                <!-- Tombol Edit membuka kembali form dengan data kategori terpilih. -->
                                <a class="button small secondary" href="index.php?page=kategori&edit=<?php echo e($category['id_kategori']); ?>">Edit</a>

                                <!-- Form hapus mengirim ID dengan metode POST. -->
                                <!-- Form ini mengirim ID kategori yang akan dihapus melalui POST. -->
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="entity" value="kategori">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_kategori" value="<?php echo e($category['id_kategori']); ?>">
                                    <button type="submit" class="button small danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="empty">Belum ada data kategori.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

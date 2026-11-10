<main>
    <!-- Judul halaman dan jumlah data penulis. -->
    <section class="section-heading">
        <div>
            <p class="eyebrow">DATA MASTER</p>
            <h2>Data Penulis</h2>
            <p class="muted">Kelola informasi penulis buku.</p>
        </div>
        <span class="count-label"><?php echo count($authors); ?> penulis</span>
    </section>

    <!-- Form digunakan untuk menambah penulis atau mengubah data penulis. -->
    <section class="panel form-panel">
        <h3><?php echo $penulisEdit ? 'Ubah Penulis' : 'Tambah Penulis'; ?></h3>
        <form method="POST" action="index.php">
            <input type="hidden" name="entity" value="penulis">
            <input type="hidden" name="action" value="<?php echo $penulisEdit ? 'update' : 'create'; ?>">

            <?php if ($penulisEdit): ?>
                <input type="hidden" name="id_penulis" value="<?php echo e($penulisEdit['id_penulis']); ?>">
            <?php endif; ?>

            <div class="form-grid two-columns">
                <!-- Nama penulis wajib diisi agar data penulis memiliki identitas. -->
                <label>Nama penulis
                    <input type="text" name="nama_penulis" required maxlength="100"
                           value="<?php echo e((isset($penulisEdit['nama_penulis']) ? $penulisEdit['nama_penulis'] : '')); ?>" placeholder="Nama lengkap penulis">
                </label>
                <!-- Negara bersifat opsional sebagai informasi tambahan penulis. -->
                <label>Negara
                    <input type="text" name="negara" maxlength="60"
                           value="<?php echo e((isset($penulisEdit['negara']) ? $penulisEdit['negara'] : '')); ?>" placeholder="Contoh: Indonesia">
                </label>
            </div>

            <div class="form-actions">
                <!-- Form memakai action create atau update sesuai kondisi form edit. -->
                <button type="submit" class="button primary"><?php echo $penulisEdit ? 'Simpan Perubahan' : 'Tambah Penulis'; ?></button>
                <?php if ($penulisEdit): ?>
                    <a href="index.php?page=penulis" class="button secondary">Batal</a>
                <?php endif; ?>
            </div>
        </form>
    </section>

    <!-- Tabel menampilkan semua data penulis. -->
    <section class="panel table-panel">
        <h3>Daftar Penulis</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>ID</th><th>Nama Penulis</th><th>Negara</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php if (count($authors) > 0): ?>
                    <!-- Setiap object data penulis ditampilkan pada baris tabel tersendiri. -->
                    <?php foreach ($authors as $author): ?>
                        <tr>
                            <td><?php echo e($author['id_penulis']); ?></td>
                            <td><?php echo e($author['nama_penulis']); ?></td>
                            <td><?php echo e($author['negara']); ?></td>
                            <td class="actions">
                                <!-- Link edit membawa ID penulis yang dipilih. -->
                                <!-- Link Edit mengirim ID penulis agar datanya dimuat ke form. -->
                                <a class="button small secondary" href="index.php?page=penulis&edit=<?php echo e($author['id_penulis']); ?>">Edit</a>

                                <!-- Form hapus mengirim ID penulis melalui POST. -->
                                <!-- Form Hapus mengirim ID penulis melalui method POST. -->
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="entity" value="penulis">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_penulis" value="<?php echo e($author['id_penulis']); ?>">
                                    <button type="submit" class="button small danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="empty">Belum ada data penulis.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

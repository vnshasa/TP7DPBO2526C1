<?php

// Memanggil class koneksi, fungsi bantuan, dan tiga class yang mengelola tabel.
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/helper.php';
require_once __DIR__ . '/class/Kategori.php';
require_once __DIR__ . '/class/Penulis.php';
require_once __DIR__ . '/class/Buku.php';

// Membuat object Database dan mengambil koneksi PDO.
try {
    $database = new Database();
    $db = $database->getConnection();
} catch (PDOException $error) {
    // Pesan dibuat sederhana agar pengguna tahu langkah yang harus diperiksa.
    die(
        '<h2>Koneksi database gagal.</h2>' .
        '<p>Pastikan MySQL aktif dan database db_perpustakaan sudah dibuat.</p>' .
        '<p>Import database/db_perpustakaan.sql, lalu periksa config/database.php.</p>'
    );
}

// Membuat object pengelola untuk setiap entitas/tabel.
// Setiap object menerima koneksi PDO yang sama.
$kategoriModel = new Kategori($db);
$penulisModel = new Penulis($db);
$bukuModel = new Buku($db);

// Memeriksa apakah halaman menerima data dari form (request POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil nama entitas dan aksi dari hidden input pada form.
    $entity = postText('entity');
    $action = postText('action');

    // Nilai awal pesan dianggap gagal sampai proses berhasil dijalankan.
    $message = 'Permintaan tidak dikenali.';
    $success = false;

    try {
        // ------------------------- CRUD KATEGORI -------------------------
        if ($entity === 'kategori') {
            if ($action === 'create') {
                // Mengambil data kategori dari form.
                $nama = postText('nama_kategori');
                $deskripsi = postText('deskripsi');

                // Nama kategori wajib diisi.
                if ($nama === '') {
                    throw new Exception('Nama kategori wajib diisi.');
                }

                // Memanggil method create() pada object Kategori.
                $kategoriModel->create($nama, $deskripsi);
                $message = 'Kategori berhasil ditambahkan.';
                $success = true;

            } elseif ($action === 'update') {
                // ID dipastikan berbentuk bilangan bulat.
                $id = postInteger('id_kategori');
                $nama = postText('nama_kategori');
                $deskripsi = postText('deskripsi');

                if ($nama === '') {
                    throw new Exception('Nama kategori wajib diisi.');
                }

                // Memastikan ID valid dan datanya benar-benar tersedia.
                if ($id === false || $id <= 0 || !$kategoriModel->getById($id)) {
                    throw new Exception('Kategori yang akan diubah tidak ditemukan.');
                }

                $kategoriModel->update($id, $nama, $deskripsi);
                $message = 'Kategori berhasil diperbarui.';
                $success = true;

            } elseif ($action === 'delete') {
                $id = postInteger('id_kategori');

                // Tidak menghapus jika ID tidak valid atau tidak ditemukan.
                if ($id === false || $id <= 0 || !$kategoriModel->getById($id)) {
                    throw new Exception('Kategori yang akan dihapus tidak ditemukan.');
                }

                // Database akan menolak penghapusan jika kategori masih dipakai buku.
                $kategoriModel->delete($id);
                $message = 'Kategori berhasil dihapus.';
                $success = true;
            } else {
                throw new Exception('Aksi kategori tidak dikenali.');
            }

        // -------------------------- CRUD PENULIS -------------------------
        } elseif ($entity === 'penulis') {
            if ($action === 'create') {
                $nama = postText('nama_penulis');
                $negara = postText('negara');

                if ($nama === '') {
                    throw new Exception('Nama penulis wajib diisi.');
                }

                $penulisModel->create($nama, $negara);
                $message = 'Penulis berhasil ditambahkan.';
                $success = true;

            } elseif ($action === 'update') {
                $id = postInteger('id_penulis');
                $nama = postText('nama_penulis');
                $negara = postText('negara');

                if ($nama === '') {
                    throw new Exception('Nama penulis wajib diisi.');
                }

                if ($id === false || $id <= 0 || !$penulisModel->getById($id)) {
                    throw new Exception('Penulis yang akan diubah tidak ditemukan.');
                }

                $penulisModel->update($id, $nama, $negara);
                $message = 'Penulis berhasil diperbarui.';
                $success = true;

            } elseif ($action === 'delete') {
                $id = postInteger('id_penulis');

                if ($id === false || $id <= 0 || !$penulisModel->getById($id)) {
                    throw new Exception('Penulis yang akan dihapus tidak ditemukan.');
                }

                // Penghapusan ditolak database jika penulis masih terhubung ke buku.
                $penulisModel->delete($id);
                $message = 'Penulis berhasil dihapus.';
                $success = true;
            } else {
                throw new Exception('Aksi penulis tidak dikenali.');
            }

        // --------------------------- CRUD BUKU ---------------------------
        } elseif ($entity === 'buku') {
            if ($action === 'create' || $action === 'update') {
                // Mengambil seluruh nilai yang diperlukan untuk data buku.
                $judul = postText('judul');
                $idKategori = postInteger('id_kategori');
                $idPenulis = postInteger('id_penulis');
                $tahun = postInteger('tahun_terbit');
                $stok = postInteger('stok');

                // Memeriksa input wajib dan memastikan tahun serta stok berupa integer.
                if (
                    $judul === '' ||
                    $idKategori === false ||
                    $idPenulis === false ||
                    $tahun === false ||
                    $stok === false
                ) {
                    throw new Exception('Lengkapi seluruh data buku dengan benar.');
                }

                // Tahun disesuaikan dengan rentang tipe YEAR pada MySQL.
                // Stok tidak boleh negatif.
                if ($tahun < 1901 || $tahun > 2155 || $stok < 0) {
                    throw new Exception('Tahun terbit harus antara 1901–2155 dan stok tidak boleh kurang dari 0.');
                }

                // Memastikan kategori dan penulis yang dipilih memang tersedia.
                if (!$kategoriModel->getById($idKategori)) {
                    throw new Exception('Kategori yang dipilih tidak ditemukan.');
                }
                if (!$penulisModel->getById($idPenulis)) {
                    throw new Exception('Penulis yang dipilih tidak ditemukan.');
                }

                if ($action === 'create') {
                    $bukuModel->create($judul, $idKategori, $idPenulis, $tahun, $stok);
                    $message = 'Buku berhasil ditambahkan.';
                } else {
                    // Saat update, pastikan ID buku yang diedit tersedia.
                    $id = postInteger('id_buku');
                    if ($id === false || $id <= 0 || !$bukuModel->getById($id)) {
                        throw new Exception('Buku yang akan diubah tidak ditemukan.');
                    }

                    $bukuModel->update($id, $judul, $idKategori, $idPenulis, $tahun, $stok);
                    $message = 'Buku berhasil diperbarui.';
                }

                $success = true;

            } elseif ($action === 'delete') {
                $id = postInteger('id_buku');

                if ($id === false || $id <= 0 || !$bukuModel->getById($id)) {
                    throw new Exception('Buku yang akan dihapus tidak ditemukan.');
                }

                $bukuModel->delete($id);
                $message = 'Buku berhasil dihapus.';
                $success = true;
            } else {
                throw new Exception('Aksi buku tidak dikenali.');
            }

        } else {
            // Menolak request yang menyebut entitas di luar tiga tabel aplikasi.
            throw new Exception('Entitas data tidak dikenali.');
        }

    } catch (PDOException $error) {
        // SQLSTATE 23000 umumnya menunjukkan pelanggaran aturan relasi/constraint.
        if ($error->getCode() === '23000') {
            $message = 'Data tidak dapat dihapus atau disimpan karena masih berhubungan dengan data lain. Periksa relasi Kategori, Penulis, dan Buku.';
        } else {
            $message = 'Terjadi kesalahan saat mengakses database. Periksa data dan koneksi database.';
        }
        $success = false;

    } catch (Exception $error) {
        // Pesan validasi dari program ditampilkan kembali kepada pengguna.
        $message = $error->getMessage();
        $success = false;
    }

    // Menentukan halaman tujuan berdasarkan entitas yang sedang diproses.
    if (in_array($entity, ['kategori', 'penulis', 'buku'], true)) {
        $redirectPage = $entity;
    } else {
        $redirectPage = 'buku';
    }

    // Redirect mencegah form terkirim ulang saat halaman di-refresh.
    // Pesan di-URL-encode, kemudian akan ditampilkan dengan fungsi e().
    $status = $success ? 'success' : 'error';
    header('Location: index.php?page=' . $redirectPage . '&status=' . $status . '&message=' . urlencode($message));
    exit;
}

// ------------------------- MENAMPILKAN HALAMAN -------------------------

// Menentukan halaman yang diminta melalui parameter GET.
$page = isset($_GET['page']) && is_string($_GET['page']) ? $_GET['page'] : 'beranda';

// Hanya halaman yang tersedia pada navigasi aplikasi yang boleh dibuka.
if (!in_array($page, ['beranda', 'kategori', 'penulis', 'buku'], true)) {
    $page = 'beranda';
}

// Menyiapkan pesan hasil proses jika ada parameter message dari redirect.
$flash = null;
if (isset($_GET['message']) && is_string($_GET['message'])) {
    $flash = [
        'message' => $_GET['message'],
        'success' => isset($_GET['status']) && $_GET['status'] === 'success'
    ];
}

// Nilai awal data edit adalah null, artinya form digunakan untuk tambah data.
$kategoriEdit = null;
$penulisEdit = null;
$bukuEdit = null;

// Mengambil data ketiga entitas untuk statistik Beranda dan angka pada navigasi sidebar.
$categories = $kategoriModel->getAll();
$authors = $penulisModel->getAll();
$books = $bukuModel->getAll();

// Jika pengguna memilih tombol Edit, ambil satu data berdasarkan ID-nya.
// Data ini akan digunakan untuk mengisi form dengan nilai yang lama.
if (isset($_GET['edit'])) {
    $editId = filter_var($_GET['edit'], FILTER_VALIDATE_INT);

    if ($editId !== false && $editId > 0) {
        if ($page === 'kategori') {
            $kategoriEdit = $kategoriModel->getById($editId);
        } elseif ($page === 'penulis') {
            $penulisEdit = $penulisModel->getById($editId);
        } elseif ($page === 'buku') {
            $bukuEdit = $bukuModel->getById($editId);
        }
    }
}

// Memanggil bagian tampilan. Header dan footer dipakai bersama oleh semua halaman.
require __DIR__ . '/view/header.php';

// Memilih file view berdasarkan halaman yang sedang aktif.
if ($page === 'beranda') {
    require __DIR__ . '/view/beranda.php';
} elseif ($page === 'kategori') {
    require __DIR__ . '/view/kategori.php';
} elseif ($page === 'penulis') {
    require __DIR__ . '/view/penulis.php';
} else {
    require __DIR__ . '/view/buku.php';
}

// Footer ditampilkan setelah isi halaman selesai dimuat.
require __DIR__ . '/view/footer.php';

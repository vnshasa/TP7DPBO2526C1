<?php

// Class Kategori mengelola data pada tabel kategori.
class Kategori
{
    // Koneksi disimpan sebagai private agar tidak diubah langsung dari luar class.
    private $db;

    // Constructor menerima koneksi PDO dari index.php.
    public function __construct($db)
    {
        $this->db = $db;
    }

    // READ: mengambil seluruh kategori untuk ditampilkan pada tabel.
    public function getAll()
    {
        // Query disiapkan terlebih dahulu menggunakan prepared statement.
        $stmt = $this->db->prepare('SELECT * FROM kategori ORDER BY id_kategori DESC');

        // Menjalankan query yang sudah disiapkan.
        $stmt->execute();

        // Mengambil semua baris hasil query sebagai array.
        return $stmt->fetchAll();
    }

    // READ: mengambil satu kategori berdasarkan ID.
    public function getById($id)
    {
        // Tanda tanya (?) menjadi tempat untuk nilai ID yang dikirim terpisah.
        $stmt = $this->db->prepare('SELECT * FROM kategori WHERE id_kategori = ?');
        $stmt->execute([$id]);

        // fetch() mengambil satu baris; hasilnya false jika data tidak ditemukan.
        return $stmt->fetch();
    }

    // CREATE: menambahkan kategori baru ke tabel kategori.
    public function create($nama, $deskripsi)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)'
        );

        // Nilai input dimasukkan melalui execute(), bukan digabung ke teks SQL.
        return $stmt->execute([$nama, $deskripsi]);
    }

    // UPDATE: mengubah nama dan deskripsi kategori berdasarkan ID.
    public function update($id, $nama, $deskripsi)
    {
        $stmt = $this->db->prepare(
            'UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id_kategori = ?'
        );

        return $stmt->execute([$nama, $deskripsi, $id]);
    }

    // DELETE: menghapus satu kategori berdasarkan ID.
    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM kategori WHERE id_kategori = ?');
        return $stmt->execute([$id]);
    }
}

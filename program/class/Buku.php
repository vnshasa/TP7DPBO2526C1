<?php

// Class Buku mengelola data pada tabel buku.
// Tabel buku mempunyai relasi foreign key ke tabel kategori dan penulis.
class Buku
{
    // Koneksi PDO disimpan secara private agar akses database melalui method class.
    private $db;

    // Constructor menerima koneksi PDO dari index.php.
    public function __construct($db)
    {
        $this->db = $db;
    }

    // READ: mengambil buku beserta nama kategori dan nama penulisnya.
    public function getAll()
    {
        // JOIN menghubungkan tabel buku dengan kategori dan penulis.
        // Relasi JOIN menggunakan kolom foreign key yang ada di tabel buku.
        $sql = 'SELECT buku.*, kategori.nama_kategori, penulis.nama_penulis
                FROM buku
                INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori
                INNER JOIN penulis ON buku.id_penulis = penulis.id_penulis
                ORDER BY buku.id_buku DESC';

        // Query tetap dijalankan menggunakan prepared statement.
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // READ: mengambil satu buku berdasarkan ID untuk proses edit.
    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM buku WHERE id_buku = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // CREATE: menambahkan buku dan menghubungkannya ke kategori serta penulis.
    public function create($judul, $idKategori, $idPenulis, $tahun, $stok)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO buku (judul, id_kategori, id_penulis, tahun_terbit, stok)
             VALUES (?, ?, ?, ?, ?)'
        );

        return $stmt->execute([$judul, $idKategori, $idPenulis, $tahun, $stok]);
    }

    // UPDATE: mengubah data buku berdasarkan ID buku.
    public function update($id, $judul, $idKategori, $idPenulis, $tahun, $stok)
    {
        $stmt = $this->db->prepare(
            'UPDATE buku
             SET judul = ?, id_kategori = ?, id_penulis = ?, tahun_terbit = ?, stok = ?
             WHERE id_buku = ?'
        );

        return $stmt->execute([$judul, $idKategori, $idPenulis, $tahun, $stok, $id]);
    }

    // DELETE: menghapus buku berdasarkan ID.
    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM buku WHERE id_buku = ?');
        return $stmt->execute([$id]);
    }
}

<?php

// Class Penulis mengelola data pada tabel penulis.
class Penulis
{
    // Atribut koneksi dibuat private untuk menerapkan encapsulation.
    private $db;

    // Constructor menerima koneksi PDO yang dibuat oleh class Database.
    public function __construct($db)
    {
        $this->db = $db;
    }

    // READ: mengambil seluruh data penulis.
    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM penulis ORDER BY id_penulis DESC');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // READ: mencari satu penulis berdasarkan ID.
    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM penulis WHERE id_penulis = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // CREATE: menyimpan penulis baru.
    public function create($nama, $negara)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO penulis (nama_penulis, negara) VALUES (?, ?)'
        );
        return $stmt->execute([$nama, $negara]);
    }

    // UPDATE: mengubah nama dan negara penulis berdasarkan ID.
    public function update($id, $nama, $negara)
    {
        $stmt = $this->db->prepare(
            'UPDATE penulis SET nama_penulis = ?, negara = ? WHERE id_penulis = ?'
        );
        return $stmt->execute([$nama, $negara, $id]);
    }

    // DELETE: menghapus penulis berdasarkan ID.
    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM penulis WHERE id_penulis = ?');
        return $stmt->execute([$id]);
    }
}

<?php

// Class Database bertugas membuat dan menyediakan koneksi ke database MySQL.
// Dengan memisahkan koneksi ke dalam class, file lain tidak perlu menulis
// konfigurasi database berulang kali.
class Database
{
    // Atribut private hanya dapat diakses dari dalam class Database.
    // Nilai berikut adalah konfigurasi awal untuk XAMPP/Laragon.
    private $host = 'localhost';
    private $dbname = 'db_perpustakaan';
    private $username = 'root';
    private $password = '';

    // Atribut ini menyimpan object koneksi PDO setelah koneksi berhasil dibuat.
    private $connection;

    // Constructor dijalankan otomatis ketika object Database dibuat.
    public function __construct()
    {
        // DSN berisi jenis database, alamat server, nama database, dan charset.
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';

        // Membuat koneksi PDO menggunakan konfigurasi di atas.
        $this->connection = new PDO($dsn, $this->username, $this->password);

        // Jika query mengalami kesalahan, PDO akan memberikan exception.
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Hasil query SELECT dikembalikan sebagai array dengan nama kolom sebagai key.
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Meminta PDO menggunakan prepared statement asli dari database MySQL.
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    // Method ini memberikan koneksi PDO kepada class lain yang membutuhkannya.
    public function getConnection()
    {
        return $this->connection;
    }
}

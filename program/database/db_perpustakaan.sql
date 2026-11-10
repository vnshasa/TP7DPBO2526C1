-- ================================================================
-- DATABASE: db_perpustakaan
-- Project: Perpustakaan Mini - Praktikum DPBO Modul 8
--
-- PERHATIAN:
-- Script ini menghapus tabel dengan nama yang sama sebelum membuat ulang.
-- Import ulang akan menghapus data lama pada tabel tersebut.
-- ================================================================

-- Membuat database jika belum tersedia.
CREATE DATABASE IF NOT EXISTS db_perpustakaan
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Memilih database yang akan digunakan.
USE db_perpustakaan;

-- Hapus tabel anak terlebih dahulu agar foreign key tidak menghalangi.
DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS penulis;

-- Tabel kategori menyimpan kelompok atau jenis buku.
CREATE TABLE kategori (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT
) ENGINE=InnoDB;

-- Tabel penulis menyimpan informasi penulis buku.
CREATE TABLE penulis (
    id_penulis INT AUTO_INCREMENT PRIMARY KEY,
    nama_penulis VARCHAR(100) NOT NULL,
    negara VARCHAR(60)
) ENGINE=InnoDB;

-- Tabel buku menyimpan data utama dan menghubungkannya ke kategori serta penulis.
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT NOT NULL,
    id_penulis INT NOT NULL,
    judul VARCHAR(150) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    stok INT NOT NULL DEFAULT 0,

    -- Foreign key menghubungkan buku dengan kategori.
    CONSTRAINT fk_buku_kategori
        FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori)
        ON UPDATE CASCADE ON DELETE RESTRICT,

    -- Foreign key menghubungkan buku dengan penulis.
    CONSTRAINT fk_buku_penulis
        FOREIGN KEY (id_penulis) REFERENCES penulis(id_penulis)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Data awal kategori untuk contoh penggunaan website.
INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Pemrograman', 'Buku tentang bahasa pemrograman dan pengembangan perangkat lunak.'),
('Novel', 'Buku cerita fiksi dan sastra.'),
('Sains', 'Buku ilmu pengetahuan dan teknologi.');

-- Data awal penulis untuk contoh penggunaan website.
INSERT INTO penulis (nama_penulis, negara) VALUES
('Budi Raharjo', 'Indonesia'),
('Andrea Hirata', 'Indonesia'),
('Stephen Hawking', 'Britania Raya');

-- Data awal buku. ID kategori dan penulis mengikuti data yang dimasukkan di atas.
INSERT INTO buku (id_kategori, id_penulis, judul, tahun_terbit, stok) VALUES
(1, 1, 'Belajar Pemrograman Web', 2022, 8),
(2, 2, 'Laskar Pelangi', 2005, 5),
(3, 3, 'A Brief History of Time', 1988, 3),
(1, 1, 'Dasar-Dasar Pemrograman', 2021, 6);

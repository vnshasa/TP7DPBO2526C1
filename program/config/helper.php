<?php

// Fungsi e() digunakan saat menampilkan data ke HTML.
// htmlspecialchars mencegah isi data dianggap sebagai tag atau script HTML.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Fungsi ini mengambil input POST hanya jika nilainya berupa teks.
// Pemeriksaan is_string mencegah error apabila request mengirim bentuk data lain.
function postText($name)
{
    if (!isset($_POST[$name]) || !is_string($_POST[$name])) {
        return '';
    }

    // trim menghapus spasi di bagian awal dan akhir input.
    return trim($_POST[$name]);
}

// Fungsi ini mengubah input menjadi bilangan bulat.
// Nilai false berarti input kosong atau bukan bilangan bulat yang valid.
function postInteger($name)
{
    $value = postText($name);

    if ($value === '') {
        return false;
    }

    return filter_var($value, FILTER_VALIDATE_INT);
}

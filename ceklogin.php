<?php
require 'function.php';

if (isset($_SESSION['login'])) {
    // Sudah login, Anda mungkin perlu verifikasi level di sini
    // jika diperlukan.
    if (isset($_SESSION['level'])) {
        // Jika level pengguna adalah admin atau kasir
        if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'kasir') {
            // Pengguna memiliki hak akses yang sesuai, lanjutkan
            // Tidak perlu tindakan tambahan di sini
        } else {
            // Jika level pengguna tidak valid, arahkan pengguna ke halaman login
            header('location:login.php');
            exit(); // Pastikan untuk keluar dari skrip setelah pengalihan header
        }
    } else {
        // Jika level pengguna tidak ada dalam sesi, arahkan pengguna ke halaman login
        header('location:login.php');
        exit(); // Pastikan untuk keluar dari skrip setelah pengalihan header
    }
} else {
    // belum login
    header('location:login.php');
    exit(); // Pastikan untuk keluar dari skrip setelah pengalihan header
}
?>
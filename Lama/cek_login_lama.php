<?php
require 'function.php';

if (isset($_SESSION['login'])) {
    // Sudah login, Anda mungkin perlu verifikasi level di sini
    // jika diperlukan.
} else {
    // belum login
    header('location:login.php');
    exit(); // Pastikan untuk keluar dari skrip setelah pengalihan header
}
?>

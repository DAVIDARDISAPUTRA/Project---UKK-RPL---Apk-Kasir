<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    // Jika pengguna mengkonfirmasi logout
    session_destroy();
    header('location:login.php');
    exit; // Pastikan untuk keluar setelah redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>

<script>
// Fungsi untuk menampilkan pop-up konfirmasi saat logout
function confirmLogout() {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        // Jika pengguna mengkonfirmasi logout, kirimkan form
        document.getElementById('logoutForm').submit();
    } else {
        // Jika pengguna membatalkan logout, arahkan kembali ke halaman index.php
        window.location.href = 'index.php';
    }
}
</script>

<!-- Form untuk logout -->
<form id="logoutForm" method="post">
    <!-- Input tersembunyi untuk mengirimkan permintaan logout -->
    <input type="hidden" name="logout" value="1">
</form>

<!-- Panggil fungsi confirmLogout saat halaman dimuat -->
<script>
    confirmLogout();
</script>

</body>
</html>

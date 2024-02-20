<?php
require 'ceklogin.php';
require 'sidebar.php';

// Pastikan id_penjualan tersedia dalam parameter GET
// Pastikan id_penjualan tersedia dalam parameter GET
if (isset($_GET['id_penjualan'])) {
    $idp = $_GET['id_penjualan'];

    // Ambil informasi pesanan dari database
    $ambilnamapelanggan = mysqli_query($koneksi, "SELECT * FROM penjualan p, pelanggan pl where p.id_pelanggan=pl.id_pelanggan AND p.id_penjualan ='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['nama_pelanggan'];

    // Query untuk mengambil detail pesanan
    $query_detail_pesanan = "SELECT * FROM detailpenjualan p 
                            JOIN produk pr ON p.id_produk = pr.id_produk
                            WHERE p.id_penjualan='$idp'";
    $result_detail_pesanan = mysqli_query($koneksi, $query_detail_pesanan);
} else {
    // Redirect jika id_penjualan tidak tersedia
    header('location:index.php');
    exit; // Pastikan kode setelah redirect tidak dijalankan
}

// Proses pembayaran jika form pembayaran telah dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nominal_pembayaran'])) {
    // Ambil nilai nominal pembayaran dari form
    $nominal_pembayaran = $_POST['nominal_pembayaran'];

    // Simpan nilai nominal pembayaran ke sesi
    $_SESSION['nominal_pembayaran'] = $nominal_pembayaran;

    // Hitung total pembelian dari database
    $query_total_pembelian = "SELECT total_harga FROM penjualan WHERE id_penjualan='$idp'";
    $result_total_pembelian = mysqli_query($koneksi, $query_total_pembelian);
    $total_pembelian = mysqli_fetch_assoc($result_total_pembelian)['total_harga'];

    // Hitung kembalian
    $kembalian = $nominal_pembayaran - $total_pembelian;

    // Simpan nilai kembalian ke sesi
    $_SESSION['kembalian'] = $kembalian;

    // Jika nominal pembayaran kurang dari total pembelian, berikan pesan kesalahan
    if ($nominal_pembayaran < $total_pembelian) {
        $error_message = "Nominal pembayaran tidak mencukupi!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-bg-danger">Checkout</h1>
                    <h4 class="mt-4">Nama Pelanggan : <?php echo $namapel; ?> </h4>
                    <ol class="breadcrumb mb-4">

                    </ol>
                    <!-- Tampilkan tabel pesanan -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Detail Pesanan
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_pembelian = 0;
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result_detail_pesanan)) {
                                        $nama_produk = $row['nama_produk'];
                                        $jumlah_produk = $row['jumlah_produk'];
                                        $harga = $row['harga'];
                                        $subtotal = $row['subtotal'];
                                        $total_pembelian += $subtotal;
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $nama_produk; ?></td>
                                            <td><?php echo $jumlah_produk; ?></td>
                                            <td><?php echo 'Rp. ' . number_format($harga, 0, ',', '.'); ?></td>
                                            <td><?php echo 'Rp. ' . number_format($subtotal, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4"><strong>Total Pembelian</strong></td>
                                        <td><?php echo 'Rp. ' . number_format($total_pembelian, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form untuk pembayaran -->
                    <form action="checkout.php?id_penjualan=<?php echo $idp; ?>" method="POST">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-money-bill-alt me-1"></i>
                                Pembayaran
                            </div>
                            <div class="card-body">
                                <?php if (isset($error_message)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="nominal_pembayaran">Nominal Pembayaran</label>
                                    <input type="number" id="nominal_pembayaran" name="nominal_pembayaran" class="form-control" min="<?php echo $total_pembelian; ?>" required value="<?php if (isset($nominal_pembayaran)) echo $nominal_pembayaran; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="kembalian">Kembalian</label>
                                    <input type="text" id="kembalian" name="kembalian" class="form-control" readonly value="<?php if (isset($kembalian)) echo 'Rp. ' . number_format($kembalian, 0, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
                                <a href="print.php?id_penjualan=<?php echo $idp; ?>&nominal_pembayaran=<?php echo $nominal_pembayaran; ?>" class="btn btn-info">Cetak Struk</a>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
            <?php
            require 'footer.php';
            ?>
        </div>
    </div>
</body>

</html>

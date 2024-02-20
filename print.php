<?php
if (isset($_GET['id_penjualan'])) {
    $idp = $_GET['id_penjualan'];

    include "function.php";

    // Ambil nama pelanggan
    $query_pelanggan = mysqli_query($koneksi, "SELECT nama_pelanggan FROM pelanggan pl
                                    JOIN penjualan p ON pl.id_pelanggan = p.id_pelanggan
                                    WHERE p.id_penjualan='$idp'");
    $nama_pelanggan = mysqli_fetch_assoc($query_pelanggan)['nama_pelanggan'];
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <!-- <title>Aplikasi Kasir</title> -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/jpg" href="assets/img/icon6.png">
    </head>

    <body>
        <h4 style="text-align: center;">Struk</h4>
        <div style="margin: 20px auto; width: 80%;">
            <p>Nama Pelanggan: <?php echo $nama_pelanggan; ?></p>
            <table border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="padding: 8px;">No</th>
                        <th style="padding: 8px;">Nama Produk</th>
                        <th style="padding: 8px;">Qty</th>
                        <th style="padding: 8px;">Harga</th>
                        <th style="padding: 8px;">Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_pembelian = 0;
                    $get = mysqli_query($koneksi, "SELECT * FROM detailpenjualan p 
                                    JOIN produk pr ON p.id_produk = pr.id_produk
                                    JOIN penjualan pl ON p.id_penjualan = pl.id_penjualan
                                    JOIN pelanggan pel ON pl.id_pelanggan = pel.id_pelanggan
                                    WHERE p.id_penjualan='$idp'");

                    $i = 1;

                    while ($ap = mysqli_fetch_array($get)) {
                        $idpr = $ap['id_produk'];
                        $iddetail = $ap['id_detail'];
                        $idp = $ap['id_penjualan'];
                        $nama_produk = $ap['nama_produk'];
                        $jumlah_produk = $ap['jumlah_produk'];
                        $harga = $ap['harga'];
                        $subtotal = $jumlah_produk * $harga;
                        $total_pembelian += $subtotal;
                    ?>
                        <tr>
                            <td style="padding: 8px;"><?php echo $i++; ?></td>
                            <td style="padding: 8px;"><?php echo $nama_produk; ?></td>
                            <td style="padding: 8px;"><?php echo $jumlah_produk; ?></td>
                            <td style="padding: 8px;"><?php echo 'Rp. ' . number_format($harga, 0, ',', '.'); ?></td>
                            <td style="padding: 8px;"><?php echo 'Rp. ' . number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php
                    }; ?>
                    <tr>
                        <td colspan="4" style="text-align: left; padding: 8px;"><strong>Total Pembelian</strong></td>
                        <td style="padding: 8px;"><?php echo 'Rp. ' . number_format($total_pembelian, 0, ',', '.'); ?></td>
                    </tr>
                    <!-- Tambahkan baris untuk menampilkan nominal pembayaran dan kembalian -->
                    <tr>
                        <td colspan="4" style="text-align: left; padding: 8px;"><strong>Nominal Pembayaran</strong></td>
                        <td style="padding: 8px;">
                            <?php echo isset($_SESSION['nominal_pembayaran']) ? 'Rp. ' . number_format($_SESSION['nominal_pembayaran'], 0, ',', '.') : ''; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: left; padding: 8px;"><strong>Kembalian</strong></td>
                        <td style="padding: 8px;">
                            <?php echo isset($_SESSION['kembalian']) ? 'Rp. ' . number_format($_SESSION['kembalian'], 0, ',', '.') : ''; ?>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <script>
    window.onload = function() {
        window.print(); // Mencetak struk
        window.onafterprint = function() {
            window.location.href = 'view.php?idp=<?= $idp; ?>'; // Mengarahkan kembali ke halaman view.php dengan membawa parameter idp saat menutup jendela pencetakan
        }
    }
</script>


    </body>

    </html>

<?php
    exit;
}
?>
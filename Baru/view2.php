<?php
require 'ceklogin.php';
require 'sidebar.php';
$idp = $_GET['idp'];
if (isset($_GET['idp'])) {
    $idp = $_GET['idp'];
    $ambilnamapelanggan = mysqli_query($koneksi, "SELECT * FROM penjualan p, pelanggan pl where p.id_pelanggan=pl.id_pelanggan AND p.id_penjualan ='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['nama_pelanggan'];
} else {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Data Order</h1>
                    <h4 class="mt-4">Nama Pelanggan : <?php echo $namapel; ?> </h4>
                    <ol class="breadcrumb mb-4">

                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-4">

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Produk
                            </button>
                            <!-- <a href='print.php?id_penjualan=<?php echo $idp ?>' class="btn btn-info mt-3"><i class="bi bi-printer"></i> Cetak Struk</a> -->
                            <div class="container mt-3">
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Detail Order
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
                                        <th>Aksi</th>
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
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo $nama_produk ?></td>
                                            <td><?php echo $jumlah_produk ?></td>
                                            <td><?php echo 'Rp. ' . number_format($harga, 0, ',', '.') ?></td>
                                            <td><?php echo 'Rp. ' . number_format($subtotal, 0, ',', '.') ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?php echo $idpr; ?>">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $idpr; ?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?php echo $idpr; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Pesanan</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <form method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="idp" value="<?php echo $idp; ?>">
                                                            <input type="hidden" name="idpr" value="<?php echo $idpr; ?>">
                                                            <input type="hidden" name="id_detail" value="<?php echo $iddetail; ?>"> <!-- Tambahkan input hidden ini -->

                                                            <label for="jumlah_produk">Qty :</label>
                                                            <input type="number" class="form-control" id="jumlah_produk" name="jumlah_produk" value="<?php echo $jumlah_produk; ?>">
                                                        </div>

                                                        <!-- Modal Footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="editprodukpesanan">Simpan Perubahan</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete<?php echo $idpr; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Data Pesanan</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin Akan Menghapus Produk Ini?
                                                            <input type="hidden" name="idp" value="<?php echo $idp; ?>">
                                                            <input type="hidden" name="idpr" value="<?php echo $idpr; ?>">
                                                            <input type="hidden" name="id_detail" value="<?php echo $iddetail; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Hapus</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>


                                    <?php
                                        // Update nilai sub_total ke dalam database
                                        $query_update_sub_total = "UPDATE detailpenjualan SET subtotal = $subtotal WHERE id_detail = $iddetail";
                                        mysqli_query($koneksi, $query_update_sub_total);
                                    }; ?>

                                    <!-- Setelah perulangan, simpan nilai total pembelian ke dalam database -->
                                    <?php
                                    // Query SQL untuk memperbarui total pembelian di tabel penjualan
                                    // Update nilai total_pembelian ke dalam database
                                    $query_update_total_pembelian = "UPDATE penjualan SET total_harga = $total_pembelian WHERE id_penjualan = $idp";
                                    mysqli_query($koneksi, $query_update_total_pembelian);
                                    ?>

                                    <!-- Setelah menyimpan total pembelian ke dalam database, tampilkan tabel dan field total pembelian -->
                                    <!-- Tabel Total Pembelian -->
                                    <tr>
                                        <td colspan="4" style="text-align: left;"><strong>Total Pembelian</strong></td>
                                        <td><?php echo 'Rp. ' . number_format($total_pembelian, 0, ',', '.') ?></td>
                                        <td> <!-- Kolom Aksi tidak perlu diisi untuk total pembelian -->
                                            <a href='print.php?id_penjualan=<?php echo $idp ?>' class="btn btn-info"><i class="bi bi-printer"></i> Cetak Struk</a>
                                        </td>
                                        <td></td>
                                    </tr>

                                    <!-- Form untuk pembayaran -->
                                    <tr>
                                        <td colspan="4" style="text-align: left;"><strong>Nominal Pembayaran</strong></td>
                                        <td>
                                            <input type="number" id="nominal_pembayaran" class="form-control" placeholder="Uang" min="<?php echo $total_pembelian; ?>" required>
                                        </td>
                                    </tr>

                                    <!-- Tabel Kembalian -->
                                    <tr>
                                        <td colspan="4" style="text-align: left;"><strong>Kembalian</strong></td>
                                        <td id="kembalian"></td>
                                    </tr>

                                    <!-- Script untuk Menghitung Pembayaran dan Kembalian -->
                                    <script>
                                        // Fungsi untuk menghitung total pembayaran dan kembalian
                                        function hitungPembayaran() {
                                            var nominalPembayaran = document.getElementById("nominal_pembayaran").value;
                                            var totalPembelian = <?php echo $total_pembelian; ?>;
                                            var kembalian = nominalPembayaran - totalPembelian;

                                            // Tampilkan kembalian
                                            document.getElementById("kembalian").innerHTML = 'Rp. ' + kembalian;
                                        }

                                        // Panggil fungsi hitungPembayaran() ketika nilai di field pembayaran berubah
                                        document.getElementById("nominal_pembayaran").addEventListener("input", hitungPembayaran);
                                    </script>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            require 'footer.php';
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script> -->
    <!-- <script src="js/datatables-simple-demo.js"></script> -->

    <!-- The Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Penjualan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        Pilih Produk
                        <select name="id_produk" class="form-control mt-2">
                            <?php
                            $getproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk NOT IN (SELECT id_produk FROM detailpenjualan WHERE id_penjualan='$idp')");
                            while ($pr = mysqli_fetch_array($getproduk)) {
                                $id_produk = $pr['id_produk'];
                                $nama_produk = $pr['nama_produk'];
                                $harga = $pr['harga'];
                                $stok = $pr['stok'];

                            ?>
                                <option value="<?= $id_produk; ?>"> <?= $nama_produk; ?> - Rp. <?= number_format($harga, 0, ',', '.'); ?> - (Stok : <?php echo $stok; ?>)</option>

                            <?php
                            }
                            ?>
                        </select>
                        <input type="number" name="jumlah_produk" class="form-control mt-3" placeholder="jumlah produk" min="1" required>
                        <input type="hidden" name="idp" value="<?php echo $idp; ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="addproduk">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
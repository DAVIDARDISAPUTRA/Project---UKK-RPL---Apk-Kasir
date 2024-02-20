<?php
require 'ceklogin.php';
require 'sidebar.php';
$barang = mysqli_query($koneksi, "SELECT * FROM masuk m, produk p WHERE m.id_produk = p.id_produk");
?>

<!DOCTYPE html>
<html lang="en">

<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Stok Produk Masuk</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Stok Barang</li> -->
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Stok Produk
                            </button>
                            <div class="container mt-3">
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Produk Masuk
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah Stok Produk</th>
                                        <th>Tanggal Masuk Produk</th>
                                        <!-- <th>Aksi</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($barang as $brg) : ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $brg['nama_produk']; ?></td>
                                            <td><?php echo $brg['jumlah_produk']; ?></td>
                                            <td><?php echo $brg['tgl_masuk']; ?></td>
                                            <!-- <td>Edit | Delete</td> -->
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

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
                            $getproduk = mysqli_query($koneksi, "SELECT * FROM produk");
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
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="produkmasuk">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Tambahkan kelas 'active-menu' saat menu Stok Barang diklik
            $('#masuk-link').addClass('active-menu');
        });
    </script>
</body>

</html>
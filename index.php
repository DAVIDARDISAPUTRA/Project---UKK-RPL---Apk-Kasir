<?php
require 'ceklogin.php';
require 'sidebar.php';
// hitung jumlah
$h1 = mysqli_query($koneksi, "SELECT * FROM penjualan");
$h2 = mysqli_num_rows($h1);
?>
<!DOCTYPE html>
<html lang="en">
<body class="sb-nav-fixed">

    <div id="layoutSidenav">

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Penjualan</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Selamat Datang</li> -->
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-3">
                            <div class="card bg-danger text-white mb-3">
                                <div class="card-body">Jumlah Penjualan : <?php echo $h2; ?> </div>
                            </div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Penjualan
                            </button>
                            <div class="container mt-3">
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Order
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>ID Penjualan</th>
                                        <th>Tanggal Penjualan</th>
                                        <th>Total Harga</th>
                                        <th>Pelanggan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getpenjualan = mysqli_query($koneksi, "SELECT p.id_penjualan, p.tgl_penjualan, pl.nama_pelanggan, p.total_harga
                                        FROM penjualan p
                                        INNER JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan");

                                    while ($p = mysqli_fetch_array($getpenjualan)) {
                                        $id_penjualan = $p['id_penjualan'];
                                        $tanggal = $p['tgl_penjualan'];
                                        $totalharga = $p['total_harga'];
                                        $nama_pelanggan = $p['nama_pelanggan'];
                                    ?>
                                        <tr>
                                            <!-- <td><?php echo $i; ?></td> -->
                                            <td><?php echo $id_penjualan ?></td>
                                            <td><?php echo $tanggal ?></td>
                                            <td><?php echo "Rp. " . number_format($totalharga, 0, ',', '.');?></td> <!-- Menggunakan total harga dari tabel penjualan -->
                                            <td><?php echo $nama_pelanggan ?></td>
                                            <td><a href="view.php?idp=<?php echo $id_penjualan; ?>" class="btn btn-warning">Tambah Pesanan</td>
                                        </tr>
                                    <?php }; ?>
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
                        Pilih Pelanggan
                        <select name="id_penjualan" class="form-control mt-2">
                            <?php
                            $getpelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                            while ($plg = mysqli_fetch_array($getpelanggan)) {
                                $id_pelanggan = $plg['id_pelanggan'];
                                $nama_pelanggan = $plg['nama_pelanggan'];
                                $alamat = $plg['alamat'];

                            ?>
                                <option value="<?= $id_pelanggan; ?>"> <?= $nama_pelanggan; ?> - <?= $alamat; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahpenjualan">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Tambahkan kelas 'active-menu' saat menu Order diklik
            $('#order-link').addClass('active-menu');
        });
    </script>
</body>

</html>
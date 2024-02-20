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
                    <h1 class="mt-4 mb-4">Data Laporan Penjualan</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Laporan Penjualan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mt-4" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Penjualan</th>
                                            <th>Total</th>
                                            <th>Pelanggan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Inisialisasi tanggal awal dan akhir
                                        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
                                        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

                                        // Query data penjualan berdasarkan rentang tanggal
                                        $query = "SELECT p.*, pl.nama_pelanggan FROM penjualan p 
                                        JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                                        WHERE p.tgl_penjualan BETWEEN '$startDate' AND '$endDate'";
                                        $getpenjualan = mysqli_query($koneksi, $query);

                                        $i = 1;

                                        while ($p = mysqli_fetch_array($getpenjualan)) {
                                            $id_penjualan = $p['id_penjualan'];
                                            $tanggal = $p['tgl_penjualan'];
                                            $nama_pelanggan = $p['nama_pelanggan'];

                                            // Hitung total harga
                                            $totaldetailpenjualan = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total FROM detailpenjualan WHERE id_penjualan = '$id_penjualan'");
                                            $totalharga = mysqli_fetch_assoc($totaldetailpenjualan)['total'];
                                        ?>

                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo $tanggal ?></td>
                                                <td><?php echo "Rp. " . number_format($totalharga, 0, ',', '.'); ?></td>
                                                <td><?php echo $nama_pelanggan ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletelaporan<?php echo $id_penjualan; ?> ">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Hapus Penjualan -->
                                            <div class="modal fade" id="deletelaporan<?php echo $id_penjualan; ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Data Laporan</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="POST">
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                Apakah Anda Yakin Ingin Menghapus Data Laporan ini?
                                                                <input type="hidden" name="id_penjualan" class="form-control mt-3" value="<?php echo $id_penjualan; ?>">
                                                            </div>
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success" name="hapuspenjualan">Hapus</button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php }; ?>


                                        <!-- filter tanggal -->
                                        <form action="" method="GET" class="mb-4">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="start_date" class="form-label">Start Date:</label>
                                                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $startDate; ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="end_date" class="form-label">End Date:</label>
                                                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $endDate; ?>">
                                                </div>
                                                <div class="col-md-3 align-self-end">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- Tampilkan total pendapatan -->
                                        <?php
                                        $totalPendapatanQuery = "SELECT SUM(subtotal) AS total_pendapatan FROM detailpenjualan WHERE id_penjualan IN (SELECT id_penjualan FROM penjualan WHERE tgl_penjualan BETWEEN '$startDate' AND '$endDate')";
                                        if (isset($_GET['total_pendapatan']) && $_GET['total_pendapatan'] != '') {
                                            $totalPendapatanFilter = $_GET['total_pendapatan'];
                                            $totalPendapatanQuery .= " AND total_pendapatan >= $totalPendapatanFilter";
                                        }
                                        $totalPendapatanResult = mysqli_query($koneksi, $totalPendapatanQuery);
                                        $totalPendapatan = mysqli_fetch_assoc($totalPendapatanResult)['total_pendapatan'];
                                        ?>
                                        <!-- <div>Total Pendapatan: <?php echo "Rp. " . number_format($totalPendapatan, 0, ',', '.'); ?></div> -->

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><b>Total Pendapatan</b></td>
                                            <td><b><?php echo "Rp. " . number_format($totalPendapatan, 0, ',', '.'); ?></b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <!-- <div>Total Pendapatan: <?php echo "Rp. " . number_format($totalPendapatan, 0, ',', '.'); ?></div> -->
                            </div>
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

    <script>
        $(document).ready(function() {
            // Tambahkan kelas 'active-menu' saat menu Stok Barang diklik
            $('#laporan-link').addClass('active-menu');
        });
    </script>

</body>

</html>
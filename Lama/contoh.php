<div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 mb-4">Data Laporan Penjualan</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabel Data Laporan Penjualan
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Penjualan</th>
                                            <th>Total Harga</th>
                                            <th>Pelanggan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Inisialisasi tanggal awal dan akhir
                                        $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
                                        $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

                                        // Query data penjualan berdasarkan rentang tanggal
                                        $query = "SELECT * FROM penjualan p 
                                        JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                                         WHERE p.tgl_penjualan BETWEEN '$startDate' AND '$endDate'";
                                        $getpenjualan = mysqli_query($koneksi, $query);

                                        $i = 1;

                                        while ($p = mysqli_fetch_array($getpenjualan)) {
                                            $tanggal = $p['tgl_penjualan'];
                                            $totalharga = $p['total_harga'];
                                            $nama_pelanggan = $p['nama_pelanggan'];

                                            // Hitung total harga
                                            $totaldetailpenjualan = mysqli_query($koneksi, "SELECT * FROM detailpenjualan WHERE id_penjualan = '" . $p['id_penjualan'] . "'");
                                            $totalharga = mysqli_num_rows($totaldetailpenjualan);
                                        ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo $tanggal ?></td>
                                                <td><?php echo $totalharga ?></td>
                                                <td><?php echo $nama_pelanggan ?></td>
                                            </tr>
                                            
                                        <?php }; ?>

                                    </tbody>

                                    <form action="" method="GET" class="mb-4">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="start_date" class="form-label">Start Date:</label>
                                                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?php echo $startDate; ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="end_date" class="form-label">End Date:</label>
                                                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?php echo $endDate; ?>">
                                                </div>
                                                <div class="col-md-4 align-self-end">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </div>
                                            </div>
                                        </form>

                                        <!-- <style>
                                            /* Atur tata letak dan tampilan form */
                                            .form-label {
                                                font-weight: bold;
                                            }

                                            .form-control {
                                                width: 100%;
                                            }

                                            .btn-primary {
                                                width: 100%;
                                            }
                                        </style> -->

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-3 bg-dark mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between mx-5">
                        <div class="">
                            <span class="text-white">Telp :</span> <a href="tel:+6281292732955" class="text-decoration-none text-white">081292732955</a>
                        </div>
                        <div class="" style="margin-right: 30px;">
                            <span class="text-white">Copyright UKK Aplikasi Kasir <?php echo date("Y") ?></span>
                        </div>
                        <div class="">
                            <span class="text-white">Instagram:</span> <a href="https://www.instagram.com/david_yexiu" class="text-decoration-none text-white">@david_yexiu</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
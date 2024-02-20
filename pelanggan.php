<?php
require 'ceklogin.php';
require 'sidebar.php';
$h1 = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$h2 = mysqli_num_rows($h1);
?>

<!DOCTYPE html>
<html lang="en">
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Kelola Pelanggan</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Stok Barang</li> -->
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-3">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body">Jumlah Pelanggan : <?php echo $h2; ?></div>
                            </div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Pelanggan
                            </button>
                            <div class="container mt-3">
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Pelanggan
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>Nomor telpon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getpelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
                                    $i = 1;

                                    while ($pl = mysqli_fetch_array($getpelanggan)) {
                                        $id_pelanggan = $pl['id_pelanggan'];
                                        $nama_pelanggan = $pl['nama_pelanggan'];
                                        $alamat = $pl['alamat'];
                                        $notelp = $pl['notelp'];

                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $nama_pelanggan; ?></td>
                                            <td><?php echo $alamat; ?></td>
                                            <td><?php echo $notelp; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $id_pelanggan; ?> ">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $id_pelanggan; ?> ">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit_<?php echo $id_pelanggan; ?>" ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Pelanggan</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <input type="text" name="nama_pelanggan" class="form-control mt-3" value="<?php echo $nama_pelanggan; ?>">

                                                            <input type="text" name="alamat" class="form-control mt-3" value="<?php echo $alamat; ?>">

                                                            <input type="num" name="notelp" class="form-control mt-3" value="<?php echo $notelp; ?>">

                                                            <input type="hidden" name="id_pelanggan" class="form-control mt-3" value="<?php echo $id_pelanggan; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="editpelanggan">Simpan</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete_<?php echo $id_pelanggan; ?>" ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Pelanggan <?php echo $nama_pelanggan; ?> </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin Ingin Menghapus Pelanggan Ini?
                                                            <input type="hidden" name="id_pelanggan" class="form-control mt-3" value="<?php echo $id_pelanggan; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapuspelanggan">Hapus</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>
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
                    <h4 class="modal-title">Tambah Pelanggan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="text" name="nama_pelanggan" class="form-control mt-3" placeholder="nama pelanggan">
                        <input type="text" name="alamat" class="form-control mt-3" placeholder="alamat">
                        <input type="num" name="notelp" class="form-control mt-3" placeholder="nomor telpon">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahpelanggan">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Tambahkan kelas 'active-menu' saat menu Stok Barang diklik
            $('#pelanggan-link').addClass('active-menu');
        });
    </script>
</body>

</html>
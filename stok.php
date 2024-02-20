<?php
require 'ceklogin.php';
require 'sidebar.php';
$barang = mysqli_query($koneksi, "SELECT * FROM produk");
$h2 = mysqli_num_rows($barang);

?>

<!DOCTYPE html>
<html lang="en">
<body class="sb-nav-fixed">
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Stok Barang</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Stok Barang</li> -->
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-3">
                            <div class="card bg-primary text-white mb-3">
                                <div class="card-body">Jumlah Barang : <?php echo $h2; ?></div>
                            </div>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Produk
                            </button>
                            <div class="container mt-3">
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Produk
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $getbarang = mysqli_query($koneksi, "SELECT * FROM produk");
                                    $i = 1;
                                    while ($brg = mysqli_fetch_array($getbarang)) {
                                        $np = $brg['nama_produk'];
                                        $harga = $brg['harga'];
                                        $stok = $brg['stok'];
                                        $id_produk = $brg['id_produk'];
                                        ?>

                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $np;?></td>
                                            <td><?php echo "Rp. " . number_format($harga, 0, ',', '.'); ?></td>
                                            <td><?php echo $stok; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $id_produk; ?> ">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $id_produk; ?> ">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit_<?php echo $id_produk; ?>" ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Produk</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <input type="text" name="nama_produk" class="form-control mt-3" placeholder="nama produk" value="<?php echo $brg['nama_produk']; ?>">
                                                            <input type="num" name="harga" class="form-control mt-3" placeholder="harga" value="<?php echo $brg['harga']; ?>">
                                                            <input type="hidden" name="id_produk" class="form-control mt-3" value="<?php echo $id_produk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="editproduk">Simpan</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete_<?php echo $id_produk; ?>" ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Produk <?php echo $np; ?> </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin Ingin Menghapus Produk Ini?
                                                            <input type="hidden" name="id_produk" class="form-control mt-3" value="<?php echo $id_produk; ?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapusproduk">Hapus</button>
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
                    <h4 class="modal-title">Tambah Produk</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="text" name="nama_produk" class="form-control mt-3" placeholder="nama produk">
                        <input type="num" name="harga" class="form-control mt-3" placeholder="harga">
                        <input type="num" name="stok" class="form-control mt-3" placeholder="stok">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahproduk">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Tambahkan kelas 'active-menu' saat menu Stok Barang diklik
            $('#stok-link').addClass('active-menu');
        });
    </script>
</body>

</html>
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
                    <h1 class="mt-4">Kelola Petugas</h1>
                    <ol class="breadcrumb mb-4">
                        <!-- <li class="breadcrumb-item active">Stok Barang</li> -->
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <!-- <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah Pelanggan : <?php echo $h2; ?></div>
                            </div> -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Petugas
                            </button>
                            <div class="container mt-3">
                            </div>
                        </div>

                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Petugas
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Level</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getpetugas = mysqli_query($koneksi, "SELECT * FROM user WHERE level='admin' OR level='kasir'");
                                    $i = 1;

                                    while ($petugas = mysqli_fetch_array($getpetugas)) {
                                        $id_user = $petugas['id_user'];
                                        $username = $petugas['username'];
                                        $password = $petugas['password'];
                                        $level = $petugas['level'];
                                    ?>

                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td><?php echo $password; ?></td>
                                            <td><?php echo $level; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#_edit<?php echo $id_user; ?> ">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#_delete<?php echo $id_user; ?> ">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Petugas -->
                                        <div class="modal fade" id="_edit<?php echo $id_user; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Data Petugas</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            <input type="text" name="username" class="form-control mt-3" value="<?php echo $username; ?>">
                                                            <input type="password" name="password" class="form-control mt-3" placeholder="Password">
                                                            <select name="level" class="form-control mt-3">
                                                                <option value="admin" <?php if ($level == 'admin') echo 'selected'; ?>>Admin</option>
                                                                <option value="kasir" <?php if ($level == 'kasir') echo 'selected'; ?>>Kasir</option>
                                                            </select>
                                                            <input type="hidden" name="id_petugas" class="form-control mt-3" value="<?php echo $id_user; ?>">
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="editpetugas">Simpan</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Petugas -->
                                        <div class="modal fade" id="_delete<?php echo $id_user; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Data Petugas <?php echo $username; ?></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form method="POST">
                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            Apakah Anda Yakin Ingin Menghapus Petugas ?
                                                            <input type="hidden" name="id_petugas" class="form-control mt-3" value="<?php echo $id_user; ?>">
                                                        </div>
                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapuspetugas">Hapus</button>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
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
                    <h4 class="modal-title">Tambah Petugas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST">
                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="text" name="username" class="form-control mt-3" placeholder="Username">
                        <input type="password" name="password" class="form-control mt-3" placeholder="Password">
                        <select name="level" class="form-control mt-3">
                            <option value="admin">Admin</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="tambahpetugas">Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Tambahkan kelas 'active-menu' saat menu Stok Barang diklik
            $('#petugas-link').addClass('active-menu');
        });
    </script>
</body>

</html>
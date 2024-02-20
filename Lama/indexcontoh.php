<tbody>
    <?php
    $getpenjualan = mysqli_query($koneksi, "SELECT * FROM penjualan p, pelanggan pl WHERE p.id_pelanggan = pl.id_pelanggan");

    while ($p = mysqli_fetch_array($getpenjualan)) {
        $id_penjualan = $p['id_penjualan'];
        $tanggal = $p['tgl_penjualan'];
        $totalharga = $p['total_harga'];
        $id_pelanggan = $p['id_pelanggan'];
        $nama_pelanggan = $p['nama_pelanggan'];

        // Hitung total harga
        $totaldetailpenjualan = mysqli_query($koneksi, "SELECT * FROM detailpenjualan WHERE id_penjualan = '$id_penjualan'");
        $totalharga = mysqli_num_rows($totaldetailpenjualan);

    ?>
        <tr>
            <!-- <td><?php echo $i; ?></td> -->
            <td><?php echo $id_penjualan ?></td>
            <td><?php echo $tanggal ?></td>
            <td><?php echo $totalharga ?></td>
            <td><?php echo $nama_pelanggan ?></td>
            <td><a href="view.php?idp=<?php echo $id_penjualan; ?>" class="btn btn-warning">Tambah Pesanan</td>
        </tr>

    <?php }; ?>
</tbody>
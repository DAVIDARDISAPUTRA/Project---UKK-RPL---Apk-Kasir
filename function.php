<?php
session_start();
$koneksi = mysqli_connect('localhost', 'root', '', 'apk_kasir');

if (isset($_POST['login'])) {
    // initial variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $hitung = mysqli_num_rows($check);

    if ($hitung > 0) {
        $data = mysqli_fetch_assoc($check);
        if ($data['level'] == 'admin' || $data['level'] == 'kasir') {
            $_SESSION['level'] = $data['level'];
        }

        if ($data['level'] == 'admin' || $data['level'] == 'kasir') {
            header('location:index.php');
            $_SESSION['login'] = true;
        }
    } else {
        // datanya tidak ada maka gagal login
        echo '<script>alert("Username atau Password salah"); window.location.href="login.php";</script>';
    }
}

if (isset($_POST['tambahproduk'])) {
    // deskripsi initial variable
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $insert_produk = mysqli_query($koneksi, "INSERT INTO produk (nama_produk,harga,stok) VALUES ('$nama_produk', '$harga', '$stok')");

    if ($insert_produk) {
        header('location:stok.php');
    } else {
        echo '<script>alert("Gagal tambah produk"); window.location.href="stok.php";</script>';
    }
}

// tambah pelanggan
if (isset($_POST['tambahpelanggan'])) {
    // deskripsi initial variable
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];

    $insert_pelanggan = mysqli_query($koneksi, "INSERT INTO pelanggan (nama_pelanggan,alamat,notelp) VALUES ('$nama_pelanggan', '$alamat', '$notelp')");

    if ($insert_pelanggan) {
        header('location:pelanggan.php');
    } else {
        echo '<script>alert("Gagal tambah pelanggan"); window.location.href="pelanggan.php";</script>';
    }
}

if (isset($_POST['tambahpenjualan'])) {
    // deskripsi initial variable
    $id_pelanggan = $_POST['id_penjualan'];

    $insert_penjualan = mysqli_query($koneksi, "INSERT INTO penjualan (id_pelanggan) VALUES ('$id_pelanggan')");

    if ($insert_penjualan) {
        header('location:index.php');
    } else {
        echo '<script>alert("Gagal tambah pesanan"); window.location.href="index.php";</script>';
    }
}

if (isset($_POST['addproduk'])) {
    // deskripsi initial variable
    $idp = $_POST['idp'];
    $id_produk = $_POST['id_produk'];
    $jumlah_produk = $_POST['jumlah_produk'];
    $subtotal = $_POST['subtotal'];

    // hitung stok sekarang ada berapa
    $hitung1 = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok'];

    if ($stoksekarang >= $jumlah_produk) {
        // kurangi stok dengan jumlah yang akan dikeluarkan
        $selisih = $stoksekarang - $jumlah_produk;

        // stoknya cukup
        $insert = mysqli_query($koneksi, "INSERT INTO detailpenjualan (id_penjualan, id_produk, jumlah_produk, subtotal) VALUES ('$idp','$id_produk','$jumlah_produk', '$subtotal')");
        $update = mysqli_query($koneksi, "UPDATE produk SET stok='$selisih' WHERE id_produk='$id_produk'");

        if ($insert && $update) {
            header('location: view.php?idp=' . $idp);
        } else {
            echo '<script>alert("Gagal tambah item produk"); window.location.href="view.php?idp=' . $idp . '";</script>';
        }
    } else {
        // stok tidak cukup
        echo '<script>alert("Stok Tidak Cukup"); window.location.href="view.php' . $idp . '";</script>';
    }
}

if (isset($_POST['editprodukpesanan'])) {
    $idpr = $_POST['idpr'];
    $iddetail = $_POST['id_detail'];
    $jumlah_produk = $_POST['jumlah_produk'];
    $idp = $_POST['idp'];

    // Ambil jumlah produk sebelum perubahan
    $query_get_qty = mysqli_query($koneksi, "SELECT jumlah_produk FROM detailpenjualan WHERE id_detail='$iddetail'");
    $row = mysqli_fetch_assoc($query_get_qty);
    $jumlah_produk_sebelum = $row['jumlah_produk'];

    // Hitung perbedaan jumlah produk
    $perbedaan_jumlah_produk = $jumlah_produk - $jumlah_produk_sebelum;

    // Update jumlah produk dalam detail penjualan
    $edit_produk_pesanan = mysqli_query($koneksi, "UPDATE detailpenjualan SET jumlah_produk='$jumlah_produk' WHERE id_detail='$iddetail'");

    // Update stok produk
    $query_get_stok = mysqli_query($koneksi, "SELECT stok FROM produk WHERE id_produk='$idpr'");
    $row = mysqli_fetch_assoc($query_get_stok);
    $stok_sekarang = $row['stok'];
    $stok_baru = $stok_sekarang - $perbedaan_jumlah_produk;

    $update_stok_produk = mysqli_query($koneksi, "UPDATE produk SET stok='$stok_baru' WHERE id_produk='$idpr'");

    if ($edit_produk_pesanan && $update_stok_produk) {
        header('location: view.php?idp=' . $idp);
    } else {
        echo '<script>alert("Gagal Edit Produk Pesanan"); window.location.href="view.php?idp=' . $idp . '";</script>';
    }
}

// hapus produk pada detail pesanan
if (isset($_POST['hapusprodukpesanan'])) {
    $iddetail = $_POST['id_detail'];
    $idpr = $_POST['idpr'];
    $idp = $_POST['idp'];

    // Cari jumlah produk yang akan dihapus dari pesanan
    $cek1 = mysqli_query($koneksi, "SELECT * FROM detailpenjualan WHERE id_detail='$iddetail'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['jumlah_produk'];

    // Perbarui stok produk dengan menambahkan kembali jumlah produk yang akan dihapus
    $cek3 = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    $hitung = $stoksekarang + $qtysekarang;

    // Perbarui stok produk
    $update_stok = mysqli_query($koneksi, "UPDATE produk SET stok='$hitung' WHERE id_produk='$idpr'");

    // Hapus produk dari pesanan
    $hapus_produk = mysqli_query($koneksi, "DELETE FROM detailpenjualan WHERE id_produk='$idpr' AND id_detail='$iddetail'");

    if ($update_stok && $hapus_produk) {
        header('location:view.php?idp=' . $idp);
    } else {
        echo '<script>alert("Gagal hapus produk"); window.location.href="view.php?idp=' . $idp . '";</script>';
    }
}


// tambah stok barang masuk
if (isset($_POST['produkmasuk'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah_produk = $_POST['jumlah_produk'];

    $insertpro = mysqli_query($koneksi, "INSERT INTO masuk (id_produk,jumlah_produk) VALUES ('$id_produk','$jumlah_produk')");

    if ($insertpro) {
        header('location:masuk.php');
    } else {
        echo '<script>alert("Gagal"); window.location.href="masuk.php";</script>';
    }
}

// edit produk
if (isset($_POST['editproduk'])) {
    $np = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $idpr = $_POST['id_produk'];

    $edit_barang = mysqli_query($koneksi, "UPDATE produk SET nama_produk='$np', harga='$harga' WHERE id_produk='$idpr'");

    if ($edit_barang) {
        header('location:stok.php');
    } else {
        echo '<script>alert("Gagal Edit Barang"); window.location.href="stok.php";</script>';
    }
}
// hapus produk
if (isset($_POST['hapusproduk'])) {
    $idpr = $_POST['id_produk'];

    $hapusbarang = mysqli_query($koneksi, "DELETE FROM produk WHERE id_produk='$idpr'");

    if ($hapusbarang) {
        header('location:stok.php');
    } else {
        echo '<script>alert("Gagal Hapus Barang"); window.location.href="stok.php";</script>';
    }
}

// edit pelanggan
if (isset($_POST['editpelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $notelp = $_POST['notelp'];
    $id_pelanggan = $_POST['id_pelanggan'];

    $edit_pelanggan = mysqli_query($koneksi, "UPDATE pelanggan SET nama_pelanggan='$nama_pelanggan', alamat='$alamat', notelp='$notelp' WHERE id_pelanggan='$id_pelanggan'");

    if ($edit_pelanggan) {
        header('location:pelanggan.php');
    } else {
        echo '<script>alert("Gagal Edit Pelanggan"); window.location.href="pelanggan.php";</script>';
    }
}
// hapus pelanggan
if (isset($_POST['hapuspelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];

    $hapuspelanggan = mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");

    if ($hapuspelanggan) {
        header('location:pelanggan.php');
    } else {
        echo '<script>alert("Gagal Hapus Pelanggan"); window.location.href="pelanggan.php";</script>';
    }
}

// tambah petugas
if (isset($_POST['tambahpetugas'])) {
    // Ambil nilai dari input form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // Lakukan validasi atau filter input jika diperlukan

    $insert_petugas = mysqli_query($koneksi, "INSERT INTO user (username,password,level) VALUES ('$username', '$password', '$level')");

    if ($insert_petugas) {
        header('location:petugas.php');
    } else {
        echo '<script>alert("Gagal tambah petugas"); window.location.href="petugas.php";</script>';
    }
}

// edit petugas
if (isset($_POST['editpetugas'])) {
    $id_user = $_POST['id_petugas']; // Mengubah 'id_user' menjadi 'id_petugas'
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    $edit_petugas = mysqli_query($koneksi, "UPDATE user SET username='$username', password='$password', level='$level' WHERE id_user='$id_user'");

    if ($edit_petugas) {
        header('location:petugas.php');
    } else {
        echo '<script>alert("Gagal Edit Petugas"); window.location.href="petugas.php";</script>';
    }
}

// hapus petugas
if (isset($_POST['hapuspetugas'])) {
    $id_user = $_POST['id_petugas']; // Mengubah 'id_user' menjadi 'id_petugas'

    $hapuspetugas = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id_user'");

    if ($hapuspetugas) {
        header('location:petugas.php');
    } else {
        echo '<script>alert("Gagal Hapus Petugas"); window.location.href="petugas.php";</script>';
    }
}

// hapus laporan
// hapus penjualan
if (isset($_POST['hapuspenjualan'])) {
    $id_penjualan = $_POST['id_penjualan'];

    // Query untuk menghapus penjualan dan detail penjualan yang terkait
    $hapus_penjualan = mysqli_query($koneksi, "DELETE FROM penjualan WHERE id_penjualan='$id_penjualan'");
    $hapus_detail_penjualan = mysqli_query($koneksi, "DELETE FROM detailpenjualan WHERE id_penjualan='$id_penjualan'");

    if ($hapus_penjualan && $hapus_detail_penjualan) {
        header('location: laporan.php');
    } else {
        echo '<script>alert("Gagal Hapus Penjualan"); window.location.href="laporan.php";</script>';
    }
}

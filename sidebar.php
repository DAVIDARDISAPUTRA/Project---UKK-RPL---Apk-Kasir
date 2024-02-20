<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplikasi Kasir</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/jpg" href="assets/img/icon6.png">
    <style>
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #021c1e !important;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .nav-link {
            color: #ffffff !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #f8f9fa !important;
        }

        .sb-sidenav {
            background-color: #004445;
        }

        .sb-sidenav-menu-heading {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
        }

        .active-menu {
            background-color: #2c7873 !important;
            color: white !important;
            /* border: 2px solid red !important; */
            /* border-radius: 10px; */
        }

        .active .nav-link .sb-nav-link-icon {
            color: white;
        }

        .sb-sidenav-menu-heading {
            font-size: 80px;
            /* Atur ukuran teks sesuai kebutuhan */
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">UKK - Aplikasi Kasir</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <?php
                        $level_user = $_SESSION['level'];
                        if ($level_user == 'admin') {
                        ?>
                            <a id="order-link" class="nav-link nav-link active" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-plus"></i></div>
                                Order
                            </a>
                            <a id="stok-link" class="nav-link nav-link active" href="stok.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Produk
                            </a>
                            <a id="masuk-link" class="nav-link nav-link active" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Produk Masuk
                            </a>
                            <a id="pelanggan-link" class="nav-link nav-link active" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Pelanggan
                            </a>
                            <a id="petugas-link" class="nav-link nav-link active" href="petugas.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Petugas
                            </a>
                            <a id="laporan-link" class="nav-link nav-link active" href="laporan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                Laporan
                            </a>
                            <a id="logout-link" class="nav-link nav-link active" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        <?php
                        } elseif ($level_user == 'kasir') {
                        ?>
                            <a id="order-link" class="nav-link nav-link active" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-cart-plus"></i></i></div>
                                Order
                            </a>
                            <a id="stok-link" class="nav-link nav-link active" href="stok.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Produk
                            </a>
                            <a id="pelanggan-link" class="nav-link nav-link active" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Pelanggan
                            </a>
                            <a id="logout-link" class="nav-link nav-link active" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.nav-link').click(function() {
                $('.nav-link').removeClass('active-menu');
                $(this).addClass('active-menu');
            });
        });
    </script>
</body>

</html>
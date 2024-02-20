<?php
require 'function.php';

if (!isset($_SESSION['login'])) {
    // sudah login
} else {
    // sudah login
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/jpg" href="assets/img/icon6.png">
</head>

<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="username" type="text" placeholder="username" required />
                                            <label for="username">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button type="submit" name="login" class="btn btn-warning text-light"> Login </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="fixed-bottom text-center bg-dark py-2">
            <footer class="py-4 bg-warning mt-auto">
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
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
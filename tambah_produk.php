<?php
require 'dbconfig.php';

if ($_SESSION['role'] != 'pedagang') {
    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JanLink</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/logo-rounded.png" />
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/05f405bcb5.js" crossorigin="anonymous"></script>
    <style>
        ul li .nav-items-active {
            text-decoration: none;
            color: #FD725C;
            font-weight: 600;
            border-bottom: solid #FD725C;
        }

        ul li .nav-items {
            color: #393535;
            text-decoration: none;
            font-weight: 600;
        }

        ul li .nav-items:hover {
            text-decoration: none;
            color: #FD725C;
            font-weight: 600;

        }
    </style>
</head>


<body>
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between p-3 border-bottom sticky-top bg-light">
        <div class="col-md-3 col-sm-auto mb-2 ms-md-auto mb-md-0">
            <b>Dashboard Pedagang</b>
        </div>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="dashboard_pedagang.php" class="nav-items px-2">Profil</a></li>
            <li><a href="#" class="nav-items-active px-2">Tambah Produk</a></li>
            <li><a href="lihat_produk.php" class="nav-items px-2">Lihat Produk</a></li>
        </ul>

        <div class="col-md-3 col-sm-auto text-end me-md-auto">
            <a type='button' class='btn_masuk rounded-2 text-decoration-none text-center me-3' href='main.php'><i class="fa-solid fa-house me-2" style="color: #ffffff;"></i>Beranda</a>

            <?php
            if (isset($_SESSION['id'])) {
                echo "<a type='button' class='btn_masuk  rounded-5 text-decoration-none text-center' href='logout.php'>Keluar</a>";
            } else {
                echo "<a type='button' class='btn_masuk rounded-5 text-decoration-none text-center' href='login.php'>Masuk</a>";
            }

            ?>

        </div>
    </header>



    <div class="container tambah-produk mt-4 mb-4">
        <h2>Tambah Produk</h2>
        <hr class="ms-auto me-auto mb-5">
        <form action="server-input-produk.php" method="post" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="nama_produk">Nama Produk:</label>
                <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
            </div>
            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi:</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="harga">Harga:</label>
                <input type="number" class="form-control" name="harga" id="harga" required>
            </div>
            <div class="form-group mb-3">
                <label for="gambar_produk">Gambar Produk</label>
                <input type="file" class="form-control-file" name="gambar_produk" id="gambar_produk" required>
            </div>
            <button type="submit" class="btn" style="background-color: #FD725C; color:white;">Tambah</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script>
        $(document).ready(function() {
            <?php
            // Check for success message in the session
            if (isset($_SESSION['success_tambah'])) {
                // Display SweetAlert for success
                echo "Swal.fire({
                icon: 'success',
                timer:'2000',
                title: 'Berhasil!',
                text: '{$_SESSION['success_tambah']}',
                showConfirmButton: false
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['success_tambah']);
            } elseif (isset($_SESSION['error_tambah'])) {
                // Display SweetAlert for error
                echo "Swal.fire({
                icon: 'error',
                timer:'2000',
                title: 'Gagal!',
                text: '{$_SESSION['error_tambah']}',
                showConfirmButton: false
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['error_tambah']);
            }
            ?>
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua/C4z6Zaht6LeLZfJbf47P6KWpNMyW8jOG6Cr/Itg4PAO2E6b6uXMJXs" crossorigin="anonymous"></script>


</body>

</html>
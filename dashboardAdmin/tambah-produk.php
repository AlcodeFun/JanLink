<?php
require '../dbconfig.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: ../main.php");
}
?>


<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard Admin</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/favicon-janlink.png" />
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="../style.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo me-1">
                            <span style="color: var(--bs-primary)">
                                <img src="../assets/logo-janlink.png" alt="">
                            </span>
                        </span>

                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">

                    <!-- Overview -->
                    <li class="menu-item">
                        <a href="home.php" class="menu-link">
                            <i class="menu-icon tf-icons mdi mdi-home"></i>
                            <div data-i18n="Icons">Overview</div>
                        </a>
                    </li>






                    <!-- Tables -->
                    <li class="menu-header fw-medium mt-4"><span class="menu-header-text"> Tables</span></li>
                    <!-- Table components -->
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-table"></i>
                            <div data-i18n="Extended UI">Pedagang</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="tambah-pedagang.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Tambah Pedagang</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="lihat-pedagang.php" class="menu-link">
                                    <div data-i18n="Text Divider">Lihat Pedagang</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-table"></i>
                            <div data-i18n="Extended UI">Pembeli</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="lihat-pembeli.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Lihat Pembeli</div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-table"></i>
                            <div data-i18n="Extended UI">Produk</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item active">
                                <a href="tambah-produk.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Tambah Produk</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="lihat-produk.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Lihat Produk</div>
                                </a>
                            </li>


                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons mdi mdi-table"></i>
                            <div data-i18n="Extended UI">Kategori</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="tambah-kategori.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Tambah Kategori</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="lihat-kategori.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Lihat Kategori</div>
                                </a>
                            </li>


                        </ul>
                    </li>



                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="mdi mdi-menu mdi-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">


                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <li class="nav-item lh-1 me-3">
                                <a type='button' class='btn_masuk rounded-2 text-decoration-none text-center me-3' href='../main.php'><i class="fa-solid fa-house me-2" style="color: #ffffff;"></i>Beranda</a>

                            </li>
                            <li class="nav-item lh-1 me-3">
                                <?php

                                if (isset($_SESSION['id'])) {

                                    echo "<a type='button' class='btn_masuk  rounded-5 text-decoration-none text-center' href='../logout.php'>Keluar</a>";
                                } else {
                                    echo "<a type='button' class='btn_masuk rounded-5 text-decoration-none text-center' href='../login.php'>Masuk</a>";
                                }

                                ?>
                            </li>



                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container tambah-produk mt-4 mb-4">
                        <h2>Tambah Produk</h2>
                        <hr class="ms-auto me-auto mb-5">
                        <form action="tambah-produk-server.php" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="nama_produk">Nama Produk:</label>
                                <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="id_pedagang">Nama Jajanan:</label>
                                <select id='id_pedagang' class='form-select' aria-label='Default select example' name='id_pedagang' required>";
                                    <?php $sqlPedagang = "SELECT ID_Pedagang, Nama_Jajanan FROM pedagang";
                                    $resultPedagang = $conn->query($sqlPedagang);

                                    while ($rowPedagang = $resultPedagang->fetch_assoc()) {
                                        echo "<option value='{$rowPedagang['ID_Pedagang']}'>{$rowPedagang['Nama_Jajanan']}</option>";
                                    } ?>
                                </select>
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

                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



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
            </div>


        </div>
        <!-- / Content -->



        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script>
        // Parse the PHP data in JavaScript
        var chartData = <?php echo $chartDataJSON; ?>;

        // Create a bar chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Banyak Pedagang dan Pembeli',
                    data: chartData.data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua/C4z6Zaht6LeLZfJbf47P6KWpNMyW8jOG6Cr/Itg4PAO2E6b6uXMJXs" crossorigin="anonymous"></script>

</body>

</html>
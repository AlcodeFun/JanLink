<?php
require '../dbconfig.php';

$catQuery = "SELECT ID_Kategori, nama_kategori FROM kategori";
$resultCat = $conn->query($catQuery);



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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/materialdesignicons.css" />
    <!-- Font Awesome Kit -->
    <script src="https://kit.fontawesome.com/05f405bcb5.js" crossorigin="anonymous"></script>

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- CSS -->
    <link rel="stylesheet" href="../style.css">

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            <li class="menu-item">
                                <a href="tambah-produk.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Tambah Produk</div>
                                </a>
                            </li>
                            <li class="menu-item active">
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
                                <a href="tambah-pedagang.php" class="menu-link">
                                    <div data-i18n="Perfect Scrollbar">Tambah Kategori</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="tambah-pedagang.php" class="menu-link">
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

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h2>Lihat Pedagang</h2>
                        <hr class="ms-auto me-auto mb-5">
                        <div class="table-responsive">
                            <table class="table  table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Nama Jajanan</th>
                                        <th scope="col">Deskripsi</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">thum_produk</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "SELECT * FROM produk";
                                    $result = $conn->query($sql);



                                    if ($result->num_rows > 0) {
                                        $counter = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            $modalId = $row['id'];
                                            $id_pedagang = $row['ID_Pedagang'];
                                            $sqlPedagang = "SELECT Nama_Jajanan FROM pedagang WHERE ID_Pedagang=$id_pedagang";
                                            $resultPedagang = $conn->query($sqlPedagang);
                                            $rowPedagang = $resultPedagang->fetch_assoc();
                                            $nama_jajanan = $rowPedagang['Nama_Jajanan'];


                                            echo "<tr>
                            <td>$counter</td>
                            <td>{$row['nama_produk']}</td>
                            <td>{$nama_jajanan}</td>
                            <td>{$row['deskripsi']}</td>
                            <td>{$row['harga']}</td>
                            <td><img style='width:200px;' src='data:image/jpeg;base64," . base64_encode($row['thum_produk']) . "' alt='Product Thumbnail'></td>    
                             <td>
                                <button
                                    type='button'
                                    class='btn btn-primary update-button mb-3'
                                    data-bs-toggle='modal'
                                    data-bs-target='#updateModal_{$modalId}'
                                    data-produk='{$row['nama_produk']}'
                                    data-jajanan='{$nama_jajanan}'
                                    data-deskripsi='{$row['deskripsi']}'
                                    data-harga='{$row['harga']}'
                                
                                   
                                >
                                <i class='fa-solid fa-pen-to-square' style='color: #FFF;'></i>
                                </button>
                                <button class='btn btn-danger mb-3' href='javascript:void(0);' onclick='confirmDelete({$row['id']})'><i class='fa-solid fa-trash' style='color: #ffffff;'></i></button>
                            </td>
                        </tr>";

                                            // Modal Structure
                                            echo "<div class='modal' id='updateModal_{$modalId}' aria-labelledby='updateModalLabel'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='updateModalLabel'>Perbarui Produk</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='update-produk-server.php' method='POST' enctype='multipart/form-data'>
                                        <input type='hidden' name='id_produk' value='{$row['id']}'>
                                            
                    
                                            <div class='mb-3'>
                                                <label for='updateProduk' class='form-label'>Nama Produk</label>
                                                <input type='text' class='form-control' id='updateProduk' name='updateProduk' value='{$row['nama_produk']}' required>
                                            </div>
                                        
                                            <div class='mb-3'>
                        <label for='id_pedagang' class='form-label'>Nama Jajanan</label>
                        <select id='id_pedagang' class='form-select' aria-label='Default select example' name='id_pedagang' required>";
                                            $sqlPD = "SELECT * FROM pedagang";
                                            $resultPD = $conn->query($sqlPD);

                                            while ($rowPDloop = $resultPD->fetch_assoc()) {
                                                echo "<option value='{$rowPDloop['ID_Pedagang']}'>{$rowPDloop['Nama_Jajanan']}</option>";
                                            }
                                            echo "</select>
                    </div>

                    <div class='mb-3'>
                                                <label for='updateDeskripsi' class='form-label'>Deskripsi</label>
                                                <input type='text' class='form-control' id='updateDeskripsi' name='updateDeskripsi' value='{$row['deskripsi']}' required>
                                            </div>

                                            <div class='mb-3'>
                                            <label for='updateHarga' class='form-label'>Harga</label>
                                            <input type='text' class='form-control' id='updateHarga' name='updateHarga' value='{$row['harga']}' required>
                                        </div>
            
            
                                            
                    
                                            <div class='mb-3'>
                                            <img src='data:image/jpeg;base64," . base64_encode($row['thum_produk']) . "' alt='Thumbnail'><br>
                                                <label for='updatethum_produk' class='form-label'>Thumbnail</label>
                                                <input type='file' class='form-control' id='updatethumproduk' name='updatethum_produk' required>
                                            </div>
                                            

                                    
                                        
                    
                                            <!-- Add input fields for other product information -->
                    
                                            <button type='submit' class='btn btn-danger'>Simpan Perubahan</button>
                                        </form>
                                    </div>
        
                                </div>
                            </div>
                        </div>"; ?><?php

                                            $counter++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>No products found</td></tr>";
                                    }

                                    ?>
                                </tbody>
                            </table>
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
    <script>
        $(document).ready(function() {
            <?php
            // Check for success message in the session
            if (isset($_SESSION['duplicate'])) {
                // Display SweetAlert for success
                echo "Swal.fire({
                icon: 'error',
                timer: '2000',
                title: 'Data Duplikat!',
                text: '{$_SESSION['duplicate']}',
                showConfirmButton: false
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['duplicate']);
            } else if (isset($_SESSION['success'])) {
                // Display SweetAlert for success
                echo "Swal.fire({
                icon: 'success',
                timer: '2000',
                title: 'Berhasil!',
                text: '{$_SESSION['success']}',
                showConfirmButton: false
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['success']);
            } elseif (isset($_SESSION['error_tambah'])) {
                // Display SweetAlert for error
                echo "Swal.fire({
                icon: 'error',
                timer: '2000',
                title: 'Gagal!',
                text: '{$_SESSION['failed']}',
                showConfirmButton: false
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['failed']);
            }
            ?>
        });
    </script>

    <script>
        function confirmDelete(productId) {
            Swal.fire({
                title: 'Yakin ingin menghapus produk?',
                text: 'Produk tidak kembali setelah dihapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete-produk-server.php?id=' + productId;
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            <?php
            // Check for success message in the session
            if (isset($_SESSION['success_message'])) {
                // Display SweetAlert for success
                echo "Swal.fire({
                icon: 'success',
                title: 'Berhasil Perbarui!',
                text: '{$_SESSION['success_message']}',
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['success_message']);
            } elseif (isset($_SESSION['error_message'])) {
                // Display SweetAlert for error
                echo "Swal.fire({
                icon: 'error',
                title: 'Gagal Perbarui!',
                text: '{$_SESSION['error_message']}',
            });";
                // Unset the session variable to avoid displaying the message on page reload
                unset($_SESSION['error_message']);
            }
            ?>
        });
    </script>


</body>

</html>
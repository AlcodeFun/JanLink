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
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <li><a href="tambah_produk.php" class="nav-items px-2">Tambah Produk</a></li>
            <li><a href="#" class="nav-items-active px-2">Lihat Produk</a></li>
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
        <h2>Lihat Produk</h2>
        <hr class="ms-auto me-auto mb-5">
        <div class="table-responsive">
            <table class="table  table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Kelola</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $id_pedagang = $_SESSION['id'];
                    $sql = "SELECT id, nama_produk, deskripsi, harga, thum_produk FROM produk WHERE ID_Pedagang = $id_pedagang";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            $modalId = $row['id'];

                            echo "<tr>
                            <td>$counter</td>
                            <td>{$row['nama_produk']}</td>
                            <td>{$row['deskripsi']}</td>
                            <td>{$row['harga']}</td>
                            <td><img src='data:image/jpeg;base64," . base64_encode($row['thum_produk']) . "' alt='Product Thumbnail'></td>                            <td>
                                <button
                                    type='button'
                                    class='btn btn-primary update-button mb-3'
                                    data-bs-toggle='modal'
                                    data-bs-target='#updateModal_{$modalId}'
                                    data-nama='{$row['nama_produk']}'
                                    data-deskripsi='{$row['deskripsi']}'
                                    data-harga='{$row['harga']}'
                                    data-gambar='{$row['id']} '
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
                                        <h5 class='modal-title' id='updateModalLabel'>Update Product</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <form action='update_product.php' method='POST' enctype='multipart/form-data'>
                                            <input type='hidden' name='product_id' value='{$row['id']}'>
                    
                                            <div class='mb-3'>
                                                <label for='updateNama' class='form-label'>Product Name:</label>
                                                <input type='text' class='form-control' id='updateNama' name='updateNama' value='{$row['nama_produk']}' required>
                                            </div>
                    
                                            <div class='mb-3'>
                                                <label for='updateDeskripsi' class='form-label'>Description:</label>
                                                <textarea class='form-control' id='updateDeskripsi' name='updateDeskripsi' rows='3'>{$row['deskripsi']}</textarea>
                                            </div>
                    
                                            <div class='mb-3'>
                                                <label for='updateHarga' class='form-label'>Price:</label>
                                                <input type='number' class='form-control' id='updateHarga' name='updateHarga' value='{$row['harga']}' required>
                                            </div>
                    
                                            <div class='mb-3'>
                                            <img src='data:image/jpeg;base64," . base64_encode($row['thum_produk']) . "' alt='Product Thumbnail'><br>
                                                <label for='updateGambar' class='form-label'>Update Image:</label>
                                                <input type='file' class='form-control' id='updateGambar' name='updateGambar' required>
                                            </div>
                    
                                            <!-- Add input fields for other product information -->
                    
                                            <button type='submit' class='btn btn-primary'>Save changes</button>
                                        </form>
                                    </div>
        
                                </div>
                            </div>
                        </div>";

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
                    window.location.href = 'delete_product.php?id=' + productId;
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
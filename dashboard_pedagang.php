<?php
require 'dbconfig.php';

$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
$dashboardLink = "";

if ($role === "pedagang") {
  $dashboardLink = "dashboard_pedagang.php";
} elseif ($role === "admin") {
  $dashboardLink = "dashboard_admin.php";
}

if (isset($_SESSION['id']) && $_SESSION['role'] == 'pedagang') {
  $pedagang_id = $_SESSION['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['status'])) {
      $status = ($_POST['status'] == 'on') ? 'Aktif' : 'Non-Aktif';
      $sql = "UPDATE pedagang SET status = '$status' WHERE id = $pedagang_id";
      if ($conn->query($sql) === TRUE) {
        echo "Status updated successfully.";
      } else {
        echo "Error updating status: " . $conn->error;
      }
    }
  }
} else {
  header("Location: main.php");
}

$dataPedagang = "SELECT * FROM pedagang WHERE ID_Pedagang= $pedagang_id";
$resData = mysqli_query($conn, $dataPedagang);
$rowData = mysqli_fetch_assoc($resData);
$idCategory = $rowData['ID_Kategori'];
$query_category = "SELECT nama_kategori FROM kategori WHERE ID_Kategori=$idCategory";
$resDataCategory = mysqli_query($conn, $query_category);
$rowDataCat = mysqli_fetch_assoc($resDataCategory);





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
  <link rel="stylesheet" href="style.css">

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

    .btn_masuk {
      background-color: #FD725C;
      color: #FFF;
      font-weight: 600;
      width: 100px;
      padding: 5px;
      font-size: 14px;
      border: none;
      text-decoration: none;
    }

    .form-check-input {
      background-color: #FFF;
    }

    .form-check-input:checked {
      background-color: #FD725C;
    }
  </style>
</head>


<body>
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between p-3 border-bottom sticky-top bg-light">
    <div class="col-md-3 col-sm-auto mb-2 ms-md-auto mb-md-0">
      <b>Dashboard Pedagang</b>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="#" class="nav-items-active px-2">Profil</a></li>
      <li><a href="tambah_produk.php" class="nav-items px-2">Tambah Produk</a></li>
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



  <div class="container profil-pedagang mt-4 mb-4">
    <h2 class="mb-3 mt-5">Profil</h2>
    <hr class="ms-auto me-auto mb-5" />
    <h6>Status Pedagang</h6>
    <div class="status-pedagang border-box mb-4">

      <div class="form-check form-switch">
        <?php
        $statusQuery = "SELECT status FROM pedagang WHERE ID_Pedagang = $pedagang_id";
        $result = $conn->query($statusQuery);

        if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          $currentStatus = $row['status'];

          // Set the value of the switch input based on the current status
          $isChecked = ($currentStatus == 'Aktif') ? 'checked' : '';

          echo '<input class="form-check-input" type="checkbox" name="status" id="flexSwitchCheckDefault" value="on" ' . $isChecked . '>';
        }
        ?>


        <label class="form-check-label " for="flexSwitchCheckDefault">
          <?php
          if ($currentStatus == 'Aktif') {
            echo "Aktif";
          } else {
            echo "Non-Aktif";
          } ?>
        </label>





      </div>
    </div>
    <h6>Nama Pedagang</h6>
    <div class="nama-pedagang border-box mb-4">

      <b><?php echo $rowData['Nama_Pedagang'] ?></b>

    </div>
    <h6>Nama Jajanan</h6>
    <div class="nama-jajanan border-box mb-4">

      <b><?php echo $rowData['Nama_Jajanan'] ?></b>

    </div>

    <h6>Deskripsi</h6>
    <div class="nama-deskripsi border-box mb-4">

      <p><?php echo $rowData['Deskripsi'] ?></p>

    </div>
    <h6>No Handphone/WhatsApp</h6>
    <div class="nama-hp border-box mb-4">

      <p><?php echo $rowData['No_HP'] ?></p>

    </div>

    <h6>Kategori</h6>
    <div class="kategori border-box mb-4">

      <p><?php echo $rowDataCat['nama_kategori'] ?></p>

    </div>
    <h6>Thumbnail</h6>
    <div class="thumbnail border-box mb-4">
      <?php if (!empty($rowData['Thumbnail'])) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($rowData['Thumbnail']) . '">';
      }
      ?>




    </div>

  </div>



  <script src="https://code.jquery.com/jquery-3.6.0.min.js">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua/C4z6Zaht6LeLZfJbf47P6KWpNMyW8jOG6Cr/Itg4PAO2E6b6uXMJXs" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function() {
      // Listen for the change event of the switch input
      $('#flexSwitchCheckDefault').change(function() {
        var status = this.checked ? 'on' : 'off';

        // Send an AJAX request to update the status
        $.post('update_status.php', {
          status: status
        }, function(response) {
          // You can handle the response here (e.g., display a success message)
          console.log(response);
        });
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var checkbox = document.getElementById('flexSwitchCheckDefault');
      var label = document.querySelector('.form-check-label');

      checkbox.addEventListener('change', function() {
        label.textContent = this.checked ? 'Aktif' : 'Non-Aktif';

      });
    });
  </script>
  <script>
    $(document).ready(function() {
      <?php
      // Check for success message in the session
      if (isset($_SESSION['success_message'])) {
        // Display SweetAlert for success
        echo "Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{$_SESSION['success_message']}',
            });";
        // Unset the session variable to avoid displaying the message on page reload
        unset($_SESSION['success_message']);
      } elseif (isset($_SESSION['error_message'])) {
        // Display SweetAlert for error
        echo "Swal.fire({
                icon: 'error',
                title: 'Error!',
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
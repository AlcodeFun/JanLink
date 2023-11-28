<?php
require 'dbconfig.php';

$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
$dashboardLink = "";
var_dump($_SESSION);
echo $_SERVER["REQUEST_METHOD"];

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
  </style>
</head>


<body>
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between p-3 border-bottom sticky-top bg-light">
    <div class="col-md-3 col-sm-auto mb-2 ms-md-auto mb-md-0">
      <b>Dashboard Pedagang</b>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="main.php" class="nav-items px-2">Beranda</a></li>
      <li><a href="#" class="nav-items px-2">Status</a></li>
      <li><a href="#" class="nav-items-active px-2">Produk</a></li>
    </ul>

    <div class="col-md-3 col-sm-auto text-end me-md-auto">
      <?php
      if (isset($_SESSION['id'])) {
        echo "<a type='button' class='btn_masuk  rounded-5 text-decoration-none text-center' href='logout.php'>Keluar</a>";
      } else {
        echo "<a type='button' class='btn_masuk rounded-5 text-decoration-none text-center' href='login.php'>Masuk</a>";
      }

      ?>

    </div>
  </header>



  <div class="container">
    <p>Status Pedagang</p>
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
      <label class="form-check-label" for="flexSwitchCheckDefault">Aktif/Non-Aktif</label>
    </div>
  </div>

  <!-- Pedagang Table -->
  <!-- <div id="pedagang-table" class="container mt-3">
    <h2>Pedagang Table</h2>
    <div class="container mt-5"> -->

  <!-- Display table -->
  <!-- <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Merchant ID</th>
              <th>Thumbnail</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="productTableBody"> -->
  <!-- Table data will be loaded here using AJAX -->
  <!-- </tbody>
        </table>
      </div> -->

  <!-- Modal for Add and Edit Product -->
  <!-- <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true"> -->
  <!-- Modal content will be loaded here using AJAX -->
  <!-- </div>
    </div>
  </div> -->

  <!-- Produk Table -->
  <!-- <div id="produk-table" class="container mt-3">
    <h4>Produk Table</h4>
    <div class="container">
      <h6>Tambah Produk</h6>
      <form action="server-pedagang.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nama_produk">Nama Produk:</label>
          <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
        </div>
        <div class="form-group">
          <label for="deskripsi">Deskripsi:</label>
          <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
        </div>
        <div class="form-group">
          <label for="harga">Harga:</label>
          <input type="number" class="form-control" name="harga" id="harga" required>
        </div>
        <div class="form-group">
          <label for="gambar_produk">Gambar Produk</label>
          <input type="file" class="form-control-file" name="gambar_produk" id="gambar_produk" required>
        </div>
        <button type="submit" class="btn btn-primary">Insert</button>
      </form>
    </div>
  </div> -->

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
  <script src="pedagang-crud.js"></script>

</body>
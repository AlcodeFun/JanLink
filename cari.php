<?php
session_start();
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
$dashboardLink = "";

if ($role === "pedagang") {
  $dashboardLink = "dashboard_pedagang.php";
} elseif ($role === "admin") {
  $dashboardLink = "dashboard_admin.php";
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
  <link rel="stylesheet" href="style.css" />
  <!-- Font Awesome Kit -->
  <script src="https://kit.fontawesome.com/05f405bcb5.js" crossorigin="anonymous"></script>
</head>

<body>
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between p-3 border-bottom sticky-top bg-light">
    <div class="col-md-3 col-sm-auto mb-2 ms-md-auto mb-md-0">
      <img src="assets/logo-janlink.png" alt="" />
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="main.php" class="nav-items px-2">Beranda</a></li>
      <li><a href="jajanan.php" class="nav-items px-2">Jajanan</a></li>
      <li><a href="#" class="nav-items-active px-2">JanAI</a></li>
      <?php
      if ($role === "pedagang") {
        echo '<li><a href="dashboard_pedagang.php" class="nav-items px-2">Dashboard</a></li>';
      } elseif ($role === "admin") {
        echo '<li><a href="dashboard_admin.php" class="nav-items px-2">Dashboard</a></li>';
      }
      ?>
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

  <div class="search-box d-flex align-items-center justify-content-center">
    <div class="container text-center">
      <h1>Mau cari jajan?</h1>
      <p class="mb-5">Temukan jajanan yang kamu mau disini</p>
      <form class="form-cari d-flex justify-content-center" role="search">
        <input class="form-control me-2" type="search" placeholder="Cari Jajanan" aria-label="Search" />
        <button class="form-cari-btn btn btn-danger" type="submit">
          <i class="fa-solid fa-magnifying-glass me-2" style="color: #ffffff"></i>Cari
        </button>
      </form>
    </div>
  </div>

  <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 border-top justify-content-center align-items-start">
    <div class="col mb-3 p-4 rounded-3 mt-4" style="background-color: white;">

      <a href="#" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
        <img width="" src="assets/logo-janlink.png" alt="" />
      </a>
      <p class="text-body-secondary text-justify">
        JanLink merupakan sebuah website penguhubung antara pedagang keliling
        dan pembeli di sekitar Kota Bogor berbasis GIS
      </p>


    </div>

    <div class="col mb-3 ms-5 mt-4">
      <h5>Menu</h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Beranda</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Jajanan</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Cari Jajan</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Dashboard</a>
        </li>
      </ul>
    </div>

    <div class="col mb-3 ms-5 mt-4">
      <h5>Kontak</h5>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Home</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Features</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">Pricing</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">FAQs</a>
        </li>
        <li class="nav-item mb-2">
          <a href="#" class="nav-link p-0 text-body-secondary">About</a>
        </li>
      </ul>
    </div>

    <div class="col mb-3 ms-4 mt-4">
      <h5 class="ms-2">Ikuti Kami</h5>
      <ul class="nav list-unstyled">
        <li class="ms-3">
          <a class="text-body-secondary" href="#"><i class="fa-brands fa-instagram"></i></a>
        </li>
        <li class="ms-3">
          <a class="text-body-secondary" href="#"><i class="fa-brands fa-youtube"></i></a>
        </li>
        <li class="ms-3">
          <a class="text-body-secondary" href="#"><i class="fa-brands fa-twitter"></i></a>
        </li>
      </ul>
    </div>
    <p class="text-center text-body-secondary">&copy; 2023 Company, Inc</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
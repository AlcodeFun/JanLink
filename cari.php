<?php
require 'dbconfig.php';
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

  <style>
    .result-search {
      display: none;
    }
  </style>
</head>

<body>
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between p-3 border-bottom sticky-top bg-light">
    <div class="col-md-3 col-sm-auto mb-2 ms-md-auto mb-md-0">
      <img src="assets/logo-janlink.png" alt="" />
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="main.php" class="nav-items px-2">Beranda</a></li>
      <li><a href="jajanan.php" class="nav-items px-2">Jajanan</a></li>
      <li><a href="cari.php" class="nav-items-active px-2">JanAI</a></li>
      <?php
      if ($role === "pedagang") {
        echo '<li><a href="dashboard_pedagang.php" class="nav-items px-2">Dashboard</a></li>';
      } elseif ($role === "admin") {
        echo '<li><a href="dashboardAdmin/home.php" class="nav-items px-2">Dashboard</a></li>';
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
      <div class="container">
        <form id="searchForm" class="form-cari">

          <div class="row me-4">
            <div class="col-md-8 mb-2">
              <input style="height: 50px; width: 100%;" id="searchInput" class="form-control" type="search" placeholder="Cari Jajanan" aria-label="Search" name="cari" />
            </div>

            <div class="col-md-4">
              <button class="form-cari-btn btn btn-danger" type="submit" style="height: 50px; width: 100%;">
                <i class="fa-solid fa-magnifying-glass me-2" style="color: #ffffff"></i>Cari
              </button>
            </div>
          </div>

        </form>
      </div>



    </div>
  </div>
  <?php
  $res_aktif = null; // Initialize $res_aktif to null

  if (isset($_GET['cari'])) {
    $updateRating = "UPDATE pedagang AS p
          JOIN (
              SELECT ID_Pedagang, AVG(rating) AS avg_rating
              FROM ulasan
              GROUP BY ID_Pedagang
          ) AS u
          ON p.ID_Pedagang = u.ID_Pedagang
          SET p.Rating = u.avg_rating";

    // Execute the rating update query
    $conn->query($updateRating);
    $query_pedagang_aktif = "SELECT * FROM pedagang WHERE Nama_Jajanan LIKE '%{$_GET['cari']}%'";
    $res_aktif = $conn->query($query_pedagang_aktif);
  }


  ?>
  <div class="mb-4" style="height: 60px;" id="result-search"></div>

  <div class=" result-search mt-5 col">

    <div class="col">
      <div class="row rekomendasi d-flex justify-content-center mt-5 mb-5" style="height: 600px; overflow:auto;">


        <div class="result-search mt-5">
          <?php
          if (!is_null($res_aktif) && mysqli_num_rows($res_aktif) > 0 && isset($_GET['cari'])) {
            echo '<h2>Rekomendasi Untukmu</h2>';
            echo '<hr class="ms-auto me-auto mb-5">';
            echo '<div class="row rekomendasi d-flex justify-content-center mt-5 mb-5 ms-auto me-auto">';
            while ($row_aktif = $res_aktif->fetch_assoc()) {
          ?>
              <div class="col-md-4 mb-sm-5 d-flex justify-content-center">
                <div class="card">
                  <div class="container p-4">
                    <div class="imgCard">
                      <?php echo '<img class="img-fluid img-thumbnail" src="data:image/jpeg;base64,' . base64_encode($row_aktif['Thumbnail']) . '">'; ?>
                    </div>
                    <div class="card-content text-start mt-2">
                      <span class="active-status <?php echo $textcolor = ($row_aktif['Status'] == 'Aktif') ? 'text-success' : 'text-danger '; ?> fw-medium"><?php echo $row_aktif['Status'] ?></span>
                      <h6><?php echo $row_aktif['Nama_Jajanan'] ?></h6>
                      <p style="overflow:hidden; height:25px;"><?php echo $row_aktif['Deskripsi'] ?></p>
                      <div class="row">
                        <div class="col-4">
                          <i class="fa-solid fa-star fa-bounce" style="color: #ffca0b"></i>
                          <span class="rating"><?php echo $row_aktif['Rating'] ?></span>
                        </div>
                        <div class="col-8">
                          <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-3">
                              <a href="https://wa.me/<?php echo $row_aktif['No_HP'] ?>">
                                <i class="fa-brands fa-square-whatsapp fa-xl" style="color: #2ff957; width: 30px"></i>
                              </a>
                            </div>
                            <div class="col-9">
                              <button class="rounded-5 btn-detail">
                                <a class="btn-detail-text text-decoration-none text-light" href="detail.php?jajanan=<?php echo $row_aktif['Nama_Jajanan'] ?>">Lihat Detail</a>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php
            }
            echo '</div>';
          } else if (isset($_GET['cari'])) {

            echo '<img class="img-fluid w-100 mt-6" src="assets/not_found.png" alt="" />';
          }
          ?>
        </div>
      </div>
    </div>



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

  <!-- Add this script at the end of your HTML body -->
  <script>
    // Function to handle the search
    function searchPedagang() {
      // Get the search term from the input field
      var searchTerm = document.getElementById('searchInput').value;

      // Reload the page with the search term as a query parameter
      window.location.href = 'cari.php?cari=' + encodeURIComponent(searchTerm) + '#result-search';
    }

    // Add an event listener to trigger the search when the form is submitted
    document.getElementById('searchForm').addEventListener('submit', function(event) {
      event.preventDefault();
      searchPedagang();
    });

    // Check if there is a hash in the URL and scroll to the corresponding element
    window.onload = function() {
      var hash = window.location.hash;
      if (hash) {
        var element = document.querySelector(hash);
        if (element) {
          element.scrollIntoView({
            behavior: 'smooth'
          });
        }
      }

      // Show the result-search div after the page has loaded
      document.querySelector('.result-search').style.display = 'block';
    };
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
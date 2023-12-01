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
  <div class="result-search ">


    <div class="row active-pedagang d-flex justify-content-center mt-5 mb-4">

      <?php
      if (mysqli_num_rows($res_aktif) > 0 && isset($_GET['cari'])) {
        while ($row_aktif = $res_aktif->fetch_assoc()) {
      ?>
          <div class="col-md-12 mb-sm-4 d-flex justify-content-center">
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
      <?php }
      } else {
        echo "</div>";
        echo '<img class="img-fluid w-100 mt-6" src="assets/no-active.png" alt="" />';
      } ?>


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

      // Send an AJAX request to the PHP script with POST method
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Parse the JSON response
          var results = JSON.parse(xhr.responseText);

          // Update the HTML content based on the search results
          updateSearchResults(results);
        }
      };
      xhr.open('POST', 'search_pedagang.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send('term=' + searchTerm);
    }

    // Function to update HTML content based on search results
    function updateSearchResults(results) {
      var container = document.getElementById('searchResultsContainer');

      // Clear previous results
      container.innerHTML = '';

      // Check if there are any results
      if (results.length > 0) {
        // Render the cards for each result
        results.forEach(function(product) {
          container.innerHTML += `
                <div class="col-lg-3 col-md-4 col-sm-12 mb-sm-4 d-flex justify-content-center">
                  <div class="card">
                    <div class="container p-4">
                      <div class="imgCard">
                        <img class="img-fluid img-thumbnail" src="${product.Thumbnail}" alt="" />
                      </div>
                      <div class="card-content text-start mt-2">
                        <span class="active-status ${product.Status === 'Aktif' ? 'text-success' : 'text-danger'} fw-medium">${product.Status}</span>
                        <h6>${product.Nama_Jajanan}</h6>
                        <p style="height:25px; overflow:hidden;">${product.Deskripsi}</p>
                        <div class="row">
                          <div class="col-4">
                            <i class="fa-solid fa-star fa-bounce" style="color: #ffca0b"></i>
                            <span class="rating">${product.Rating}</span>
                          </div>
                          <div class="col-8">
                            <div class="row d-flex justify-content-center align-items-center">
                              <div class="col-3">
                                <a href="https://wa.me/${product.No_HP}">
                                  <i class="fa-brands fa-square-whatsapp fa-xl" style="color: #2ff957; width: 30px"></i>
                                </a>
                              </div>
                              <div class="col-9">
                                <button class="rounded-5 btn-detail">
                                  <a class="btn-detail-text" href="detail.php?jajanan=${product.Nama_Jajanan}">Lihat Detail</a>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              `;;
        });
      } else {
        // No matches found, display a message
        container.innerHTML = '<p>No match found</p>';
      }
    }

    // Add an event listener to trigger the search when the form is submitted
    document.getElementById('searchForm').addEventListener('submit', function(event) {
      event.preventDefault();
      searchPedagang();
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
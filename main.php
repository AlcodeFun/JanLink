<?php
require 'dbconfig.php';
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
$dashboardLink = "";



if ($role === "pedagang") {
  $dashboardLink = "dashboard_pedagang.php";
  $ID_Pedagang = $_SESSION['id'];
} elseif ($role === "admin") {
  $dashboardLink = "dashboard_admin.php";
  $ID_Pembeli = $_SESSION['id'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>JanLink</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/assets/favicon-janlink.png" />
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
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    .slick-prev:before {
      color: #ffca0b;
      width: 200px;
    }

    .slick-next:before {
      color: #ffca0b;
      width: 200px;
    }
  </style>

</head>

<body>
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between p-3 border-bottom sticky-top bg-light">
    <div class="col-md-3 col-sm-auto mb-2 ms-md-auto mb-md-0">
      <img src="assets/logo-janlink.png" alt="" />
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="main.php" class="nav-items-active px-2">Beranda</a></li>
      <li><a href="jajanan.php" class="nav-items px-2">Jajanan</a></li>
      <li><a href="cari.php" class="nav-items px-2">JanAI</a></li>
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

  <div class="content-1">
    <div class="row">
      <div class="col-lg-6 col-sm-12 d-flex justify-content-center align-items-center mt-4" style="min-height:500px ;">
        <div class="row">
          <div class="col">
            <h1>Mau Jajan?</h1>
            <p>Dengan beberapa klik, temukan jajanan di sekitarmu</p>
            <form action="cari.php?cari=<?php if (isset($_GET['cari'])) {
                                          echo $_GET['cari'];
                                        } ?>#result-search" class="d-flex bg-light p-4 rounded-3 w-100" role="search">
              <input class="form-control me-2" type="search" placeholder="Cari Jajanan" aria-label="Search" name="cari" />
              <button class="form-cari-btn btn btn-danger" type="submit>
                <i class=" fa-solid fa-magnifying-glass me-2" style="color: #ffffff"></i>Cari
              </button>
            </form>
          </div>
        </div>
        <div class="row"></div>
        <div class="row"></div>
      </div>
      <div class="col-lg-6 col-sm-12 d-flex justify-content-end align-items-end mt-5">
        <img class="imgContent1 img-fluid" style="max-height: 500px;" src="assets/img-content1.png" alt="" />
      </div>
    </div>
  </div>

  <?php
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
  $query_pedagang_aktif = "SELECT * FROM pedagang WHERE Status = 'Aktif'";
  $res_aktif = $conn->query($query_pedagang_aktif);


  ?>
  <div class="content-2 container">
    <h2 class="mb-3 mt-5">Pedagang Aktif</h2>
    <hr class="ms-auto me-auto mb-5" />
    <div class="row active-pedagang d-flex justify-content-center">

      <?php
      if (mysqli_num_rows($res_aktif) > 0) {
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

  </div>

  <div class="content-3 d-flex-column justify-content-center mb-4">
    <h2 class="mb-3 mt-5">Pedagang di sekitarmu</h2>
    <hr class="ms-auto me-auto mb-5" />
    <div class="container near-pedagang" style="height: 400px; width: 100%">


    </div>
    <div class="row d-flex ">
      <div class="col mt-4 d-flex justify-content-center">
        <button class="btn btn-danger p-3" id="refreshButton">Perbarui Pedagang di Sekitar</button>
      </div>
    </div>
  </div>

  <div class="content-4">

    <!-- ***** Features Small Start ***** -->
    <section class="section home-feature p-5">
      <div class="container p-4 d-flex" style="background-color: #ffffff;box-shadow: 0.5px 0.5px 0.5px #393535;border-radius:30px;">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-12">
            <div class="row">
              <!-- ***** Features Small Item Start ***** -->
              <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.2s">
                <div class="features-small-item">
                  <div class="icon mb-3">
                    <i><img src="assets/adv-1.png" alt=""></i>
                  </div>
                  <h5 class="features-title">Lokasi</h5>
                  <p> Anda dapat melihat lokasi terkini pedagang keliling</p>
                </div>
              </div>
              <!-- ***** Features Small Item End ***** -->

              <!-- ***** Features Small Item Start ***** -->
              <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.4s">
                <div class="features-small-item">
                  <div class="icon mb-3">
                    <i><img src="assets/adv-2.png" alt=""></i>
                  </div>
                  <h5 class="features-title">Hemat Tenaga & Waktu</h5>
                  <p>Tak perlu repot mencari. Ketahui lokasi atau panggil jajanan favoritmu</p>
                </div>
              </div>
              <!-- ***** Features Small Item End ***** -->

              <!-- ***** Features Small Item Start ***** -->
              <div class="col-lg-4 col-md-6 col-sm-6 col-12" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.6s">
                <div class="features-small-item">
                  <div class="icon mb-3">
                    <i><img src="assets/adv-3.png" alt=""></i>
                  </div>
                  <h5 class="features-title">Ultimate Marketing</h5>
                  <p> Informasi akurat mulai dari informasi produk hingga lokasi</p>
                </div>
              </div>
              <!-- ***** Features Small Item End ***** -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ***** Features Small End ***** -->
  </div>



  <div class="container mb-5 d-flex justify-content-center">
    <div class="go-to-search container">
      <div class="row">
        <div class="col-md-6 col-sm-12 justify-content-center">
          <img src="assets/nasgor.png" alt="" class="img-fluid" />
        </div>
        <div class="col-md-6 col-sm-12 justify-content-center">
          <h1>"Ingin Cari Saya?"</h1>
          <p>Klik tombol di bawah ini</p>
          <a href="cari.php" class="btn btn-danger">Cari Pedagang Keliling</a>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script>
    // JavaScript to handle button click and page refresh
    document.getElementById('refreshButton').addEventListener('click', function() {
      location.reload(true); // true parameter forces a full page reload from the server
    });
  </script>
  <script>
    $('.active-pedagang').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 2,
      responsive: [{
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            arrows: false
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
  </script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUSgX6T6vbH3lPftFDqw2-0_HXkrwFtHU&callback=initMap" defer></script>

  <script>
    document.addEventListener('DOMContentLoaded', getLocation);

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(initMap);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    function initMap(position) {
      var userLatitude = position.coords.latitude;
      var userLongitude = position.coords.longitude;

      var map = new google.maps.Map(document.querySelector('.near-pedagang'), {
        center: {
          lat: userLatitude,
          lng: userLongitude
        },
        zoom: 15
      });

      // Fetch nearby pedagang locations
      $.ajax({
        type: "POST",
        url: "get-near-pedagang.php",
        data: {
          latitude: userLatitude,
          longitude: userLongitude
        },
        success: function(response) {
          // Parse the JSON response
          var nearPedagang = JSON.parse(response);

          // Add markers for nearby pedagang
          nearPedagang.forEach(function(pedagang) {
            // Specify the path to the custom marker icon image
            var customMarkerIcon = {
              url: 'assets/markerIcon.png',
              scaledSize: new google.maps.Size(50, 50) // Adjust the width and height as needed
            };

            // Create a marker with a custom icon
            var marker = new google.maps.Marker({
              position: {
                lat: parseFloat(pedagang.Latitude),
                lng: parseFloat(pedagang.Longitude)
              },
              map: map,
              title: pedagang.Nama_Jajanan,
              icon: customMarkerIcon
            });

          });
        },
        error: function(error) {
          console.log("Error:", error);
        }
      });
    }
  </script>


</body>

</html>
<?php
require 'dbconfig.php';
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
$dashboardLink = "";

if ($role === "pedagang") {
  $dashboardLink = "dashboard_pedagang.php";
} elseif ($role === "admin") {
  $dashboardLink = "dashboard_admin.php";
}


$query = "SELECT ID_Kategori, nama_kategori, gambar_kategori FROM kategori";
$result = $conn->query($query);

if (!$result) {
  die("Query failed: " . $mysqli->error);
}
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

$queryAllJajanan = "SELECT * FROM pedagang";
$resAllJajanan = $conn->query($queryAllJajanan);


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
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- CSS Slick edit -->
  <!-- ... (previous HTML code) ... -->
  <!-- CSS Slick edit -->
  <style>
    .slick-prev:before {
      color: #ffca0b;
      width: 200px;
    }

    .slick-next:before {
      color: #ffca0b;
      width: 200px;
    }

    /* Center the images in the carousel items */
    .slider .col-md-12 {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 30px;
      /* Add this line */
      align-items: center;
      text-align: center;
      background-color: white;
      border-radius: 20px;

    }


    .slider img {
      max-width: 100%;
      margin: 0 auto;
      /* Add this line to center horizontally within the column */
    }

    .slider {
      width: 90%;
      margin: auto;
    }

    .container-pedagang {
      max-height: 600px;
      /* Set the maximum height for vertical scrolling */
      overflow: auto;
      /* Enable scrolling when content overflows */
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .container-pedagang::-webkit-scrollbar {
      display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .container-pedagang {
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */
    }

    .prodoct-description {
      height: 25px;
      overflow: hidden;
    }
  </style>
</head>


</head>

<body>
  <!-- Header -->
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
  <div class="kategori-jajanan">
    <h2 class="text-center mt-5 mb-4">Kategori Jajanan</h2>
    <hr />
    <div class="container mt-5">
      <div class="row slider d-flex justify-content-center">
        <?php while ($row = $result->fetch_assoc()) { ?>
          <div class="col-md-12 kategori text-center mx-auto" data-kategori-id="<?php echo $row['ID_Kategori']; ?>">
            <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar_kategori']) . '">'; ?>
            <p class="mt-4"><?php echo $row['nama_kategori'] ?> </p>
          </div>
        <?php } ?>




      </div>
    </div>
  </div>


  <div class="all-jajanan">
    <h2 class="text-center mt-5 mb-4">Semua Jajanan</h2>
    <hr />

    <div class="container">
      <div class="row container-pedagang mb-5">


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
      $('.slider').slick({
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


    <!-- Update your JavaScript code to handle category selection based on ID_Kategori -->
    <script>
      $(document).ready(function() {
        // Function to fetch and display all products
        function displayAllProducts() {
          $.ajax({
            type: 'POST',
            url: 'get_pedagang.php', // Create a PHP script to fetch all products
            dataType: 'json',
            success: function(data) {
              if (data.error) {
                console.log(data.error);
              } else {
                // Clear the product container
                $('.container-pedagang').empty();

                // Populate the product container with all products
                $.each(data, function(index, product) {
                  var productCard = `
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
              `;
                  $('.container-pedagang').append(productCard);
                });
              }
            },
            error: function() {
              console.log('Ajax request failed');
            }
          });
        }

        // Initial display of all products
        displayAllProducts();

        // When a category card is clicked
        $('.kategori').click(function() {
          var selectedCategoryID = $(this).data('kategori-id');

          // Send an Ajax request to the PHP script to fetch products by ID_Kategori
          $.ajax({
            type: 'POST',
            url: 'get_pedagang.php',
            data: {
              kategori_id: selectedCategoryID
            },
            dataType: 'json',
            success: function(data) {
              if (data.error) {
                console.log(data.error);
              } else {
                // Clear the product container
                $('.container-pedagang').empty();

                // Populate the product container with products
                $.each(data, function(index, product) {
                  var productCard = `
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
              `;
                  $('.container-pedagang').append(productCard);
                });
              }
            },
            error: function() {
              console.log('Ajax request failed');
            }
          });
        });
      });
    </script>




</body>

</html>
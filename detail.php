<?php
require 'dbconfig.php';
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "";
$isPedagang = $role === "pedagang" && isset($_SESSION['id']);





if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['jajanan'])) {
    $nama_jajanan = $_GET['jajanan'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM pedagang WHERE Nama_Jajanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama_jajanan);

    if ($stmt->execute()) {
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        // Fetch the data
        $row = $result->fetch_assoc();
        // You can use this data to populate your HTML template

        // For example:
        // If the user is a pedagang, retrieve the latitude and longitude

        $pedagangLatitude = $row['Latitude'];  // Replace 'Latitude' with the actual column name in your database
        $pedagangLongitude = $row['Longitude'];  // Replace 'Longitude' with the actual column name in your database

        $PedagangID = $row['ID_Pedagang'];
        $namaJajanan = $row['Nama_Jajanan'];
        $deskripsi = $row['Deskripsi'];
        $noHP = $row['No_HP'];
        $thumbnail = $row['Thumbnail'];
        $rute = $row['Rute'];
        $status = $row['Status'];
        $rating = $row['Rating'];



        $getproduct = "SELECT nama_produk, deskripsi, harga, thum_produk FROM produk WHERE ID_Pedagang=$PedagangID";
        $resProduct = $conn->query($getproduct);

        $getUlasan = "SELECT username,ulasan,rating,tanggal_ulasan FROM ulasan WHERE ID_Pedagang=$PedagangID";
        $resUlasan = $conn->query($getUlasan);
      } else {
        echo "No results found for the given 'jajanan' parameter.";
      }
    } else {
      echo "Query execution failed.";
    }

    // You can use the retrieved data in your HTML template
    // Populate the HTML template with data...
  } else {
    echo "The 'jajanan' parameter is not set.";
  }
} else {
  // Redirect to jajan.php when the request method is not GET
  header("Location: jajanan.php");
  exit; // Make sure to exit to prevent further execution
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
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <style>
    .img-detail {
      width: 100%;
      height: 605px;
      background-image: url("data:image/jpeg;base64,<?php echo base64_encode($thumbnail); ?>");
      background-size: cover;
    }

    .overflow-container {
      max-height: 500px;
      /* Set the maximum height for vertical scrolling */
      overflow: auto;
      /* Enable scrolling when content overflows */
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .overflow-container::-webkit-scrollbar {
      display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .overflow-container {
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */
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

  <div class="img-detail d-flex justify-content-start align-items-end">
    <div class="description-detail">
      <div class="row align-items-center">
        <div class="col-md-10">
          <h1><?php echo $namaJajanan; ?></h1>
        </div>
        <div class="col-md-2">
          <b>
            <p class="<?php echo $textcolor = ($status == 'Aktif') ? 'text-success' : 'text-danger '; ?>"><?php echo $status; ?></p>
          </b>
        </div>
      </div>
      <div class="description-text">
        <p>
          <?php echo $deskripsi; ?>
        </p>
      </div>

      <div class="description-contact">
        <a href="https://wa.me/<?php echo $noHP; ?>" class="btn btn-danger rounded-3"><i class="fa-brands fa-square-whatsapp fa-xl" style="color: #2ff957; width: 30px"></i>
          Pesan</a>
      </div>
    </div>
  </div>

  <div class="sec-nav d-flex align-items-center">
    <nav class="nav">
      <a class="nav-link active" aria-current="page" href="#location">Lokasi Terkini</a>
      <a class="nav-link" href="#route">Rute Keliling</a>
      <a class="nav-link" href="#all-products">Semua Jajanan</a>
      <a class="nav-link" href="#review">Ulasan</a>
    </nav>
  </div>

  <nav class="ms-2 bg-light" style="
        --bs-breadcrumb-divider: url(
          &#34;data:image/svg + xml,
          %3Csvgxmlns='http://www.w3.org/2000/svg'width='8'height='8'%3E%3Cpathd='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z'fill='currentColor'/%3E%3C/svg%3E&#34;
        ); height:40px;
      " aria-label="breadcrumb">
    <ol class="breadcrumb d-flex align-items-center">
      <li class="breadcrumb-item"><a href="jajanan.php" class="text-decoration-none text-dark">Jajanan</a></li>

      <li class="breadcrumb-item active" aria-current="page">
        <?php echo $nama_jajanan; ?>
      </li>
    </ol>
  </nav>

  <div class="location">
    <h2 class="mb-3 mt-5" id="location">Lokasi Terkini</h2>
    <hr class="ms-auto me-auto mb-5" />

    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12 d-flex justify-content-center align-items-center mb-4">
          <button class="btn btn-danger p-3 me-3 " id="get-location">Dapatkan Lokasi</button> <br>
          <button class="btn btn-danger p-3 " id="refreshButton">Perbarui Lokasi Pedagang</button>
        </div>
        <div class="col-md-6 col-sm-12">
          <div id="map" style="height: 400px; width: 100%"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="route">
    <div class="container p-4">
      <h2 class="mb-3 mt-5" id="route">Rute Keliling</h2>
      <hr class="ms-auto me-auto mb-5" />

      <div class="container">
        <div class="row">
          <div class="col">
            <?php echo '<img style="width: 100%; height:75%;" src="data:image/jpeg;base64,' . base64_encode($rute) . '">'; ?>
          </div>


        </div>
      </div>
    </div>
  </div>

  <div class="all-products overflow-container" id="all-products">
    <h2 class="mb-3 mt-5" id="route">Semua Jajanan</h2>
    <hr class="ms-auto me-auto mb-5" />
    <div class="container">
      <?php while ($rowProduct = $resProduct->fetch_assoc()) { ?>
        <div class="product-card mb-5">
          <div class="row">
            <div class="col-md-3 col-sm-12">
              <?php echo '<img style="width:125px;" src="data:image/jpeg;base64,' . base64_encode($rowProduct['thum_produk']) . '">'; ?>
            </div>
            <div class="col-md-3 col-sm-12">
              <h3><?php echo $rowProduct['nama_produk']; ?></h3>
              <p><?php echo $rowProduct['deskripsi']; ?></p>
            </div>
            <div class="col-md-6 col-sm-12 text-danger d-flex align-items-center justify-content-start">
              <h1>Rp <?php echo $rowProduct['harga']; ?></h1>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>


  <div class="review container" id="review">
    <h2 class="mb-3 mt-5">Ulasan</h2>
    <hr class="ms-auto me-auto mb-5" />
    <?php if ($role === "pembeli") { ?>
      <a href="input_ulasan.php?jajanan=<?php echo $nama_jajanan; ?>" class="btn btn-danger w-100">Berikan Ulasan</a>
    <?php } else { ?>
      <p class="text-danger text-center">Anda harus login sebagai pembeli untuk memberikan ulasan.</p>
    <?php } ?>
    <div class="container overflow-container">

      <?php while ($rowUlasan = $resUlasan->fetch_assoc()) { ?>
        <div class="review-card mb-5 mt-4">
          <div class="row">
            <div class="col-md-3 col-sm-12 p-4 justify-content-center d-flex justify-content-center align-items-center">
              <img class="img-thumbnail" src="assets/avatar.png" alt="" />
            </div>
            <div class="col-md-3 col-sm-12">
              <h3><?php echo $rowUlasan['username']; ?></h3>
              <p><?php echo $rowUlasan['ulasan'] ?></p>
              <?php for ($i = 1; $i <= $rowUlasan['rating']; $i++) { ?>
                <i class="fa-solid fa-star fa-bounce" style="color: #ffca0b"></i>
              <?php } ?>
            </div>
            <div class="col-md-6 col-sm-12 text-danger d-flex align-items-center justify-content-start">
              <p><?php echo $rowUlasan['tanggal_ulasan']; ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDUSgX6T6vbH3lPftFDqw2-0_HXkrwFtHU&callback=initMap" defer></script>
  <script>
    // JavaScript to handle button click and page refresh
    document.getElementById('refreshButton').addEventListener('click', function() {
      location.reload(true); // true parameter forces a full page reload from the server
    });
  </script>
  <script>
    // Initialize the map with the marker variable declared
    let map;
    let mapMarker;

    $(document).ready(function() {
      // Assuming you have an id, replace '123' with the actual id value
      var id = <?php echo $PedagangID ?>;

      // Make an AJAX request to the PHP script with the id parameter using the POST method
      $.ajax({
        url: 'get-location.php',
        type: 'POST',
        data: {
          id: id
        },
        dataType: 'json',
        success: function(data) {
          // Store latitude and longitude in variables
          const getlatitude = data.Latitude;
          const getlongitude = data.Longitude;

          console.log(getlatitude);
          console.log(getlongitude);

          // Initialize the map after the latitude and longitude are obtained
          initMap(getlatitude, getlongitude);

          // Set an interval to update the marker position every 30 seconds (adjust as needed)
          setInterval(function() {
            updateMarkerPosition(getlatitude, getlongitude);
          }, 30000); // Update every 30 seconds
          // Add an event listener to the "Get Location" button
          document.getElementById('get-location').addEventListener('click', function() {
            var mapLink = `https://www.google.com/maps/dir/?api=1&destination=${getlatitude},${getlongitude}`;
            // Open the link in a new tab or window
            window.open(mapLink, '_blank');
          });
        },
        error: function(error) {
          console.log('Error:', error);
        }
      });
    });

    /// Function to update the marker position on the map
    function updateMarkerPosition(latitude, longitude) {
      // Check if the map and marker are initialized
      if (map && mapMarker) {
        // Create a LatLng object with the new coordinates
        const newLatLng = new google.maps.LatLng(latitude, longitude);

        // Update the marker position
        mapMarker.setPosition(newLatLng);

        // Center the map on the new marker position
        map.setCenter(newLatLng);
      }
    }

    function initMap(latitude, longitude) {
      // Convert latitude and longitude to numbers
      const lat = parseFloat(latitude);
      const lng = parseFloat(longitude);

      // Check if the conversion was successful
      if (!isNaN(lat) && !isNaN(lng)) {
        const pedagangLocation = {
          lat,
          lng
        };

        // Create the map using the appropriate location
        map = new google.maps.Map(document.getElementById("map"), {
          center: pedagangLocation,
          zoom: 20,
        });

        var customMarkerIcon = {
          url: 'assets/markerIcon.png',
          scaledSize: new google.maps.Size(60, 60) // Adjust the width and height as needed
        };
        // Create the marker here
        mapMarker = new google.maps.Marker({
          position: pedagangLocation,
          map,
          icon: customMarkerIcon


        });

        <?php if ($role == "pedagang" && $_SESSION['id'] == $PedagangID) {
          echo "watchLocation()";
        }
        ?>
      } else {
        console.error("Invalid latitude or longitude values.");
      }
    }

    console.log("Test");

    function watchLocation() {
      console.log("Testing if this runs");

      if (navigator.geolocation) {
        function updateLocation(position) {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;

          console.log('Updated Latitude:', latitude);
          console.log('Updated Longitude:', longitude);

          // Update the marker's position
          mapMarker.setPosition({
            lat: latitude,
            lng: longitude
          });

          // Send the location data to the server using AJAX
          const user_id = <?php echo $PedagangID; ?>;
          const data = {
            latitude,
            longitude,
            user_id
          };
          console.log('Before fetch');
          fetch('update-location.php', {
              method: 'POST',
              body: JSON.stringify(data),
              headers: {
                'Content-Type': 'application/json',
              },
            })
            .catch((error) => {
              console.error('Fetch Error:', error);
            });
        }
        console.log('After fetch');

        function locationError(error) {
          console.error('Geolocation Error:', error);
        }

        const options = {
          enableHighAccuracy: true
        };

        // Set an interval to update the location every 30 seconds
        setInterval(() => {
          navigator.geolocation.getCurrentPosition(updateLocation, locationError, options);
        }, 30000);
      } else {
        console.error("Geolocation is not supported by your browser.");
      }
    }
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
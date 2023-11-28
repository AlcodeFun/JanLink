<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Database connection (update with your database details)
  $dbHost = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $dbName = "janlink";

  $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Retrieve data from the form
  $username = $_POST["username"];
  $email = $_POST["email"];
  // Hash the password securely
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
  $nama_pedagang = $_POST["nama_pedagang"];
  $nama_jajanan = $_POST["nama_jajanan"];
  $deskripsi = $_POST["deskripsi"];
  $no_hp = $_POST["no_hp"];
  $id_kategori = $_POST["id_kategori"];

  // Process uploaded files (thumbnail and rute)
  $thumbnail = $_FILES["thumbnail"]["tmp_name"];
  $rute = $_FILES["rute"]["tmp_name"];

  // Check if file uploads are valid
  if (is_uploaded_file($thumbnail) && is_uploaded_file($rute)) {
    $thumbnailContent = file_get_contents($thumbnail);
    $ruteContent = file_get_contents($rute);

    // SQL query to insert data into the database
    $sql = "INSERT INTO Pedagang (ID_Role, Username, Email, PasswordHash, Nama_Pedagang, Nama_Jajanan, Deskripsi, No_HP, ID_Kategori, Thumbnail, Rute) VALUES (2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
      // Bind parameters and execute the statement
      mysqli_stmt_bind_param($stmt, "ssssssssss", $username, $email, $password, $nama_pedagang, $nama_jajanan, $deskripsi, $no_hp, $id_kategori, $thumbnailContent, $ruteContent);
      if (mysqli_stmt_execute($stmt)) {

        // Data inserted successfully
        echo "Data inserted successfully.";
      } else {
        // Error in execution
        echo "Error: " . mysqli_error($conn);
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    } else {
      // Error in preparing the statement
      echo "Error: " . mysqli_error($conn);
    }
  } else {
    echo "File upload failed.";
  }

  // Close the database connection
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Pedagang</title>
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
  <div class="container mt-5">
    <h2>Tambah Pedagang</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
      </div>
      <div class="mb-3">
        <label for="nama_pedagang" class="form-label">Nama Pedagang</label>
        <input type="text" class="form-control" id="nama_pedagang" name="nama_pedagang" required />
      </div>
      <div class="mb-3">
        <label for="nama_jajanan" class="form-label">Nama Jajanan</label>
        <input type="text" class="form-control" id="nama_jajanan" name="nama_jajanan" required />
      </div>
      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
      </div>
      <div class="mb-3">
        <label for="no_hp" class="form-label">No. HP</label>
        <input type="text" class="form-control" id="no_hp" name="no_hp" required />
      </div>
      <div class="mb-3">
        <label for="id_kategori" class="form-label">ID Kategori</label>
        <input type="number" class="form-control" id="id_kategori" name="id_kategori" required />
      </div>
      <div class="mb-3">
        <label for="thumbnail" class="form-label">Thumbnail (Image)</label>
        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required />
      </div>
      <div class="mb-3">
        <label for="rute" class="form-label">Rute (Image)</label>
        <input type="file" class="form-control" id="rute" name="rute" accept="image/*" required />
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <!-- Include Bootstrap JS and other scripts as needed -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
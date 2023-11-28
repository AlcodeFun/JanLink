<?php
require 'dbconfig.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Gather form data
    $nama_produk = $_POST["nama_produk"];
    $deskripsi = $_POST["deskripsi"];
    $harga = $_POST["harga"];

    // Handle image upload and convert it to BLOB
    $gambar_produk = file_get_contents($_FILES["gambar_produk"]["tmp_name"]);


    if (isset($_SESSION['id'])) {
        $ID_Pedagang = $_SESSION['id'];
    } else {
        echo "Error: ID_Pedagang not found in the session.";
        exit;
    }

    // Insert data into the "produk" table, including the image as a BLOB
    $stmt = $conn->prepare("INSERT INTO produk (nama_produk, deskripsi, harga, ID_Pedagang, thum_produk) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisb", $nama_produk, $deskripsi, $harga, $ID_Pedagang, $gambar_produk);

    if ($stmt->execute()) {
        echo "Product inserted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Insert Product</title>
</head>

<body>
    <div class="container">
        <h1>Tambah Produk</h1>
        <form action="" method="post" enctype="multipart/form-data">
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
</body>

</html>
<?php
require 'dbconfig.php';



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Gather form data
    $nama_produk = $_POST["nama_produk"];
    $deskripsi = $_POST["deskripsi"];
    $harga = $_POST["harga"];

    // Validate session and get ID_Pedagang
    if (isset($_SESSION['id'])) {
        $ID_Pedagang = $_SESSION['id'];
    } else {
        echo "Error: ID_Pedagang not found in the session.";
        exit;
    }

    // Handle image upload
    $gambar_produk_tmp = $_FILES["gambar_produk"]["tmp_name"];

    // Validate file type and size here before proceeding

    $gambar_produk = file_get_contents($gambar_produk_tmp);

    // Insert data into the "produk" table, excluding the image
    $stmt = $conn->prepare("INSERT INTO produk (nama_produk, deskripsi, ID_Pedagang, harga, thum_produk) VALUES (?, ?, ?, ?, ?)");

    // Check if the preparation and binding were successful
    if ($stmt && $stmt->bind_param("ssiss", $nama_produk, $deskripsi, $ID_Pedagang, $harga, $gambar_produk)) {
        // Execute the prepared statement
        $product_inserted_successfully = $stmt->execute();

        $response = array();
        if ($product_inserted_successfully) {
            // Set a session variable for success message
            session_start();
            $_SESSION['success_tambah'] = "Berhasil Menambahkan Produk";
            header("Location: tambah_produk.php");
        } else {
            session_start();
            $_SESSION['error_tambah'] = "Gagal Menambahkan Produk" . $stmt->error;
            header("Location: tambah_produk.php");
        }

        // Send JSON response
        header('Content-Type: application/json');

        $stmt->close();
    } else {
        echo "Error: Unable to prepare statement.";
    }

    $conn->close();
}

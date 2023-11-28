<?php
require 'dbconfig.php';

// Fetch data for reading
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id_pedagang = $_SESSION['id'];

    $query = "SELECT * FROM produk WHERE ID_Pedagang = '$id_pedagang'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode(["data" => $products]);
    } else {
        echo json_encode(["error" => mysqli_error($conn)]);
    }
}

// Add or update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pedagang = $_SESSION['id'];
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = $_POST['harga'];

    // Handle file upload for the thumbnail
    $thumbnailData = file_get_contents($_FILES['gambar_produk']['tmp_name']);
    $thumbnailData = mysqli_real_escape_string($conn, $thumbnailData);

    // Insert data into the database
    $query = "INSERT INTO produk (nama_produk, deskripsi, harga, ID_Pedagang, thum_produk) 
              VALUES ('$nama_produk', '$deskripsi', '$harga', '$id_pedagang', '$thumbnailData')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(["message" => "Data added successfully"]);
    } else {
        echo json_encode(["error" => mysqli_error($conn)]);
    }
}

// Delete data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    $query = "DELETE FROM produk WHERE ID_Product = '{$data['ID_Product']}'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(["message" => "Data deleted successfully"]);
    } else {
        echo json_encode(["error" => mysqli_error($conn)]);
    }
}

// Close the database connection
mysqli_close($conn);

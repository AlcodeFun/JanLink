<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['updateNama'];
    $productDescription = $_POST['updateDeskripsi'];
    $productPrice = $_POST['updateHarga'];
    $tmp = $_FILES["updateGambar"]["tmp_name"];

    // Read the contents of the uploaded file
    $gambar_produk = file_get_contents($tmp);

    // Update product information in the database without changing the image
    $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, deskripsi=?, harga=?, thum_produk=? WHERE id=?");
    $stmt->bind_param("ssdsi", $productName, $productDescription, $productPrice, $gambar_produk, $productId);

    if ($stmt->execute()) {
        // Set a session variable for success message
        session_start();
        $_SESSION['success_message'] = "Produk Berhasil diperbarui!";
        header("Location: lihat_produk.php");
    } else {
        // Set a session variable for error message
        session_start();
        $_SESSION['error_message'] = "Produk Gagal diperbarui! " . $stmt->error;
        header("Location: lihat_produk.php");
    }

    $stmt->close();
}

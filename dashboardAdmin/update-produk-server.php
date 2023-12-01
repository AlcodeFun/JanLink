<?php
require '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateProduk = $_POST['updateProduk'];
    $updateDeskripsi = $_POST['updateDeskripsi'];
    $updateHarga = $_POST['updateHarga'];
    $id_pedagang = $_POST['id_pedagang'];
    $id_produk = $_POST['id_produk'];

    $tmp_thumbnail = $_FILES["updatethum_produk"]["tmp_name"];

    // Read the contents of the uploaded file
    $thum_produk_thumbnail = file_get_contents($tmp_thumbnail);

    $id_pedagang = $_POST['id_pedagang'];



    // Update product information in the database without changing the image
    $stmt = $conn->prepare("UPDATE produk SET nama_produk=?, deskripsi=?, ID_Pedagang=?, harga=?, thum_produk=? WHERE id=?");
    $stmt->bind_param("ssisss", $updateProduk, $updateDeskripsi, $id_pedagang, $updateHarga, $thum_produk_thumbnail, $id_produk);

    if ($stmt->execute()) {
        // Set a session variable for success message
        session_start();
        $_SESSION['success_message'] = "Pedagang Berhasil diperbarui!";
        header("Location: lihat-produk.php");
    } else {
        // Set a session variable for error message
        session_start();
        $_SESSION['error_message'] = "Pedagang Gagal diperbarui! " . $stmt->error;
        header("Location: lihat-produk.php");
    }

    $stmt->close();
}

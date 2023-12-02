<?php
require '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateKategori = $_POST['updateKategori'];

    $tmp_kategori = $_FILES["updateGambar"]["tmp_name"];

    // Read the contents of the uploaded file
    $gambar_kategori = file_get_contents($tmp_kategori);

    $id_kategori = $_POST['id_kategori'];



    // Update product information in the database without changing the image
    $stmt = $conn->prepare("UPDATE kategori SET nama_kategori=?, gambar_kategori=? WHERE ID_Kategori=?");
    $stmt->bind_param("sss", $updateProduk, $gambar_kategori, $id_kategori);

    if ($stmt->execute()) {
        // Set a session variable for success message

        $_SESSION['success_update_kategori'] = "Kategori Berhasil diperbarui!";
        header("Location: lihat-kategori.php");
    } else {
        // Set a session variable for error message

        $_SESSION['error_update_kategori'] = "Kategori Gagal diperbarui! " . $stmt->error;
        header("Location: lihat-kategori.php");
    }

    $stmt->close();
}

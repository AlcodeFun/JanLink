<?php
require '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateNama = $_POST['updateNama'];
    $updateJajanan = $_POST['updateJajanan'];
    $updateDeskripsi = $_POST['updateDeskripsi'];
    $updateNohp = $_POST['updateNohp'];
    $id_kategori = $_POST['id_kategori'];

    $tmp_thumbnail = $_FILES["updateThumbnail"]["tmp_name"];

    // Read the contents of the uploaded file
    $gambar_thumbnail = file_get_contents($tmp_thumbnail);


    $tmp_rute = $_FILES["updateRute"]["tmp_name"];

    // Read the contents of the uploaded file
    $gambar_rute = file_get_contents($tmp_rute);

    $status = $_POST['status'];
    $id_pedagang = $_POST['id_pedagang'];



    // Update product information in the database without changing the image
    $stmt = $conn->prepare("UPDATE pedagang SET Nama_Pedagang=?, Nama_Jajanan=?, Deskripsi=?, No_HP=?, ID_Kategori=?, Thumbnail=?,Rute=?,Status=? WHERE ID_Pedagang=?");
    $stmt->bind_param("ssssisssi", $updateNama, $updateJajanan, $updateDeskripsi, $updateNohp, $id_kategori, $gambar_thumbnail, $gambar_rute, $status, $id_pedagang);

    if ($stmt->execute()) {
        // Set a session variable for success message
        session_start();
        $_SESSION['success_message'] = "Pedagang Berhasil diperbarui!";
        header("Location: lihat-pedagang.php");
    } else {
        // Set a session variable for error message
        session_start();
        $_SESSION['error_message'] = "Pedagang Gagal diperbarui! " . $stmt->error;
        header("Location: lihat-pedagang.php");
    }

    $stmt->close();
}

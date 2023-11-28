<?php
require 'dbconfig.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $ID_Pembeli = $_SESSION['id'];
    $ulasan = $_POST['Ulasan'];
    $nama_pedagang = $_POST['nama_pedagang'];
    $query_id_pedagang = "SELECT ID_Pedagang FROM pedagang WHERE Nama_Jajanan = '$nama_pedagang'";
    $result_id_pedagang = mysqli_query($conn, $query_id_pedagang);
    var_dump($result_id_pedagang);
    $row_id_pedagang =  $result_id_pedagang->fetch_assoc();
    $ID_Pedagang = $row_id_pedagang['ID_Pedagang'];
    $tgl_ulasan = date('Y-m-d');
    $rating = (int)$_POST['Rating'];
    $get_username = "SELECT Username FROM pembeli WHERE ID_Pembeli=$ID_Pembeli";
    $res_username = mysqli_query($conn, $get_username);
    $row_username = $res_username->fetch_assoc();
    $username = $row_username['Username'];
    var_dump($username);

    $stmt = $conn->prepare("INSERT INTO ulasan (ID_Pedagang, username, ulasan, rating, tanggal_ulasan) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issis", $ID_Pedagang, $username, $ulasan, $rating, $tgl_ulasan);

    if ($stmt->execute()) {
        header("Location:detail.php?jajanan=$nama_pedagang");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location:main.php");
}

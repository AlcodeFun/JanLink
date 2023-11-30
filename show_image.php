<?php
require 'dbconfig.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT thum_produk FROM produk WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header('Content-Type: image/jpeg');
        echo $row['thum_produk'];
    }
}

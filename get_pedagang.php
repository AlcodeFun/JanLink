<?php
require 'dbconfig.php';

if (isset($_POST['kategori_id'])) {
    $ID_Kategori = $_POST['kategori_id'];

    // Query to update the ratings first
    $updateRating = "UPDATE pedagang AS p
        JOIN (
            SELECT ID_Pedagang, AVG(rating) AS avg_rating
            FROM ulasan
            GROUP BY ID_Pedagang
        ) AS u
        ON p.ID_Pedagang = u.ID_Pedagang
        SET p.Rating = u.avg_rating";

    // Execute the rating update query
    $conn->query($updateRating);

    // Query to retrieve products for the specified category
    $query = "SELECT ID_Pedagang, Nama_Jajanan, Deskripsi, No_HP, Status, Thumbnail, Rating FROM pedagang WHERE ID_Kategori = $ID_Kategori";
    $result = $conn->query($query);

    if ($result) {
        $products = array();

        while ($row = $result->fetch_assoc()) {
            // Convert the BLOB data to a base64 encoded image
            $imageData = base64_encode($row['Thumbnail']);
            $imageSrc = 'data:image/jpeg;base64,' . $imageData;

            // Add the image source to the result
            $row['Thumbnail'] = $imageSrc;

            $products[] = $row;
        }

        echo json_encode($products);
    } else {
        echo json_encode(array('error' => 'Query failed'));
    }
} else {
    // Query to update the ratings for all products
    $updateRating = "UPDATE pedagang AS p
        JOIN (
            SELECT ID_Pedagang, AVG(rating) AS avg_rating
            FROM ulasan
            GROUP BY ID_Pedagang
        ) AS u
        ON p.ID_Pedagang = u.ID_Pedagang
        SET p.Rating = u.avg_rating";

    // Execute the rating update query for all products
    $conn->query($updateRating);

    // Query to retrieve all products
    $query = "SELECT ID_Pedagang, Nama_Jajanan, Deskripsi, No_HP, Status, Thumbnail, Rating FROM pedagang";
    $result = $conn->query($query);

    if ($result) {
        $products = array();

        while ($row = $result->fetch_assoc()) {
            // Convert the BLOB data to a base64 encoded image
            $imageData = base64_encode($row['Thumbnail']);
            $imageSrc = 'data:image/jpeg;base64,' . $imageData;

            // Add the image source to the result
            $row['Thumbnail'] = $imageSrc;

            $products[] = $row;
        }

        echo json_encode($products);
    } else {
        echo json_encode(array('error' => 'Query failed'));
    }
}

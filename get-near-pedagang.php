<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT ID_Pedagang, Nama_Jajanan, Latitude, Longitude FROM pedagang 
              WHERE Status = 'Aktif' AND 
              (
                6371 * acos(cos(radians(?)) * cos(radians(Latitude)) * cos(radians(Longitude) - radians(?)) + sin(radians(?)) * sin(radians(Latitude)))
              ) <= 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ddd', $latitude, $longitude, $latitude);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($idPedagang, $namaJajanan, $pedagangLatitude, $pedagangLongitude);

    $result = array();

    while ($stmt->fetch()) {
        $result[] = array(
            'ID_Pedagang' => $idPedagang,
            'Nama_Jajanan' => $namaJajanan,
            'Latitude' => $pedagangLatitude,
            'Longitude' => $pedagangLongitude
        );
    }

    // Send the result as JSON
    echo json_encode($result);
} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method";
}

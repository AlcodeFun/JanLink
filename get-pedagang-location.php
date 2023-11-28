<?php
require 'dbconfig.php';

// Fetch pedagang locations from the database
$selectQuery = "SELECT Latitude, Longitude FROM pedagang";
$result = $conn->query($selectQuery);

if ($result->num_rows > 0) {
    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = [
            'latitude' => $row['Latitude'],
            'longitude' => $row['Longitude'],
        ];
    }

    // Return the locations as JSON
    echo json_encode($locations);
} else {
    // No pedagang locations found
    echo json_encode([]);
}

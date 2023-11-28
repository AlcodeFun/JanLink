<?php
require 'dbconfig.php';
// Connect to your database

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the id parameter from the POST request
$id = isset($_POST['id']) ? $_POST['id'] : 0;

// Query to get latitude and longitude based on id
$query = "SELECT Latitude, Longitude FROM pedagang WHERE ID_Pedagang = $id LIMIT 1";
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    $data = $result->fetch_assoc();

    // Return data as JSON
    echo json_encode($data);
} else {
    // Handle error
    echo json_encode(['error' => 'Unable to retrieve data']);
}

// Close the database connection
$conn->close();

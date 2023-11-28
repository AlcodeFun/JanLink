<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    $latitude = $data->latitude;
    $longitude = $data->longitude;
    $user_id = $data->user_id;

    $db = new mysqli('localhost', 'root', '', 'janlink');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // Use a prepared statement to update the user's location
    $query = $db->prepare("UPDATE pedagang SET Latitude=?, Longitude=? WHERE ID_Pedagang=?");
    $query->bind_param("dds", $latitude, $longitude, $user_id);

    if ($query->execute()) {
        echo json_encode(['status' => 'Location updated']);
    } else {
        echo json_encode(['error' => 'Location update failed']);
    }

    $query->close();
    $db->close();
}
error_log("Request received: " . print_r($_POST, true));

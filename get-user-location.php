<?php
// Retrieve latitude and longitude from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$current_user_latitude = $data['latitude'];
$current_user_longitude = $data['longitude'];

// Rest of your PHP code (the SQL query and database connection) goes here...

// Now, you can use $current_user_latitude and $current_user_longitude in your SQL query.

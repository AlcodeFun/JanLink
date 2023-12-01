<?php
// Include your database connection file
include('dbconfig.php');

// Get the search term from the POST request
$searchTerm = $_POST['term'];

// Prepare the SQL query with a LIKE clause
$sql = "SELECT * FROM pedagang WHERE Nama_Jajanan LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $searchTermWildcard);
$searchTermWildcard = '%' . $searchTerm . '%';
$stmt->execute();

// Get the results
$result = $stmt->get_result();

// Fetch the results
$results = $result->fetch_all(MYSQLI_ASSOC);

// Return the results as JSON
echo json_encode($results);

// Close the statement and connection
$stmt->close();
$conn->close();

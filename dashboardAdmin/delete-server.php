<?php
require '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {



    // Sanitize the product ID
    $pedagang_id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($_SESSION['role'] == 'admin') {
        // SQL query to delete the product for the specific pedagang
        $sql = "DELETE FROM pedagang WHERE ID_Pedagang = $pedagang_id";

        if ($conn->query($sql) === TRUE) {
            // Product deleted successfully
            header("Location: lihat-pedagang.php");
        } else {
            // Error deleting product
            echo "Error: " . $conn->error;
        }
    } else {
        // Redirect to an error page or handle the error as needed
        header("Location: error_page.php");
    }
}

<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Assuming ID_Pedagang is stored in the session
    $id_pedagang = $_SESSION['id'];

    // Sanitize the product ID
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($_SESSION['role'] == 'pedagang' && $_SESSION['id'] == $id_pedagang) {
        // SQL query to delete the product for the specific pedagang
        $sql = "DELETE FROM produk WHERE ID_Pedagang = $id_pedagang AND id = $product_id";

        if ($conn->query($sql) === TRUE) {
            // Product deleted successfully
            header("Location: lihat_produk.php");
        } else {
            // Error deleting product
            echo "Error: " . $conn->error;
        }
    } else {
        // Redirect to an error page or handle the error as needed
        header("Location: error_page.php");
    }
}

<?php
require '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {



    // Sanitize the product ID
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    if ($_SESSION['role'] == 'admin') {
        // SQL query to delete the product for the specific pedagang
        $sql = "DELETE FROM kategori WHERE ID_Kategori = $id";

        if ($conn->query($sql) === TRUE) {
            // Product deleted successfully
            session_start();
            $_SESSION['success_delete'] = "Kategori Berhasil dihapus!";
            header("Location: lihat-kategori.php");
        } else {
            // Error deleting product
            session_start();
            $_SESSION['error_delete'] = "Kategori Gagal dihapus!";
            header("Location: lihat-kategori.php");
        }
    } else {
        // Redirect to an error page or handle the error as needed
        header("Location: error_page.php");
    }
}

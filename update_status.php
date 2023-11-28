<?php
require 'dbconfig.php';

if (isset($_SESSION['id']) && $_SESSION['role'] == 'pedagang') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status'])) {
        $status = ($_POST['status'] == 'on') ? 'Aktif' : 'Non-Aktif';
        $pedagang_id = $_SESSION['id'];

        // Update the status in the pedagang table
        $sql = "UPDATE pedagang SET status = '$status' WHERE ID_Pedagang = $pedagang_id";
        if ($conn->query($sql) === TRUE) {
            echo "Status updated successfully.";
        } else {
            echo "Error updating status: " . $conn->error;
        }
    }
} else {
    echo "Unauthorized access.";
}

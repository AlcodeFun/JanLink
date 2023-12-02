<?php
require '../dbconfig.php';
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $nama_kategori = $_POST["nama_kategori"];

    $gambar = $_FILES["gambar"]["tmp_name"];


    // Check if file uploads are valid
    if (is_uploaded_file($gambar)) {
        $gambarContent = file_get_contents($gambar);

        // SQL query to insert data into the database
        $sql = "INSERT INTO kategori (nama_kategori,gambar_kategori) VALUES (?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmt, "ss", $nama_kategori, $gambarContent);

            if (mysqli_stmt_execute($stmt)) {
                session_start();
                $_SESSION['success_kategori'] = "Berhasil Menambahkan Kategori";
                header("Location: tambah-kategori.php");
            } else {
                $_SESSION['error_kategori'] = "Gagal Menambahkan Kategori";
                header("Location: tambah-kategori.php");
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Error in preparing the statement
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }

    // Close the database connection
    mysqli_close($conn);
}

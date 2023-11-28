<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (update with your database details)
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "janlink";

    $conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

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
                // Data inserted successfully
                echo "Data inserted successfully.";
            } else {
                // Error in execution
                echo "Error: " . mysqli_error($conn);
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Pedagang</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Pedagang</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">nama_kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required />
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">gambar (Image)</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Include Bootstrap JS and other scripts as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
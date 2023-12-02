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

    // Retrieve data from the form
    $username = $_POST["username"];
    $email = $_POST["email"];
    // Hash the password securely
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $nama_pedagang = $_POST["nama_pedagang"];
    $nama_jajanan = $_POST["nama_jajanan"];
    $deskripsi = $_POST["deskripsi"];
    $no_hp = $_POST["no_hp"];
    $id_kategori = $_POST["id_kategori"];

    // Process uploaded files (thumbnail and rute)
    $thumbnail = $_FILES["thumbnail"]["tmp_name"];
    $rute = $_FILES["rute"]["tmp_name"];
    $duplicatePedagang = mysqli_query($conn, "SELECT * FROM pedagang WHERE username='$username' OR email='$email'");
    $duplicatePembeli = mysqli_query($conn, "SELECT * FROM pembeli WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($duplicatePedagang) > 0 || mysqli_num_rows($duplicatePembeli)) {
        // Set a session variable for success message
        session_start();
        $_SESSION['duplicate'] = "Username/Password sudah ada";
        header("Location: tambah-pedagang.php");
    } else {

        // Check if file uploads are valid
        if (is_uploaded_file($thumbnail) && is_uploaded_file($rute)) {
            $thumbnailContent = file_get_contents($thumbnail);
            $ruteContent = file_get_contents($rute);

            // SQL query to insert data into the database
            $sql = "INSERT INTO Pedagang (ID_Role, Username, Email, PasswordHash, Nama_Pedagang, Nama_Jajanan, Deskripsi, No_HP, ID_Kategori, Thumbnail, Rute) VALUES (2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                // Bind parameters and execute the statement
                mysqli_stmt_bind_param($stmt, "ssssssssss", $username, $email, $password, $nama_pedagang, $nama_jajanan, $deskripsi, $no_hp, $id_kategori, $thumbnailContent, $ruteContent);
                if (mysqli_stmt_execute($stmt)) {

                    session_start();
                    $_SESSION['success'] = "Data Pedagang Berhasil Ditambahkan";
                    header("Location: tambah-pedagang.php");
                } else {
                    session_start();
                    $_SESSION['failed'] = "Data Pedagang Gagal Ditambahkan";
                    header("Location:  tambah-pedagang.php");
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
    }


    // Close the database connection
    mysqli_close($conn);
}

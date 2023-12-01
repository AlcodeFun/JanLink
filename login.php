<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- CSS -->
    <style>
        body {
            background-image: url(assets/bgImage.jpg);
            background-size: cover;
            min-height: 100%;
            font-family: "Poppins";
        }

        .login-container {
            background-color: white;
            width: 512px;
            margin: auto;
            padding: 20px;
            min-height: 100vh;
        }

        .logoImg img {
            margin: auto;
            margin-bottom: 20px;
            margin-top: -50px;
            display: flex;
            justify-content: center;
        }

        .forgot-pw {
            text-decoration: none;
            color: #FD725C;
            font-weight: 500;
            font-size: 14px;
        }

        .btn-submit {
            background-color: #FD725C;
            color: white;
            font-weight: 600;
            width: 100%;
            border: none;
            border-radius: 5px;
            height: 40px;
        }

        .login-form {
            margin-top: 30%;
        }

        .login-form p a {
            margin-top: 30%;
            color: #FD725C;
        }

        .form-control {
            font-family: Poppins, 'FontAwesome', sans-serif;
        }
    </style>
    <!-- FA -->
    <script src="https://kit.fontawesome.com/05f405bcb5.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="login-container">

        <div class="login-form">
            <div class="logoImg">
                <img src="assets/logo-janlink.png" alt="">
                <h5 class="text-center">Login</h5>
            </div>

            <form action="" method="post" autocomplete="off">
                <div class=" form-group mt-3">
                    <input class="form-control" type="text" placeholder="&#xf007; Username" name="nama_user" value="" required>
                    <small class="text-danger"></small>
                </div>
                <div class="form-group mt-3">
                    <input class="form-control" type="password" id="password1" placeholder="&#xf023; Password" name="password" required>
                    <small class="text-danger"></small>
                </div>
                <div class="mb-3">
                    <a class="forgot-pw" href="#">Lupa Password?</a>
                </div>

                <button name="submit" type="submit" class="btn-submit">Masuk</button>
            </form>
            <p class="text-center mt-3">Belum memiliki akun? <a href="register.php">Daftar</a></p>

        </div>
    </div>







    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <?php
    require 'dbconfig.php';

    if (isset($_POST["submit"])) {
        $username = $_POST['nama_user'];
        $password = $_POST['password'];

        // Validate the user's credentials in the "pembeli" table
        $query_pembeli = "(SELECT ID_Pembeli AS ID, ID_Role, Username, PasswordHash FROM pembeli WHERE Username='$username')
    UNION
    (SELECT ID_Pedagang AS ID, ID_Role, Username, PasswordHash FROM pedagang WHERE Username='$username')
    UNION
    (SELECT ID_Admin AS ID, ID_Role, Username, PasswordHash FROM administrator WHERE Username='$username')";
        $result_user = mysqli_query($conn, $query_pembeli);
        var_dump($result_user);

        if (mysqli_num_rows($result_user) == 1) {
            // User is found in the "pembeli" table
            $row = mysqli_fetch_assoc($result_user);
            if ($row["ID_Role"] == 1) {
                $hashedPassword = $row["PasswordHash"];
                if (password_verify($password, $row["PasswordHash"])) {
                    // Password is correct
                    // Redirect to the customer dashboard
                    $_SESSION["login"] = true;
                    $_SESSION["id"] = $row["ID"];
                    $ID_User = $row["ID"];
                    $_SESSION["role"] = "pembeli";
                    $actionUrl = 'main.php';

                    echo "<script>
    Swal.fire({
        title: 'Login Berhasil',
        text: 'Anda akan masuk ke halaman beranda',
        type : 'Success',
        icon: 'success',
        timer: 1000, // Auto-close the alert after 3 seconds
        showConfirmButton: false // Remove the 'OK' button
    });

    setTimeout(function(){
        window.location.href = 'main.php';
    }, 1000); // Redirect after 3 seconds
</script>";
                } else {
                    echo "<script>alert('Incorrect password')</script>";
                }
            } elseif ($row["ID_Role"] == 2) {
                // Verify the password for pedagang
                $hashedPassword = $row["PasswordHash"];
                if (password_verify($password, $row["PasswordHash"])) {
                    // Password is correct
                    // Redirect to the pedagang dashboard
                    $_SESSION["login"] = true;
                    $_SESSION["id"] = $row["ID"];
                    $_SESSION["role"] = "pedagang";
                    $ID_User = $row["ID"];
                    $actionUrl = 'dashboard_pedagang.php';

                    // Use JavaScript to show the modal
                    echo '<script>
        $(document).ready(function() {
            $("#exampleModal").modal("show");
        });
    </script>';
                } else {
                    echo "<script>alert('Incorrect password')</script>";
                }
            } elseif ($row["ID_Role"] == 3) {
                // Verify the password for admin
                if ($password == $row["PasswordHash"]) {
                    // Password is correct
                    var_dump($row);
                    // Redirect to the admin dashboard
                    $_SESSION["login"] = true;
                    $_SESSION["id"] = $row["ID"];
                    $_SESSION["role"] = "admin";
                    $ID_User = $row["ID"];
                    $actionUrl = 'dashboardAdmin/home.php';

                    // Use JavaScript to show the modal
                    echo '<script>
        $(document).ready(function() {
            $("#exampleModal").modal("show");
        });
    </script>';
                } else {
                    echo "<script>alert('Incorrect password')</script>";
                }
            }
        } else {
            echo "<script>alert('Username not found. Please register.')</script>";
        }
    }


    ?>
    <!-- Modal -->
    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success" id="exampleModalLabel">Login Berhasil</h5>
                    <!-- Remove the data-bs-dismiss attribute from the close button -->
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- You can customize the content of the modal here -->
                    <p>Login Berhasil. Anda akan di arahkan ke dashboard</p>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo $actionUrl ?>" method="post">
                        <button class="btn btn-success" type="submit" name="ID_User" value="<?php echo $ID_User ?>" class="btn btn-secondary">Menuju Dashboard</button>
                    </form>
                    <!-- Add buttons or actions here as needed -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>
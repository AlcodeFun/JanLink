<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <!-- CSS -->
    <style>
        body {
            background-image: url(assets/bgImage.jpg);
            background-size: cover;
            min-height: 100%;
            font-family: "Poppins";
        }

        .register-container {
            background-color: white;
            width: 512px;
            margin: auto;
            padding: 20px;
            min-height: 100vh;


        }

        .logoImg img {
            margin: auto;
            margin-bottom: 20px;
            margin-top: -90px;
            display: flex;
            justify-content: center;
        }

        .forgot-pw {
            text-decoration: none;
            color: #FD725C;
            font-weight: 500;
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

        .register-form {
            margin-top: 30%;
        }

        .register-form p a {
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
    <?php
    require 'dbconfig.php';
    if (isset($_POST["submit"])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST["repassword"];

        $duplicatePedagang = mysqli_query($conn, "SELECT * FROM pedagang WHERE username='$username' OR email='$email'");
        $duplicatePembeli = mysqli_query($conn, "SELECT * FROM pembeli WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($duplicatePedagang) > 0 || mysqli_num_rows($duplicatePembeli)) {
            echo "<script>
            Swal.fire({
                title: 'Duplikat',
                text: 'Username/Email sudah terdaftar',
                icon: 'error',
            });
        </script>";
        } else {
            if ($password == $repassword) {
                $hashedpassword = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $query = "INSERT INTO pembeli VALUES('',1,'$username','$email','$hashedpassword','','')";
                mysqli_query($conn, $query);
                echo "<script>
            Swal.fire({
                title: 'Berhasil Daftar',
                text: 'Pendaftaran Berhasil',
                type : 'Success',
                icon: 'success',
                timer: 3000, // Auto-close the alert after 3 seconds
                showConfirmButton: false // Remove the 'OK' button
            });
        </script>";
            } else {
                echo "<script>
            Swal.fire({
                title: 'Password Match',
                text: 'Password tidak sama',
                icon: 'error',
            });
        </script>";
            }
        }
    } ?>
    <div class="register-container">

        <div class="register-form">
            <div class="logoImg">
                <img src="assets/logo-janlink.png" alt="">
                <h5 class="text-center">Register</h5>
            </div>

            <form action="" method="post" autocomplete="off">
                <div class="form-group mt-3">
                    <input class="form-control" type="text" placeholder="&#xf007; Username" name="username" value="" required>
                    <small class="text-danger"></small>
                </div>
                <div class="form-group mt-3">
                    <input class="form-control" type="email" placeholder="&#xf0e0; Email" name="email" value="" required>
                    <small class="text-danger"></small>
                </div>
                <div class="form-group mt-3">
                    <input class="form-control" type="password" id="password1" placeholder="&#xf023; Password" name="password" required>
                    <small class="text-danger"></small>
                </div>
                <div class="form-group mt-3">
                    <input class="form-control" type="password" id="password2" placeholder="&#xf023; Konfirmasi Password" name="repassword" required>
                    <input type="hidden" name="id_role" value="1">
                    <small class="text-danger"></small>
                </div>


                <button name="submit" type="submit" class="btn-submit mt-3">Daftar</button>
            </form>
            <p class="text-center mt-3">Sudah memiliki akun? <a href="login.php">Masuk</a></p>

        </div>

    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
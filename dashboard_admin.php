<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {
  echo $_SESSION["id"];
} else {
  header("Location:main.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin</title>
</head>

<body>
  <h1>Hello Admin</h1>
  <form action="main.php" method="post">
    <button name="role" value="admin" type="submit">Beranda</button>
  </form>
</body>

</html>
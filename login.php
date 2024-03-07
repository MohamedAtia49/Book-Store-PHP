<?php
include "config.php";
session_start();
if (isset($_POST["submit"])) {

  $email = mysqli_real_escape_string($db_connect, $_POST["email"]);
  $password = mysqli_real_escape_string($db_connect, $_POST["password"]);

  $select_users = mysqli_query($db_connect, "SELECT * FROM `users` WHERE `email` = '$email' ") or die("query failed");
  if (mysqli_num_rows($select_users) > 0) {
    $row = mysqli_fetch_assoc($select_users);

    if (password_verify($password, $row["password"])) {

      if ($row["user_type"] == 'admin') {
        $_SESSION["admin_name"] = $row["name"];
        $_SESSION["admin_email"] = $row["email"];
        $_SESSION["admin_id"] = $row["id"];
        header("location:admin_page.php");
      } elseif ($row["user_type"] == "user") {
        $_SESSION["user_name"] = $row["name"];
        $_SESSION["user_email"] = $row["email"];
        $_SESSION["user_id"] = $row["id"];
        header("location:home.php");
      }
    } else {
      $message[] = "Incorrect email or password!";
    };
  } else {
    $message[] = "Email isn't exist! please register first! ";
  };
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "header.php" ?>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div class="form-container">

    <form action="" method="post">
      <h3>Login now</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="submit" name="submit" value="Login" class="btn">
      <p>Don't have an account? <a href="register.php">Register now</a></p>
    </form>

  </div>

</body>

</html>
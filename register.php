<?php
include "config.php";
if (isset($_POST["submit"])) {
  $name = mysqli_real_escape_string($db_connect, $_POST["name"]);
  $email = mysqli_real_escape_string($db_connect, $_POST["email"]);
  $password = mysqli_real_escape_string($db_connect, password_hash($_POST["password"], PASSWORD_DEFAULT));
  $cpassword = mysqli_real_escape_string($db_connect, password_hash($_POST["cpassword"], PASSWORD_DEFAULT));

  $select_users = mysqli_query($db_connect, "SELECT * FROM `users` WHERE `email` = '$email' ") or die("query failed");

  // Validation Password Stength
  $uppercase = preg_match("#[A-Z]+#", $_POST["password"]);
  $lowercase = preg_match("#[a-z]+#", $_POST["password"]);
  $number = preg_match("#[0-9]+#", $_POST["password"]);
  $specialChars = preg_match("#[^\w]+#", $_POST["password"]);

  if (mysqli_num_rows($select_users) > 0) {
    $message[] = 'Email already Registered!';
  } else {
    if (!$uppercase) {
      $message[] = "Password should include at least one upper case letter ";
    } elseif (!$lowercase) {
      $message[] = "Password should include at least one lower case letter ";
    } elseif (!$number) {
      $message[] = "Password should include at least one number ";
    } elseif (!$specialChars) {
      $message[] = "Password should include at least special character like (@ , # , $ , % , & , *) ";
    } elseif (strlen($_POST["password"]) < 8) {
      $message[] = "Password should include at least 8 characters ";
    } elseif ($_POST["password"] !== $_POST["cpassword"]) {
      $message[] = 'Confirm password not matched!';
      $message[] = "$password";
      $message[] = "$cpassword";
    } else {
      mysqli_query($db_connect, "INSERT INTO `users`(name,email,password,user_type) VALUES('$name','$email','$password','user')") or die("query failed");
      $message[] = 'Registered successfully!';
      $message[] = '<a href="login.php">Login Now</a>';
    }
  };
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>register</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo  "<div class='message'>
      <span>$message</span>
      <i class='fas fa-times' onclick='this.parentElement.remove()'></i>
    </div>";
    };
  }
  ?>
  <div class="form-container">
    <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" placeholder="Enter Your Name" class="box" required>
      <input type="email" name="email" placeholder="Enter Your Email" class="box" required>
      <input type="password" name="password" placeholder="Enter Your Password" class="box" required>
      <input type="password" name="cpassword" placeholder="Confirm Your Password" class="box" required>
      <input type="submit" name="submit" value="Register" class="btn">
      <p>Already have an account? <a href="login.php">Login Now</a> </p>
    </form>
  </div>
</body>

</html>
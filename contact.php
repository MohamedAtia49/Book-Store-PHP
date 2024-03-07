<?php
include "config.php";
session_start();
if (isset($_SESSION["user_id"])) {
  $user_id = $_SESSION["user_id"];
}

if (isset($_POST["send_message"])) {

  $name = mysqli_real_escape_string($db_connect, $_POST["name"]);
  $email = mysqli_real_escape_string($db_connect, $_POST["email"]);
  $number = $_POST["number"];
  $user_message = mysqli_real_escape_string($db_connect, $_POST["message"]);
  $id = $_POST["id"];
  mysqli_query($db_connect, "INSERT INTO `message` (user_id,name,email,number,message) VALUES ('$id','$name','$email','$number','$user_message') ");
  $message[] = "message sent successfully!";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>contact</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php include 'header.php'; ?>

  <div class="heading">
    <h3>contact us</h3>
    <p> <a href="home.php">home</a> / contact </p>
  </div>

  <section class="contact">

    <form action="" method="post">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <input type="email" name="email" required placeholder="enter your email" class="box">
      <input type="number" name="number" required placeholder="enter your number" class="box">
      <input type="hidden" name="id" value="<?= isset($user_id) ? $user_id : 0  ?>">
      <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send_message" class="btn">
    </form>

  </section>

  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>

</body>

</html>
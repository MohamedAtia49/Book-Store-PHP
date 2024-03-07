<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:login.php');
};

if (isset($_GET["delete"])) {
  $msg_id = $_GET["delete"];
  mysqli_query($db_connect, "DELETE FROM `message` WHERE id = '$msg_id' ") or die("query failed");
  header('location:admin_contacts.php');
  $message[] = "Message deleted successfully!";
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>messages</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

  <?php include 'admin_header.php'; ?>

  <section class="messages">

    <h1 class="title"> Messages </h1>

    <div class="box-container">
      <?php
      $get_messages = mysqli_query($db_connect, "SELECT * FROM `message`");
      if (mysqli_num_rows($get_messages) > 0) {
        while ($row = mysqli_fetch_assoc($get_messages)) {
      ?>
          <div class="box">
            <p> user id : <span><?= $row["user_id"] ?></span> </p>
            <p> name : <span><?= $row["name"] ?></span> </p>
            <p> number : <span><?= $row["number"] ?></span> </p>
            <p> email : <span><?= $row["email"] ?></span> </p>
            <p> message : <span><?= $row["message"] ?></span> </p>
            <a href="admin_contacts.php?delete=<?= $row["id"] ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete message</a>
          </div>
      <?php
        };
      } else {
        echo '<p class="empty">you have no messages!</p>';
      }
      ?>
    </div>

  </section>
  <script src="js/admin_script.js"></script>
</body>

</html>
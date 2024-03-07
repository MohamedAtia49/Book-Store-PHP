<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>orders</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php include 'header.php'; ?>

  <div class="heading">
    <h3>your orders</h3>
    <p> <a href="home.php">home</a> / orders </p>
  </div>

  <section class="placed-orders">

    <h1 class="title">placed orders</h1>

    <div class="box-container">

    <?php 
    $get_users_orders = mysqli_query($db_connect,"SELECT * FROM `orders` WHERE user_id = '$user_id' ");
    if(mysqli_num_rows($get_users_orders)){
      while($row = mysqli_fetch_assoc($get_users_orders)){
        ?>
        

      <div class="box">
        <p> placed on : <span><?= $row["placed_on"] ?></span> </p>
        <p> name : <span><?= $row["name"] ?></span> </p>
        <p> number : <span><?= $row["number"] ?></span> </p>
        <p> email : <span><?= $row["email"] ?></span> </p>
        <p> address : <span><?= $row["address"] ?></span> </p>
        <p> payment method : <span><?= $row["method"] ?></span> </p>
        <p> your orders : <span><?= $row["total_products"] ?></span> </p>
        <p> total price : <span>$<?= $row["total_price"] ?>/-</span> </p>
        <p> payment status : <span style="color:<?= $row["payment_status"] == "pending" ? "red" : "green" ?>;"><?= $row["payment_status"] ?></span> </p>
      </div>
      <?php
      }
    }else{
      echo '<p class="empty">no orders placed yet!</p>';
    }
    ?>
    </div>

  </section>
  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>

</body>

</html>
<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

if (isset($_POST["order_btn"])) {
  $name = mysqli_real_escape_string($db_connect, $_POST["name"]);
  $email = mysqli_real_escape_string($db_connect, $_POST["email"]);
  $method = mysqli_real_escape_string($db_connect, $_POST["method"]);
  $number = $_POST["number"];
  $address = mysqli_real_escape_string($db_connect, "flat no.$_POST[flat],$_POST[street],$_POST[city],$_POST[country],$_POST[pin_code]");
  $placed_on = date("d-m-y");

  $all_cart_price = 0;
  $all_cart_products[] = "";

  $cart_query = mysqli_query($db_connect, "SELECT * FROM `cart` WHERE user_id = '$user_id' ");
  if (mysqli_num_rows($cart_query) > 0) {
    while ($row = mysqli_fetch_assoc($cart_query)) {
      $sub_price = $row["price"] * $row["quantity"];
      $all_cart_price += $sub_price;
      $all_cart_products[] = "$row[name]($row[quantity])";
    }
  }
  $total_products = implode(",", $all_cart_products);

  $order_query = mysqli_query($db_connect, "SELECT * FROM `orders` WHERE name = '$name' AND email = '$email' AND number = '$number'  AND method = '$method' AND address = '$address' AND placed_on = $placed_on AND total_products = '$total_products' AND total_price = '$all_cart_price' ");

  if ($all_cart_price == 0) {
    $message[] = 'your cart is empty';
  }else{
    if(mysqli_num_rows($order_query)>0){
      $message[] = "Order already placed!";
    }else{
      mysqli_query($db_connect,"INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id','$name','$number','$email','$method','$address','$total_products','$all_cart_price','$placed_on')");
      $message[] = "Order placed successfully!"; 
      mysqli_query($db_connect,"DELETE FROM `cart` WHERE user_id = '$user_id' ");
    };
  };
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>checkout</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php include 'header.php'; ?>

  <div class="heading">
    <h3>checkout</h3>
    <p> <a href="home.php">home</a> / checkout </p>
  </div>

  <section class="display-order">

    <?php
    $all_price = 0;
    $get_cart = mysqli_query($db_connect, "SELECT * FROM `cart` WHERE user_id = '$user_id' ");
    if (mysqli_num_rows($get_cart) > 0) {
      while ($row = mysqli_fetch_assoc($get_cart)) {
        $all_price += $row["price"] * $row["quantity"];

    ?>
        <p><span><?= "$row[name] " . "($$row[price] x $row[quantity])" ?></span> </p>

    <?php
      }
    } else {
      echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    <div class="grand-total"> grand total : <span>$ <?= $all_price ?> /-</span> </div>
  </section>

  <section class="checkout">

    <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
        <div class="inputBox">
          <span>your name :</span>
          <input type="text" name="name" required placeholder="enter your name">
        </div>
        <div class="inputBox">
          <span>your number :</span>
          <input type="number" name="number" required placeholder="enter your number">
        </div>
        <div class="inputBox">
          <span>your email :</span>
          <input type="email" name="email" required placeholder="enter your email">
        </div>
        <div class="inputBox">
          <span>payment method :</span>
          <select name="method">
            <option value="cash on delivery">cash on delivery</option>
            <option value="credit card">credit card</option>
            <option value="paypal">paypal</option>
            <option value="paytm">paytm</option>
          </select>
        </div>
        <div class="inputBox">
          <span>address line 01 :</span>
          <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
        </div>
        <div class="inputBox">
          <span>address line 01 :</span>
          <input type="text" name="street" required placeholder="e.g. street name">
        </div>
        <div class="inputBox">
          <span>city :</span>
          <input type="text" name="city" required placeholder="e.g. mumbai">
        </div>
        <div class="inputBox">
          <span>state :</span>
          <input type="text" name="state" required placeholder="e.g. maharashtra">
        </div>
        <div class="inputBox">
          <span>country :</span>
          <input type="text" name="country" required placeholder="e.g. india">
        </div>
        <div class="inputBox">
          <span>pin code :</span>
          <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
        </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
    </form>

  </section>

  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>

</body>

</html>
<?php

include 'config.php';

session_start();

if (isset($_SESSION["user_id"])) {
  $user_id = $_SESSION["user_id"];
}
if (isset($user_id)) {
  if (isset($_POST["add_to_cart"])) {

     $product_qtn = $_POST["product_quantity"];
     $product_name = $_POST["product_name"];
     $product_image = $_POST["product_image"];
     $product_price = $_POST["product_price"];

     $get_cart = mysqli_query($db_connect, "SELECT * FROM `cart` WHERE `name` = '$product_name' AND `user_id` = '$user_id' ");
     if (mysqli_num_rows($get_cart) > 0) {
        $message[] = 'already added to cart!';
     } else {
        $add_to_cart = mysqli_query($db_connect, "INSERT INTO `cart` (user_id, name, price, quantity, image) VALUES ('$user_id','$product_name','$product_price','$product_qtn','$product_image') ");
        $message[] = 'Product added to cart!';
     };
  };
  
}
if(isset($_POST["add_to_cart"]) && !isset($user_id) ){
  $message[] = "Please Login First!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>search page</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php include 'header.php'; ?>

  <div class="heading">
    <h3>search page</h3>
    <p> <a href="home.php">home</a> / search </p>
  </div>

  <section class="search-form">
    <form action="" method="post">
      <input type="text" name="search" placeholder="search products..." class="box">
      <input type="submit" name="submit" value="search" class="btn">
    </form>
  </section>

  <section class="products" style="padding-top: 0;">

    <div class="box-container">
      <?php
      if (isset($_POST["submit"])) {
        $search_word = $_POST["search"];

        $search_in_db = mysqli_query($db_connect, "SELECT * FROM `products` WHERE name LIKE '%$search_word%'") or die("query failed");
        if (mysqli_num_rows($search_in_db) > 0) {
          while ($row = mysqli_fetch_assoc($search_in_db)) {
      ?>
            <form action="" method="post" class="box">
              <img src="uploaded_img/<?= $row["image"] ?>" alt="" class="image">
              <div class="name"><?= $row["name"] ?></div>
              <div class="price">$<?= $row["price"] ?>/-</div>
              <input type="number" class="qty" name="product_quantity" min="1" value="1">
              <input type="hidden" name="product_name" value="<?= $row["name"] ?>">
              <input type="hidden" name="product_price" value="<?= $row["price"] ?>">
              <input type="hidden" name="product_image" value="<?= $row["image"] ?>">
              <input type="submit" class="btn" value="add to cart" name="add_to_cart">
            </form>
      <?php
          };
        } else {
          echo '<p class="empty">no result found!</p>';
        }
      } else {
        echo '<p class="empty">search something!</p>';
      }
      ?>
    </div>


  </section>
  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>
</body>

</html>
<?php include "config.php";

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
   <title>Shop</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'header.php'; ?>

   <section class="products">

      <h1 class="title">products</h1>

      <div class="box-container">
         <?php
         $getProducts = mysqli_query($db_connect, "SELECT * FROM `products`");
         if (mysqli_num_rows($getProducts) > 0) {
            while ($row = mysqli_fetch_assoc($getProducts)) {
         ?>

               <form action="" method="post" class="box">
                  <img class="image" src="uploaded_img/<?= $row["image"] ?>" alt="">
                  <div class="name"><?= $row["name"] ?></div>
                  <div class="price">$<?= $row["price"] ?>/-</div>
                  <input type="number" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="product_name" value="<?= $row["name"] ?>">
                  <input type="hidden" name="product_price" value="<?= $row["price"] ?>">
                  <input type="hidden" name="product_image" value="<?= $row["image"] ?>">
                  <input type="submit" value="add to cart" name="add_to_cart" class="btn">

               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>

   </section>


   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>

</body>

</html>
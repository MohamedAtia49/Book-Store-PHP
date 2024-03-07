<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
  header('location:login.php');
}

if (isset($_POST["update_cart"])) {
  $cart_id = $_POST["cart_id"];
  $update_qtn = $_POST["cart_quantity"];

  mysqli_query($db_connect, "UPDATE `cart` SET quantity = '" . $update_qtn . "' WHERE id = '" . $cart_id . "'") or die("Query Failed");
  $message[] = "Quantity Updated Successfully";
};

if (isset($_GET["delete"])) {
  $delete_id = $_GET["delete"];
  mysqli_query($db_connect, "DELETE FROM `cart` WHERE id = '" . $delete_id . "' ") or die("Query Failed");
  $message[] = "Product Deleted";
}
if (isset($_GET["delete_all"])) {
  $delete_id_all = $_GET["delete_all"];
  mysqli_query($db_connect, "DELETE FROM `cart` WHERE user_id = '" . $user_id . "' ");
  $messagep[] = "Done! Cart is empty now!";
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>cart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <?php include 'header.php'; ?>

  <div class="heading">
    <h3>shopping cart</h3>
    <p> <a href="home.php">home</a> / cart </p>
  </div>

  <section class="shopping-cart">

    <h1 class="title">products added</h1>

    <div class="box-container">
      <?php
      if (mysqli_num_rows($get_cart)) {
        $all_price = 0;
        while ($row = mysqli_fetch_assoc($get_cart)) {
      ?>
          <div class="box">
            <a href="cart.php?delete=<?= $row["id"] ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
            <img src="uploaded_img/<?= $row["image"] ?>" alt="">
            <div class="name"><?= $row["name"] ?></div>
            <div class="price">$<?= $row["price"] ?>/-</div>

            <form action="" method="post">
              <input type="hidden" name="cart_id" value="<?= $row["id"] ?>">
              <input type="number" min="1" name="cart_quantity" value="<?= $row["quantity"] ?>">
              <input type="submit" name="update_cart" value="update" class="option-btn">
            </form>

            <div class="sub-total"> sub total : <span>$<?= $row["price"] * $row["quantity"] ?>/-</span> </div>
          </div>
      <?php
          $all_price += $row["price"] * $row["quantity"];
        }
      };
      ?>
    </div>

    <div style="margin-top: 2rem; text-align:center;">

      <?php
      if (!isset($all_price)) {
        echo  "<a href='cart.php?delete_all=' class='delete-btn disabled' >
                delete all
              </a>";
      } else {
        echo  "<a href='cart.php?delete_all' class='delete-btn' >
                delete all
              </a>";
      }
      ?>


      </button>
    </div>

    <div class="cart-total">
      <p>Total Price : <span>$<?= isset($all_price) ? $all_price : 0 ?> /-</span></p>
      <div class="flex">
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="checkout.php" class="btn <?= $all_price > 0 ? '' : 'disabled' ?> ">proceed to checkout</a>
      </div>
    </div>

  </section>
  <?php include 'footer.php'; ?>
  <script src="js/script.js"></script>

</body>

</html>
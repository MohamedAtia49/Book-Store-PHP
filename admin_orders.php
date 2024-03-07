<?php
include "config.php";
session_start();
$admin_id = $_SESSION["admin_id"];
if (isset($admin_id)) {
  if (isset($_POST["update_order"])) {
    $order_id = $_POST["order_id"];
    $update_payment = $_POST["update_payment"];
    mysqli_query($db_connect, "UPDATE `orders` SET  payment_status = '$update_payment' WHERE id = $order_id ") or die("Query failed");
    $message[] = 'payment status has been updated!';
  }
} else {
  header("location: login.php");
};

if(isset($_GET["delete"])){
  mysqli_query($db_connect,"DELETE FROM `orders` WHERE id = '$_GET[delete]' ");
  header("location: admin_orders.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

  <?php include 'admin_header.php'; ?>

  <section class="orders">

    <h1 class="title">placed orders</h1>

    <div class="box-container">
      <?php
      $all_orders = mysqli_query($db_connect, "SELECT * FROM `orders`");

      if (mysqli_num_rows($all_orders) > 0) {
        while ($row = mysqli_fetch_assoc($all_orders)) {
      ?>
          <div class="box">
            <p> user id : <span><?= $row["user_id"] ?></span> </p>
            <p> placed on : <span><?= $row["placed_on"] ?></span> </p>
            <p> name : <span><?= $row["name"] ?></span> </p>
            <p> number : <span><?= $row["number"] ?></span> </p>
            <p> email : <span><?= $row["email"] ?></span> </p>
            <p> address : <span><?= $row["address"] ?></span> </p>
            <p> total products : <span><?= $row["total_products"] ?></span> </p>
            <p> total price : <span>$<?= $row["total_price"] ?>/-</span> </p>
            <p> payment method : <span><?= $row["method"] ?></span> </p>
            <form action="" method="post">
              <input type="hidden" name="order_id" value="<?= $row["id"] ?>">
              <select name="update_payment">
                <option value="" selected disabled><?= $row["payment_status"] ?></option>
                <option value="pending">pending</option>
                <option value="completed">completed</option>
              </select>
              <input type="submit" value="update" name="update_order" class="option-btn">
              <a href="admin_orders.php?delete=<?= $row["id"] ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
            </form>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

    </div>

  </section>

  <script src="js/admin_script.js"></script>

</body>

</html>
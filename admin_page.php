<?php
include "config.php";

session_start();

$admin_id = $_SESSION["admin_id"];

if (!isset($admin_id)) {
  header("location:login.php");
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
  <?php include 'admin_header.php'; ?>

  <section class="dashboard">

    <h1 class="title">dashboard</h1>

    <div class="box-container">

      <div class="box">
        <?php
        $total_pending = 0;
        $select_pending = "SELECT total_price FROM `orders` WHERE `payment_status` = 'pending'";
        $result = mysqli_query($db_connect, $select_pending);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $total_pending += $row["total_price"];

          };
        };
        ?>
        <h3>$<?php echo $total_pending; ?>/-</h3>
        <p>Total pendings</p>
      </div>

      <div class="box">
        <?php
          $total_completed = 0;
          $select_completed = "SELECT total_price FROM `orders` WHERE `payment_status` = 'completed' ";
          $result = mysqli_query($db_connect,$select_completed);

          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              $total_completed += $row["total_price"];
            }
          }
        ?>
        <h3>$<?php echo $total_completed; ?>/-</h3>
        <p>Completed payments</p>
      </div>

      <div class="box">
          <?php $select_orders = mysqli_query($db_connect,"SELECT * FROM `orders`") ?>
          <h3><?php echo mysqli_num_rows($select_orders); ?></h3>
        <p>Order placed</p>
      </div>

      <div class="box">
          <?php $select_products = mysqli_query($db_connect,"SELECT * FROM `products`") ?>
        <h3><?= mysqli_num_rows($select_products); ?></h3>
        <p>products added</p>
      </div>

      <div class="box">
          <?php $normal_users = mysqli_query($db_connect,"SELECT * FROM `users` WHERE `user_type` = 'user' ") ?>
        <h3><?= mysqli_num_rows($normal_users)?></h3>
        <p>Normal users</p>
      </div>

      <div class="box">
      <?php $admin_users = mysqli_query($db_connect,"SELECT * FROM `users` WHERE `user_type` = 'admin' ") ?>
        <h3><?= mysqli_num_rows($admin_users)?></h3>
        <p>Admin users</p>
      </div>

      <div class="box">
      <?php $all_accounts = mysqli_query($db_connect,"SELECT * FROM `users` ") ?>
        <h3><?= mysqli_num_rows($all_accounts)?></h3>
        <p>Total accounts</p>
      </div>

      <div class="box">
      <?php $messages = mysqli_query($db_connect,"SELECT * FROM `message` ") ?>
        <h3><?= mysqli_num_rows($messages)?></h3>
        <p>Messages</p>
      </div>

    </div>
  </section>
  <script src="js/admin_script.js"></script>

</body>

</html>
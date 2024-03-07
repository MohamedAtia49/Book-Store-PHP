<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
  header('location:login.php');
}

if (isset($_GET["delete"])) {
  $get_users = mysqli_query($db_connect, "DELETE FROM `users` WHERE id = '$_GET[delete]' ") or die("Query Failed");
  header("location: admin_users.php");
  $message[] = "User deleted successfully!";
}
if(isset($_POST["make_admin"])){
  $user_id = $_POST["user_id"];
  mysqli_query($db_connect,"UPDATE `users` SET `user_type` = 'admin' WHERE id = '$user_id' ")or die("Query failed");
  $message[]= "This user is an admin now!";
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>users</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

  <?php include 'admin_header.php'; ?>

  <section class="users">

    <h1 class="title"> User accounts </h1>

    <div class="box-container">
      <?php
      $users = mysqli_query($db_connect, "SELECT * FROM `users`");
      if (mysqli_num_rows($users) > 0) {
        while ($row = mysqli_fetch_assoc($users)) {
      ?>
          <div class="box">
            <p> user id : <span><?= $row["id"] ?></span> </p>
            <p> username : <span><?= $row["name"] ?></span> </p>
            <p> email : <span><?= $row["email"] ?></span> </p>
            <p> user type : <span style="color: <?= $row["user_type"] == "admin" ? "var(--orange)" : "" ?> ;"><?= $row["user_type"] ?></span> </p>
            <div>

              <?php
              if ($row["user_type"] == "user") {
                echo "<a href='admin_users.php?delete=" . $row["id"] . "' onclick='return confirm('delete this user?');' class='delete-btn disabled'>
              delete user</a>";
              ?>
                <form action="" method="post">
                  <input type="hidden" name="user_id" value="<?= $row["id"] ?>">
                  <input type="submit" name="make_admin" value="Make Admin" class="option-btn">
                </form>
              <?php
              }
              ?>

            </div>


          </div>
      <?php
        };
      };
      ?>
    </div>

  </section>









  <!-- custom admin js file link  -->
  <script src="js/admin_script.js"></script>

</body>

</html>
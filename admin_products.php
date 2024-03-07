<?php
include "config.php";
session_start();

$admin_id = $_SESSION["admin_id"];

if (!isset($admin_id)) {
  header("Loaction: login.php");
};

if (isset($_POST["add_product"])) {
  $name = mysqli_real_escape_string($db_connect, $_POST["name"]);
  $price = $_POST["price"];
  $image = $_FILES["image"]["name"];
  $image_size = $_FILES["image"]["size"];
  $image_tmp_name = $_FILES["image"]["tmp_name"];
  $image_folder = "uploaded_img/" . $image;

  $select_products = mysqli_query($db_connect, "SELECT * FROM `products` WHERE name = '$name'");

  if (mysqli_num_rows($select_products) > 0) {
    $message[] = "Product name already added";
  } else {

    if ($image_size > 2000000) {
      $message[] = "Image size is too large";
    } else {
      mysqli_query($db_connect, "INSERT INTO `products`(name,price,image) VALUES ('$name','$price','$image')");
      move_uploaded_file($image_tmp_name, $image_folder);
      $message[] = "Product added successfully!";
    }
  }
}

?>

<?php
if (isset($_POST["update_product"])) {

  $update_p_id = $_POST["update_p_id"];
  $update_name = $_POST["update_name"];
  $update_price = $_POST["update_price"];
  $update_image = $_FILES["update_image"]["name"];
  $update_image_tmp_name = $_FILES["update_image"]["tmp_name"];
  $update_image_size = $_FILES["update_image"]["size"];
  $update_folder = "uploaded_img/" . $update_image;
  $update_old_image = $_POST["update_old_image"];


  if (!empty($update_image)) {
    if ($update_image_size > 2000000) {
      $message[] = "Image file is too large";
    } else {
      mysqli_query($db_connect, "UPDATE `products` SET name = '$update_name', price = '$update_price', image = '$update_image' WHERE id = '$update_p_id'") or die('update failed');
      move_uploaded_file($update_image_tmp_name, $update_folder);
      unlink('uploaded_img/' . $update_old_image);
      header("location: admin_products.php");
    }
  }
}
?>

<?php
if (isset($_GET["delete"])) {
  $delete_id = $_GET['delete'];
  $delete_image = mysqli_query($db_connect, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
  $fetch_delete_image = mysqli_fetch_assoc($delete_image);
  unlink('uploaded_img/'.$fetch_delete_image['image']);
  mysqli_query($db_connect, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
  header('location:admin_products.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

  <?php include 'admin_header.php'; ?>

  <section class="add-products">

    <h1 class="title">Shop products</h1>
    <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
    </form>
  </section>

  <section class="show-products">

    <div class="box-container">

      <?php
      $getProducts = mysqli_query($db_connect, "SELECT * FROM `products`");

      if (mysqli_num_rows($getProducts) > 0) {
        while ($row = mysqli_fetch_assoc($getProducts)) {
      ?>
          <div class="box">
            <img src="uploaded_img/<?= $row["image"]; ?>" alt="">
            <div class="name"><?= $row["name"]; ?></div>
            <div class="price">$<?= $row["price"]; ?>/-</div>
            <a href="admin_products.php?update=<?= $row["id"]; ?>" class="option-btn">update</a>
            <a href="admin_products.php?delete=<?= $row["id"]; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">no products added yet!</p>';
      }
      ?>

    </div>

  </section>
  <section class="edit-product-form">
    <?php if (isset($_GET["update"])) {
      $update_id = $_GET["update"];
      $update_product = mysqli_query($db_connect, "SELECT * FROM `products` WHERE `id` = $update_id");

      if (mysqli_num_rows($update_product) > 0) {
        while ($row = mysqli_fetch_assoc($update_product)) {
    ?>
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_id" value="<?= $row["id"] ?>">
            <input type="hidden" name="update_old_image" value="<?= $row["image"] ?>">
            <img src="uploaded_img/<?= $row["image"] ?>" alt="">
            <input type="text" name="update_name" value="<?= $row["name"] ?>" class="box" required placeholder="enter product name">
            <input type="number" name="update_price" value="<?= $row["price"] ?>" min="0" class="box" required placeholder="enter product price">
            <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
            <input type="submit" value="update" name="update_product" class="btn">
            <input type="reset" value="cancel" id="close-update" class="option-btn">
          </form>
    <?php
        }
      }
    } else {
      echo "<script>document.querySelector('.edit-product-form').style.display = 'none';</script>";
    } ?>
  </section>
  <script src="js/admin_script.js"></script>
</body>

</html>
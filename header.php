<?php
include "config.php";
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span style="color:red;">' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">


   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">Yousef Book</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <?php if (isset($user_id)) {
               echo "<div id='user-btn' class='fas fa-user'></div>";
            } ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i>
               <?php
               if (isset($user_id)) {
                  $get_cart = mysqli_query($db_connect, "SELECT * FROM `cart` WHERE user_id = '" . $user_id . "' ");
                  $cart_num = mysqli_num_rows($get_cart);
               } else {
                  echo "<a href='login.php'>Login</a>";
               };
               ?>
               <span><?php if (isset($user_id)) {
                        echo $cart_num;
                     } ?></span>

            </a>
         </div>

         <div class="user-box">
            <p>username : <span><?= $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?= $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
         </div>
      </div>
   </div>

</header>
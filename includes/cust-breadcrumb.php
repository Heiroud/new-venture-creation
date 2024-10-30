<?php
   $current_page = basename($_SERVER['PHP_SELF']);
?>
<nav aria-label="breadcrumb">
   <ol class="breadcrumb d-flex justify-content-between">
      <div class="d-flex">
         <li class="breadcrumb-item"><a href="home.php">Circuit Bay</a></li>
         <li class="breadcrumb-item active">
            <?php
               if($current_page == 'home.php'){
                  ?>Home<?php
               }elseif($current_page == 'cart.php'){
                  ?>Cart<?php
               }elseif($current_page == 'inbox.php'){
                  ?>Inbox<?php
               }elseif($current_page == 'orders.php'){
                  ?>Orders<?php
               }elseif($current_page == 'product-view.php'){
                  ?>Product<?php
               }elseif($current_page == 'profile.php'){
                  ?>Profile<?php
               }
            ?>
         </li>
      </div>
      <div class="cart-but">
         <?php
            $cart = mysqli_query($conn, "SELECT COUNT(*) AS num_cart FROM `cart` WHERE `cust_id` = '$session_id' AND `checkout` = TRUE");
            if($row = mysqli_fetch_assoc($cart)){
               $num_cart = $row['num_cart'];  
            }else{
               $num_cart = 0;
            }
            ?>
               <a href="cart.php" class="cart-nav ms-auto"><i class="bi-cart-fill"></i>Cart
                  <span class="badge ms-1 rounded-pill"><?php echo $num_cart ?></span>
               </a>
            <?php
         ?>
      </div>
   </ol>
</nav>
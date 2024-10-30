<?php
   include "../conn.php";
   include "process.php";
   if(isset($_SESSION['session_id'])){
      $session_id = $_SESSION['session_id'];
      $check_info = mysqli_query($conn, "SELECT * FROM `customers` WHERE `cust_id` = '$session_id'");
      $count_info = mysqli_fetch_assoc($check_info);
      $session_name = $count_info['name'];
      $session_email = $count_info['email'];
      $session_phone = $count_info['phone'];
      //picture
      $check_pic = mysqli_query($conn, "SELECT `picture_path` FROM `cust_picture` WHERE `cust_id` = '$session_id'");
      if($fetch_pic = mysqli_fetch_assoc($check_pic)){
        $session_pic = "../assets/img/cust_img/" . $fetch_pic['picture_path'];
      }else{
        $session_pic = "../assets/img/default.jpg";
      }
      ?>         
         <!DOCTYPE html>
         <html lang="en">
         <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Circuit Bay | Product</title>
            <link href="../assets/img/logo.png" rel="icon">
            <!-----=====---- VENDOR CSS FILES ----======----->
            <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
            <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
            <!-----=======--- TEMPLATE MAIN CSS FILE ---========-->
            <link href="../assets/css/home.css" rel="stylesheet">
         </head>
         <body>
            <!-- ======= Alerts ======= -->
            <?php include "../includes/alerts.php"; ?>
            <!-- ======= Header ======= -->
            <?php include "../includes/cust-header.php"; ?>

            <!-- ======= Main ======= -->
            <main id="main">
               <!-- ======= Product view ======= -->
               <section class="product-view" id="product-view">
                  <!-- Breadcrumbs -->
                  <?php include "../includes/cust-breadcrumb.php" ?>
                  <div class="container">
                     <div class="row product-card">
                        <div class="col-12">
                           <?php
                              if(isset($_GET['prod_id'])){
                                 $prod_id = $_GET['prod_id'];
                                 $select_prod = mysqli_query($conn, "SELECT * FROM `products` WHERE `prod_id` = '$prod_id'");
                                 while($fetch_prod = mysqli_fetch_assoc($select_prod)){
                                    $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                                    if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                       $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                                    }else{
                                       $prod_pic = "../assets/img/img.jpg";
                                    }
                                    //Sales
                                    $select_sales = mysqli_query($conn, "SELECT * FROM `sales` WHERE `prod_id` = '$prod_id'");
                                    $fetch_sales = mysqli_fetch_assoc($select_sales);
                                    ?>
                                       <div class="card h-100">
                                          <div class="row card-body">
                                             <div class="col-lg-6 image">                        
                                                <?php
                                                   if($fetch_sales['old_price'] > $fetch_sales['new_price']){
                                                      ?><div class="badge text-white position-absolute" style="top: 0.9rem; right: 0.7rem">Sale</div><?php
                                                   }
                                                ?>
                                                <img src="<?php echo $prod_pic ?>">
                                             </div>
                                             <div class="row col-lg-6 details">
                                                <div class="col-12">
                                                   <h4><?php echo $fetch_prod['name'] ?></h4>
                                                   <p><?php echo $fetch_prod['description'] ?></p>
                                                   <?php
                                                      if($fetch_sales['old_price'] <= $fetch_sales['new_price']){
                                                         ?><h2>₱<?php echo number_format($fetch_prod['price'], 0, '.', ','); ?></h2><?php
                                                      }elseif($fetch_sales['old_price'] > $fetch_sales['new_price']){
                                                         ?><h2><span class="text-muted text-decoration-line-through">₱<?php echo number_format($fetch_sales['old_price'], 0, '.', ','); ?></span> ₱<?php echo number_format($fetch_prod['price'], 0, '.', ','); ?></h2><?php
                                                      }
                                                   ?>
                                                </div>
                                                <div class="col-12">
                                                   <form action="process.php?prod_id=<?php echo $prod_id ?>" method="POST">
                                                      <input type="hidden" name="cart_propic_id" value="<?php echo $fetch_pic['propic_id'] ?>">
                                                      <input type="hidden" name="cart_prod_name" value="<?php echo $fetch_prod['name'] ?>">
                                                      <input type="hidden" name="cart_prod_price" value="<?php echo $fetch_prod['price'] ?>">
                                                      <div class="quantity d-flex gap-2 align-items-center">
                                                         <label>Quantity:</label>
                                                         <input type="number" name="cart_quantity" min="1" class="form-control" required>
                                                      </div>
                                                      <div class="buttons"> 
                                                         <input type="submit" name="add-cart" class="add-cart" value="Add To Cart">
                                                         <input type="submit" name="buy-now" class="buy-now" value="Buy Now">
                                                      </div>
                                                   </form>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                 }
                              }
                           ?>
                        </div>
                        <hr class="mt-4">
                        <?php
                           $select_prod = mysqli_query($conn, "SELECT * FROM `products` ORDER BY RAND() LIMIT 12");
                           while($fetch_prod = mysqli_fetch_assoc($select_prod)){
                              $prod_id = $fetch_prod['prod_id'];
                              $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                              if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                 $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                              }else{
                                 $prod_pic = "../assets/img/img.jpg";
                              }
                              //Sales
                              $select_sales = mysqli_query($conn, "SELECT * FROM `sales` WHERE `prod_id` = '$prod_id'");
                              $fetch_sales = mysqli_fetch_assoc($select_sales);
                              ?>
                                 <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-3 mt-2">
                                    <a href="product-view.php?prod_id=<?php echo $prod_id ?>">
                                       <div class="card cardo">
                                          <!-- Sale badge-->
                                          <?php
                                             if($fetch_sales['old_price'] > $fetch_sales['new_price']){
                                                ?><div class="badge text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div><?php
                                             }
                                          ?>
                                          <!-- Product image-->
                                          <img class="card-img-top" src="<?php echo $prod_pic ?>"/>
                                             <!-- Product details-->
                                             <div class="card-body p-4">
                                                <div>
                                                   <!-- Product name-->
                                                   <h5 class="fw-bolder"><?php echo $fetch_prod['name'] ?></h5>
                                                   <p><?php echo $fetch_prod['description'] ?></p>
                                                   <!-- Product price-->
                                                   <?php
                                                      if($fetch_sales['old_price'] <= $fetch_sales['new_price']){
                                                         ?>₱<?php echo number_format($fetch_prod['price'], 0, '.', ','); ?><?php
                                                      }elseif($fetch_sales['old_price'] > $fetch_sales['new_price']){
                                                         ?>
                                                            <span class="text-muted text-decoration-line-through">₱<?php echo number_format($fetch_sales['old_price'], 0, '.', ','); ?></span>
                                                            ₱<?php echo number_format($fetch_prod['price'], 0, '.', ','); ?>
                                                         <?php
                                                      }
                                                   ?>
                                                </div>
                                             </div>
                                       </div>
                                    </a>
                                 </div>
                              <?php
                           }
                        ?>
                     </div>
                  </div>
               </section>
               <hr>
               <!-- ======= About ======= -->
               <?php include "../includes/about.php"; ?>
               <!-- ======= F.A.Q ======= -->
               <?php include "../includes/faq.php"; ?>
            </main>

            <!-- ======= Footer ======= -->
            <?php include "../includes/footer.php"; ?>
            
            <!---====--- BACK TO TOP ---====--->
            <button onclick="backTotopFunction()" id="backTotop" title="Go to top"><i class="bi bi-arrow-up"></i></button>
            <!---====--- VENDOR JS FILES ---====--->
            <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!---====--- TEMPLATE MAIN JS FILE ---====--->
            <script src="../assets/js/main.js"></script>

            <!-- PHP logic for mobile collapse handling -->
            <script>
               // Check if the search query exists (PHP sends this information to JS)
               const searchQueryExists = <?php echo isset($_GET['search']) ? 'true' : 'false'; ?>;
               window.addEventListener('DOMContentLoaded', function () {
                  // If the search query is set, ensure the search collapse is expanded
                  if (searchQueryExists) {
                     const searchCollapse = document.getElementById('searchCollapse');
                     searchCollapse.classList.add('show');
                  }
               });
            </script>
         </body>
         </html>
      <?php
   }else{
      ?><h1 style="display:flex; align-items: center; justify-content: center; text-align: center; height: 90vh;">Log In first to access this page.</h1><?php
   }
?>
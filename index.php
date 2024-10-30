<?php
   session_start();
   include "conn.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Circuit Bay</title>
   <link href="assets/img/logo.png" rel="icon">
   <!-----=====---- VENDOR CSS FILES ----======----->
   <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
   <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
   <!-----=======--- TEMPLATE MAIN CSS FILE ---========-->
   <link href="assets/css/index.css" rel="stylesheet">
</head>
<body>
   <!-- ======= Alerts ======= -->
   <?php include "includes/alerts.php"; ?>
   <!-- ======= Header ======= -->
   <?php include "header.php"; ?>

   <!-- ======= Home Section ======= -->
   <section id="home" class="d-flex justify-content-center align-items-center">
      <div class="container position-relative text-center">
         <h1>Welcome to Circuit Bay</h1>
         <h2>Explore Our Extensive Range of Computer Components and Accessories</h2>
         <div class="mt-3">
            <img src="assets/img/logo 3.png">
         </div>
         <a href="#products" class="btn-get-started">Shop Now</a>
      </div>
   </section><!-- End Home -->

   <!-- ======= Main ======= -->
   <main id="main">
      <!-- ======= Products ======= -->
      <section class="products" id="products">
         <div class="container">
            <div class="row">
               <?php
                  $select_prod = mysqli_query($conn, "SELECT * FROM `products` ORDER BY RAND() LIMIT 18");
                  while($fetch_prod = mysqli_fetch_assoc($select_prod)){
                     $prod_id = $fetch_prod['prod_id'];
                     $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                     if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                        $prod_pic = "assets/img/prod_img/" . $fetch_pic['product_path'];
                     }else{
                        $prod_pic = "assets/img/img.jpg";
                     }
                     //Sales
                     $select_sales = mysqli_query($conn, "SELECT * FROM `sales` WHERE `prod_id` = '$prod_id'");
                     $fetch_sales = mysqli_fetch_assoc($select_sales);
                     ?>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
                           <a href="product-view.php?prod_id=<?php echo $prod_id ?>">
                              <div class="card">
                                 <!-- Sale badge-->
                                 <?php
                                    if($fetch_sales['old_price'] > $fetch_sales['new_price']){
                                       ?><div class="badge text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div><?php
                                    }
                                 ?>
                                 <!-- Product image-->
                                 <img class="card-img-top" src="<?php echo $prod_pic ?>"/>
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
      <?php include "includes/about.php"; ?>
      <!-- ======= F.A.Q ======= -->
      <?php include "includes/faq.php"; ?>
   </main>

   <!-- ======= Footer ======= -->
   <?php include "includes/footer.php"; ?>
   
   <!---====--- BACK TO TOP ---====--->
   <button onclick="backTotopFunction()" id="backTotop" title="Go to top"><i class="bi bi-arrow-up"></i></button>
   <!---====--- VENDOR JS FILES ---====--->
   <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <!---====--- TEMPLATE MAIN JS FILE ---====--->
   <script src="assets/js/main.js"></script>
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

   <!-- ======= Modal ======= -->
   <?php include "modal.php"; ?>
</body>
</html>
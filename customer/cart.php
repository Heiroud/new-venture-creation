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
            <title>Circuit Bay | Cart</title>
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
               <!-- ======= Cart ======= -->
               <section class="cart">
                  <!-- Breadcrumbs -->
                  <?php include "../includes/cust-breadcrumb.php"; ?>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-header">
                                 <h5>My Cart</h5>
                                 <p>Review and manage the items in your cart.</p>
                              </div>
                              <div class="card-body">
                                 <form action="process.php" method="POST">
                                    <div class="card-table">
                                       <table>
                                          <tr>
                                             <th><input type="checkbox" class="form-check-input" id="checkAll"> All</th>
                                             <th>Product</th>
                                             <th>Price</th>
                                             <th>Quantity</th>
                                             <th>Total Price</th>
                                             <th>Remove</th>
                                          </tr>
                                          <?php
                                             // Fetch cart items
                                             $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `cust_id` = '$session_id' ORDER BY `cart_id` DESC");
                                             while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                                $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                                                // Fetch product details
                                                $prod_id = $fetch_cart['prod_id'];
                                                $select_prod = mysqli_query($conn, "SELECT * FROM `products` WHERE `prod_id` = '$prod_id'");
                                                $fetch_prod = mysqli_fetch_assoc($select_prod);
                                                // Fetch product image
                                                $propic_id = $fetch_cart['propic_id'];
                                                $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `propic_id` = '$propic_id'");
                                                if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                                   $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                                                }else{
                                                   $prod_pic = "../assets/img/img.jpg";
                                                }
                                                ?>
                                                   <tr>
                                                      <td><input type="checkbox" name="checked[]" value="<?php echo $fetch_cart['cart_id']; ?>" class="form-check-input productCheck"></td>
                                                      <td>
                                                         <div class="d-flex gap-2 align-items-center">
                                                            <div class="pro-img">
                                                               <img src="<?php echo $prod_pic; ?>" alt="Product Image">
                                                            </div>
                                                            <span><?php echo $fetch_cart['product']; ?></span>
                                                         </div>
                                                      </td>
                                                      <td>₱<?php echo number_format($fetch_cart['price'], 0, '.', ','); ?></td>
                                                      <td>
                                                         <div class="quantity d-flex gap-2">
                                                            <input type="number" name="quantity" value="<?php echo $fetch_cart['quantity']; ?>" class="form-control" disabled>
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#quantity-modal_<?php echo $fetch_cart['cart_id']; ?>">
                                                               <i class="bi bi-pencil-square"></i>
                                                            </button>
                                                         </div>
                                                      </td>
                                                      <td>₱<?php echo number_format($total_price, 0, '.', ','); ?></td>
                                                      <td>
                                                         <button type="button" data-bs-toggle="modal" data-bs-target="#delete-product_<?php echo $fetch_cart['cart_id']; ?>">
                                                            <i class="bi bi-x-circle-fill"></i>
                                                         </button>
                                                      </td>
                                                   </tr>
                                                   <!-- Quantity Modal -->
                                                   <div id="quantity-modal_<?php echo $fetch_cart['cart_id']; ?>" class="modal">
                                                      <div class="modal-dialog modal-sm modal-dialog-centered">
                                                         <div class="modal-content">
                                                            <div class="modal-body cart_modals">
                                                               <h5 class="mb-3">Edit Quantity</h5>
                                                               <form action="process.php?cart_id=<?php echo $fetch_cart['cart_id']; ?>" method="POST">
                                                                  <div class="quant">
                                                                     <input type="number" name="quantity" value="<?php echo $fetch_cart['quantity']; ?>" min="1" class="form-control" required>
                                                                  </div>
                                                                  <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                     <input type="submit" name="edit-quant" value="Save">
                                                                     <input type="button" data-bs-dismiss="modal" value="Close">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <!-- Delete Product Modal -->
                                                   <div id="delete-product_<?php echo $fetch_cart['cart_id']; ?>" class="modal">
                                                      <div class="modal-dialog modal-sm modal-dialog-centered">
                                                         <div class="modal-content">
                                                            <div class="modal-body cart_modals">
                                                               <h5 class="mb-3">Remove from cart?</h5>
                                                               <p><?php echo $fetch_cart['product']; ?></p>
                                                               <form action="process.php?cart_id=<?php echo $fetch_cart['cart_id']; ?>" method="POST">
                                                                  <div class="button d-flex justify-content-end gap-3">
                                                                     <input type="hidden" name="prod_id" value="<?php echo $fetch_cart['prod_id']; ?>">
                                                                     <input type="submit" name="remove-cart" value="Remove">
                                                                     <input type="button" data-bs-dismiss="modal" value="Cancel">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                <?php 
                                             }
                                          ?>
                                       </table>
                                    </div>
                                    <!-- Check Out Buttons -->
                                    <div class="card fixed-bottom below-buttons pt-1">
                                       <div class="card-body">
                                          <div class="d-flex justify-content-between">
                                             <input type="submit" name="deleteSelected" id="deleteSelected" value="Delete Selected" disabled>
                                             <input type="submit" name="checkOut" id="checkOut" value="Check Out" disabled>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
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

            <!---====--- VENDOR JS FILES ---====--->
            <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!---====--- TEMPLATE MAIN JS FILE ---====--->
            <script src="../assets/js/main.js"></script>
         </body>
         </html>
      <?php
   }else{
      ?><h1 style="display:flex; align-items: center; justify-content: center; text-align: center; height: 90vh;">Log In first to access this page.</h1><?php
   }
?>
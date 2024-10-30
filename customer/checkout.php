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
            <title>Circuit Bay | Check Out</title>
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
               <!-- ======= Check Out ======= -->
               <section class="checkout">
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <div class="card address-card">
                              <div class="card-body row">
                                 <div class="col-lg-8">
                                    <h5><i class="bi bi-geo-alt-fill"></i> Delivery Address</h5>
                                    <?php
                                       $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
                                       $count_address = mysqli_num_rows($select_address);
                                       if($count_address > 0){
                                          $fetch_add = mysqli_fetch_assoc($select_address);
                                          ?><p><strong><?php echo $session_name ?> <?php echo $session_phone ?></strong>&nbsp;&nbsp;<?php echo $fetch_add['address'] ?></p><?php
                                       }else{
                                          ?><p><strong>Please provide complete address. Click edit!</strong></p><?php
                                       }
                                    ?>
                                 </div>
                                 <div class="col-lg-4 d-flex justify-content-end">
                                    <div><button type="button" data-bs-toggle="modal" data-bs-target="#edit-address">Edit</button></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php
                           $order_total = 0;
                           $total_items = 0;
                           $shipping = 99;
                           $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `cust_id` = '$session_id' AND `checkout` = FALSE");
                           while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                              $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                              $order_total += $sub_total + $shipping;
                              $total_items += $fetch_cart['quantity'];
                              //product pic
                              $propic_id = $fetch_cart['propic_id'];
                              $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `propic_id` = '$propic_id'");
                              if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                 $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                              }else{
                                 $prod_pic = "../assets/img/img.jpg";
                              }
                              ?>
                                 <div class="col-12 mt-2">
                                    <div class="card">
                                       <div class="card-body row">
                                          <div class="col-lg-6">
                                             <h5>Product Ordered</h5>
                                             <div class="d-flex gap-2">
                                                <div class="img-ordered">
                                                   <img src="<?php echo $prod_pic ?>">
                                                </div>
                                                <div><p><?php echo $fetch_cart['product'] ?></p></div>
                                             </div>
                                          </div>
                                          <div class="col-lg-6">
                                             <div class="card-table mt-3">
                                                <table>
                                                   <tr>
                                                      <th>Price</th>
                                                      <th>Quantity</th>
                                                      <th>Subtotal</th>
                                                   </tr>
                                                   <tr>
                                                      <td>₱<?php echo number_format($fetch_cart['price'], 0, '.', ','); ?></td>
                                                      <td><?php echo $fetch_cart['quantity'] ?></td>
                                                      <td>₱<?php echo number_format($sub_total, 0, '.', ','); ?></td>
                                                   </tr>
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <!--check out buttons-->
                                 <div class="card fixed-bottom">
                                    <div class="card-body">
                                       <div class="row">
                                          <div class="col-lg-6 payments-details">
                                             <?php
                                                if(isset($_POST['change-pm'])){
                                                   $pm_name = $_POST['change-pm'];
                                                   ?><strong>Payment Method: <button type="button" data-bs-toggle="modal" data-bs-target="#payment-method"><?php echo $pm_name ?></button></strong><?php
                                                }else{
                                                   ?><strong>Payment Method: <button type="button" data-bs-toggle="modal" data-bs-target="#payment-method" required>Select</button></strong><?php
                                                }
                                             ?>
                                          </div>
                                          <div class="col-lg-6 totals-submit">
                                             <div class="d-flex gap-2">
                                                <p>Shipping: <h5>₱<?php echo number_format($shipping, 0, '.', ','); ?>;</h5></p>
                                             </div>
                                             <div class="d-flex gap-2">
                                                <p>Order Total: <h5>₱<?php echo number_format($order_total, 0, '.', ','); ?>;</h5> Item(<?php echo $total_items ?>)</p>     
                                             </div>
                                             <div class="mt-3 d-flex justify-content-end">
                                                <form action="process.php" method="POST">
                                                   <button type="button" data-bs-toggle="modal" data-bs-target="#cancel-order">Cancel</button>
                                                   <?php
                                                      if(isset($_POST['change-pm'])){
                                                         $pm_name = $_POST['change-pm'];
                                                      }
                                                   ?>
                                                   <input type="hidden" name="pro-id" value="<?php echo $fetch_cart['prod_id'] ?>">
                                                   <input type="hidden" name="product" value="<?php echo $fetch_cart['product'] ?>">
                                                   <input type="hidden" name="pro-pic" value="<?php echo $fetch_cart['propic_id'] ?>">
                                                   <input type="hidden" name="totalpay" value="<?php echo $order_total ?>">
                                                   <input type="hidden" name="items" value="<?php echo $total_items ?>">
                                                   <input type="hidden" name="payment" value="<?php echo $pm_name ?>">
                                                   <?php
                                                      $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
                                                      $count_address = mysqli_num_rows($select_address);
                                                      if(isset($_POST['change-pm']) && $count_address > 0){
                                                         ?><input type="submit" name="place-order" value="Place Order"><?php
                                                      }else{
                                                         ?><input type="submit" value="Place Order" disabled><?php
                                                      }
                                                   ?>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
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

            <!---====--- VENDOR JS FILES ---====--->
            <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!---====--- TEMPLATE MAIN JS FILE ---====--->
            <script src="../assets/js/main.js"></script>

            <!-- Edit Address Modal -->
            <div id="edit-address" class="modal">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <h5 class="mb-3">Edit Address</h5>
                        <div>
                           <form action="process.php?cust_id=<?php echo $session_id ?>" method="POST">
                              <?php
                                 $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
                                 $count_address = mysqli_num_rows($select_address);
                                 if($count_address > 0){
                                    $fetch_address = mysqli_fetch_assoc($select_address);
                                    ?>
                                       <div>
                                          <label class="form-label">Complete Address</label>
                                          <h6>St. Brgy. City Province Region</h6>
                                          <textarea name="address" class="form-control" rows="3" required><?php echo $fetch_address['address'] ?></textarea>
                                       </div>
                                    <?php
                                 }else{
                                    ?>
                                       <div>
                                          <label class="form-label">Complete Address</label>
                                          <h6>St. Brgy. City Province Region</h6>
                                          <textarea name="address" class="form-control is-invalid" rows="3" required></textarea>
                                          <div class="invalid-feedback">
                                             Please provide complete address.
                                          </div>
                                       </div>
                                    <?php
                                 }
                              ?>
                              <div class="button d-flex justify-content-end gap-3 mt-3">
                                 <input type="submit" name="edit-address" value="Save">
                                 <input type="button" data-bs-dismiss="modal" value="Close">
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Payment Method Modal -->
            <div id="payment-method" class="modal">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body checkout_modals">
                        <h5 class="mb-3">Payment Method</h5>
                        <div>
                           <form action="checkout.php" method="POST">
                              <div class="mb-1 payment-method">
                                 <?php 
                                    $select_pm = mysqli_query($conn, "SELECT * FROM `payment_method`");
                                    while($fetch_pm = mysqli_fetch_assoc($select_pm)){
                                       ?><input type="submit" name="change-pm" value="<?php echo $fetch_pm['name'] ?>" class="m-1"><?php
                                    }
                                 ?>
                              </div>
                              <div class="mt-3 d-flex justify-content-end">
                                 <button type="button" data-bs-dismiss="modal">Close</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Cancel Order Modal -->
            <div id="cancel-order" class="modal">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <h5 class="mb-3">Cancel Order?</h5>
                        <div>
                           <form action="process.php" method="POST">
                              <div class="button d-flex justify-content-end gap-3">
                                 <input type="submit" name="cancel-order" value="Yes">
                                 <input type="button" data-bs-dismiss="modal" value="No">
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </body>
         </html>
      <?php
   }else{
      ?><h1 style="display:flex; align-items: center; justify-content: center; text-align: center; height: 90vh;">Log In first to access this page.</h1><?php
   }
?>
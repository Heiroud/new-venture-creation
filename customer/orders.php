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
            <title>Circuit Bay | Orders</title>
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
               <!-- ======= Orders ======= -->
               <section class="orders" id="orders">
                  <!-- Breadcrumbs -->
                  <?php include "../includes/cust-breadcrumb.php" ?>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-header">
                                 <h5>Orders</h5>
                                 <p>Review and manage your orders.</p>
                              </div>
                              <div class="card-body">
                                 <div class="card-table">
                                    <table>
                                       <tr>
                                          <th>Details</th>
                                          <th>Product</th>
                                          <th>Status</th>
                                       </tr>
                                       <?php
                                          //Pagination
                                          if(isset($_GET['page_no']) && $_GET['page_no'] !== ''){
                                             $page_no = $_GET['page_no'];
                                          }else{
                                             $page_no = 1;
                                          }

                                          $total_records_per_page = 10;
                                          $offset = ($page_no - 1) * $total_records_per_page;
                                          $previous_page = $page_no - 1;
                                          $next_page = $page_no + 1;

                                          $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM `orders` WHERE `cust_id` = '$session_id' AND `cust_done` = TRUE");
                                          $records = mysqli_fetch_assoc($result_count);
                                          $total_records = $records['total_records'];
                                          $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                          //End Pagination

                                          $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE `cust_id` = '$session_id' AND `cust_done` = TRUE ORDER BY `order_id` DESC LIMIT $offset, $total_records_per_page");
                                          while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                                             $prod_id = $fetch_orders['prod_id'];
                                             //product picture
                                             $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                                             if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                                $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                                             }else{
                                                $prod_pic = "../assets/img/img.jpg";
                                             }
                                             //product
                                             $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE `prod_id` = '$prod_id'");
                                             $fetch_product = mysqli_fetch_assoc($select_product);
                                             //address
                                             $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
                                             $fetch_address = mysqli_fetch_assoc($select_address);
                                             ?>
                                                <tr>
                                                   <td>
                                                      <?php
                                                         if($fetch_orders['status'] == 0){
                                                            ?><button type="button" data-bs-toggle="modal" data-bs-target="#buyer-details_<?php echo $fetch_orders['order_id'] ?>">View</button><?php
                                                         }elseif($fetch_orders['status'] == 1){
                                                            ?><button class="waiting" type="button" data-bs-toggle="modal" data-bs-target="#waiting-arrival_<?php echo $fetch_orders['order_id'] ?>">Waiting</button><?php
                                                         }elseif($fetch_orders['status'] == 2){
                                                            ?>
                                                               <form action="process.php?order_id=<?php echo $fetch_orders['order_id'] ?>" method=POST>
                                                                  <input type="submit" name="cust-done" value="Done">
                                                               </form>
                                                            <?php
                                                         }
                                                      ?>
                                                   </td>
                                                   <td>
                                                      <div class="d-flex gap-2">
                                                         <div class="pro-img">
                                                            <img src="<?php echo $prod_pic ?>">
                                                         </div>
                                                         <span><?php echo $fetch_orders['product'] ?></span>
                                                      </div>
                                                   </td>
                                                   <td>
                                                      <?php
                                                         if($fetch_orders['status'] == 0){
                                                            ?>Pending<?php
                                                         }elseif($fetch_orders['status'] == 1){
                                                            ?>Waiting for Arrival<?php
                                                         }elseif($fetch_orders['status'] == 2){
                                                            ?>Product Received<?php
                                                         }
                                                      ?>
                                                   </td>
                                                </tr>
                                                <!-- Buyer Details Modal -->
                                                <div id="buyer-details_<?php echo $fetch_orders['order_id'] ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body cust_orders">
                                                            <h5>Details</h5>
                                                            <p class="mb-3 status">Wait for admin response...</p>
                                                            <div class="row">
                                                               <div class="col-12">
                                                                  <h6>Product:</h6>
                                                                  <p><?php echo $fetch_orders['product'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Description:</h6>
                                                                  <p><?php $fetch_product['description'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Payment:</h6>
                                                                  <p>₱<?php echo $fetch_orders['payment'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Items:</h6>
                                                                  <p><?php echo $fetch_orders['items'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Payment Method:</h6>
                                                                  <p><?php echo $fetch_orders['payment_method'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Complete Address:</h6>
                                                                  <p><?php echo $fetch_address['address'] ?></p>
                                                               </div>
                                                            </div>
                                                            <form class="d-flex justify-content-end mt-2">
                                                               <input type="button" data-bs-dismiss="modal" value="Close">
                                                            </form>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Waiting for Arrival Modal -->
                                                <div id="waiting-arrival_<?php echo $fetch_orders['order_id'] ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body cust_orders">
                                                            <h5>Waiting...</h5>
                                                            <p class="mb-3 status">Press "Received" if the product has arrived</p>
                                                            <div class="row">
                                                               <div class="col-12">
                                                                  <h6>Product:</h6>
                                                                  <p><?php echo $fetch_orders['product'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Description:</h6>
                                                                  <p><?php $fetch_product['description'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Payment:</h6>
                                                                  <p>₱<?php echo $fetch_orders['payment'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Items:</h6>
                                                                  <p><?php echo $fetch_orders['items'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Payment Method:</h6>
                                                                  <p><?php echo $fetch_orders['payment_method'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Complete Address:</h6>
                                                                  <p><?php echo $fetch_address['address'] ?></p>
                                                               </div>
                                                               <form action="process.php?order_id=<?php echo $fetch_orders['order_id'] ?>" method="POST">
                                                                  <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                     <input type="submit" name="received" value="Received">
                                                                     <input type="button" data-bs-dismiss="modal" value="Close">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             <?php
                                          }
                                       ?>
                                    </table>
                                 </div>
                                 <!-- ======= Pagination ======= -->
                                 <div>
                                    <nav class="mt-3 d-flex">
                                       <ul class="pagination">
                                          <li class="page-item buttons"><a class="page-link <?php echo ($page_no <= 1) ? 'disabled' : ''; ?>" <?php echo ($page_no > 1) ? 'href="?page_no=' . $previous_page . '"' : ''; ?>><i class='bx bxs-chevrons-left'></i></a></li>
                                          <?php
                                             $num_links_before_after = 1;
                                             for($i = max(1, $page_no - $num_links_before_after); $i <= min($total_no_of_pages, $page_no + $num_links_before_after); $i++){
                                                if((int)$page_no == $i){
                                                   ?><li class="page-item pages"><a class="page-link active"><?php echo $i; ?></a></li><?php
                                                }else{
                                                   ?><li class="page-item pages"><a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
                                                }
                                             }
                                          ?>
                                          <li class="page-item buttons"><a class="page-link <?php echo ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?php echo ($page_no < $total_no_of_pages) ? 'href="?page_no=' . $next_page . '"' : ''; ?>><i class='bx bxs-chevrons-right'></i></a></li>
                                       </ul>
                                    </nav>
                                    <div class="buts">
                                       <strong>Page <?php echo $page_no; ?> of <?php echo $total_no_of_pages; ?></strong>
                                    </div>
                                 </div><!-- ======= End Pagination ======= -->
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
            
            <!---====--- BACK TO TOP ---====--->
            <button onclick="backTotopFunction()" id="backTotop" title="Go to top"><i class="bi bi-arrow-up"></i></button>
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
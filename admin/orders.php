<?php
   include "../conn.php";
   include "process.php";
   if(isset($_SESSION['session_admin'])){
      $session_admin = $_SESSION['session_admin'];
      $check_admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE `admin_id` = '$session_admin'");
      $count_admin = mysqli_fetch_assoc($check_admin);
      $session_email = $count_admin['email'];
      ?>         
         <!DOCTYPE html>
         <html lang="en">
         <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Circuit Bay | Admin | Orders</title>
            <link href="../assets/img/logo.png" rel="icon">
            <!-----=====---- VENDOR CSS FILES ----======----->
            <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
            <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
            <!-----=======--- TEMPLATE MAIN CSS FILE ---========-->
            <link href="../assets/css/admin.css" rel="stylesheet">
         </head>
         <body>
            <!-- ======= Alerts ======= -->
            <?php include "../includes/alerts.php"; ?>
            <!-- ======= Header ======= -->
            <?php include "../includes/admin-header.php"; ?>
            <!-- ======= Sidebar ======= -->
            <?php include "../includes/admin-sidebar.php"; ?>

            <!-- ======= Main ======= -->
            <main id="main" class="main">
               <!-- Breadcrumbs -->
               <?php include "../includes/admin-breadcrumb.php"; ?>
               <!-- ======= Orders ======= -->
               <section class="orders" id="orders">
                  <div class="row">
                     <div class="col-12">
                        <div class="card mt-3">
                           <div class="card-header">
                              <h5>Manage Orders</h5>
                           </div>
                           <div class="card-body">
                              <div class="card-table">
                                 <table>
                                    <tr>
                                       <th>Action</th>
                                       <th>Product</th>
                                       <th>Customer</th>
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

                                       $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM `orders` WHERE `admin_done` = TRUE");
                                       $records = mysqli_fetch_assoc($result_count);
                                       $total_records = $records['total_records'];
                                       $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                       //End Pagination

                                       if(!isset($_GET['admin-orders'])){
                                          $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE `admin_done` = TRUE ORDER BY `order_id` DESC LIMIT $offset, $total_records_per_page");
                                          while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                                             $cust_id = $fetch_orders['cust_id'];
                                             $prod_id = $fetch_orders['prod_id'];
                                             //product picture
                                             $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                                             if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                                $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                                             }else{
                                                $prod_pic = "../assets/img/img.jpg";
                                             }
                                             //customer
                                             $select_customer = mysqli_query($conn, "SELECT * FROM `customers` WHERE `cust_id` = '$cust_id'");
                                             $fetch_customer = mysqli_fetch_assoc($select_customer);
                                             //product
                                             $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE `prod_id` = '$prod_id'");
                                             $fetch_product = mysqli_fetch_assoc($select_product);
                                             //address
                                             $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$cust_id'");
                                             $fetch_address = mysqli_fetch_assoc($select_address);
                                             ?>
                                                <tr>
                                                   <td>
                                                      <?php
                                                         if($fetch_orders['status'] == 0){
                                                            ?><button type="button" data-bs-toggle="modal" data-bs-target="#buyer-details_<?php echo $fetch_orders['order_id'] ?>">Details</button><?php
                                                         }elseif($fetch_orders['status'] == 1){
                                                            ?><button class="waiting" type="button" data-bs-toggle="modal" data-bs-target="#waiting-arrival_<?php echo $fetch_orders['order_id'] ?>">Waiting</button><?php
                                                         }elseif($fetch_orders['status'] == 2){
                                                            ?>
                                                               <form action="process.php?order_id=<?php echo $fetch_orders['order_id'] ?>" method="POST">
                                                                  <input type="submit" name="admin-done" value="Done">
                                                               </form>
                                                            <?php
                                                         }
                                                      ?>
                                                   </td>
                                                   <td>
                                                      <div class="d-flex gap-2 align-items-center">
                                                         <div class="pro-img">
                                                            <img src="<?php echo $prod_pic ?>">
                                                         </div>
                                                         <span><?php echo $fetch_orders['product'] ?></span>
                                                      </div>
                                                   </td>
                                                   <td><?php echo $fetch_customer['name'] ?></td>
                                                   <td>
                                                      <?php 
                                                         if($fetch_orders['status'] == 0){
                                                            ?>Pending<?php
                                                         }elseif($fetch_orders['status'] == 1){
                                                            ?>Waiting for Arrival<?php
                                                         }elseif($fetch_orders['status'] == 2){
                                                            ?>Product Arrived<?php
                                                         }
                                                      ?>
                                                   </td>
                                                </tr>
                                                <!-- Buyer Details Modal -->
                                                <div id="buyer-details_<?php echo $fetch_orders['order_id'] ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body admin_orders">
                                                            <h5 class="mb-3">Buyer Details</h5>
                                                            <div class="row">
                                                               <div class="col-12">
                                                                  <h6>Name:</h6>
                                                                  <p><?php echo $fetch_customer['name'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Product:</h6>
                                                                  <p><?php echo $fetch_orders['product'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Description:</h6>
                                                                  <p><?php echo $fetch_product['description'] ?></p>
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
                                                                     <input type="submit" name="accept-order" value="Accept">
                                                                     <input type="button" data-bs-toggle="modal" data-bs-target="#message-cust_<?php echo $fetch_customer['cust_id'] ?>" value="Message" class="mess_cust">
                                                                     <input type="button" data-bs-dismiss="modal" value="Close">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Waiting for Arrival Modal -->
                                                <div id="waiting-arrival_<?php echo $fetch_orders['order_id'] ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body admin_orders">
                                                            <h5 class="mb-3">Buyer Details</h5>
                                                            <p class="status">Waiting...</p>
                                                            <div class="row">
                                                               <div class="col-12">
                                                                  <h6>Name:</h6>
                                                                  <p><?php echo $fetch_customer['name'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Product:</h6>
                                                                  <p><?php echo $fetch_orders['product'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Description:</h6>
                                                                  <p><?php echo $fetch_product['description'] ?></p>
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
                                                                     <input type="submit" name="delete-waiting" value="Delete">
                                                                     <input type="button" data-bs-toggle="modal" data-bs-target="#message-cust_<?php echo $fetch_customer['cust_id'] ?>" value="Message" class="mess_cust">
                                                                     <input type="button" data-bs-dismiss="modal" value="Close">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Message Customer Modal -->
                                                <div id="message-cust_<?php echo $fetch_customer['cust_id'] ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body send_messages">
                                                            <h5 class="mb-3">Message</h5>
                                                            <hr>
                                                            <p>To: <?php echo $fetch_customer['name'] ?></p>
                                                            <div>
                                                               <form action="process.php?cust_id=<?php echo $fetch_customer['cust_id'] ?>" method="POST">
                                                                  <div>
                                                                     <label class="form-label mt-2">Subject</label>
                                                                     <input name="subject" class="form-control" required>
                                                                     <label class="form-label mt-2">Message</label>
                                                                     <textarea name="message" class="form-control" rows="3" required></textarea>
                                                                  </div>
                                                                  <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                     <input type="submit" name="send-message" value="Send">
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
                                       }else{
                                          include "../includes/search.php";
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
               </section>
            </main>

            <footer id="footer" class="footer">
               <ul class="nav border-bottom  mb-3"></ul>
               <p class="text-center text-muted">&copy; 2024 <strong>Circuit Bay</strong> <br> All Rights Reserved</p>
            </footer>
            
            <!---====--- VENDOR JS FILES ---====--->
            <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/vendor/chart.js/chart.umd.js"></script>
            <!---====--- TEMPLATE MAIN JS FILE ---====--->
            <script src="../assets/js/main.js"></script>
         </body>
         </html>
      <?php
   }else{
      ?><h1 style="display:flex; align-items: center; justify-content: center; text-align: center; height: 90vh;">Log In first to access this page.</h1><?php
   }
?>
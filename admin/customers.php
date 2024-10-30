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
            <title>Circuit Bay | Admin | Products</title>
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
               <!-- ======= Customers ======= -->
               <section class="customers" id="customers">
                  <div class="row">
                     <div class="col-12">
                        <div class="card mt-3">
                           <div class="card-header">
                              <h5>Manage Customers</h5>
                           </div>
                           <div class="card-body">
                              <div class="card-table">
                                 <table>
                                    <tr>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
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

                                       $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM `customers`");
                                       $records = mysqli_fetch_assoc($result_count);
                                       $total_records = $records['total_records'];
                                       $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                       //End Pagination

                                       if(!isset($_GET['search-customers'])){
                                          $select_cust = mysqli_query($conn, "SELECT * FROM `customers` ORDER BY `name` LIMIT $offset, $total_records_per_page");
                                          while($fetch_cust = mysqli_fetch_assoc($select_cust)){
                                             $cust_id = $fetch_cust['cust_id'];
                                             $cust_pic = mysqli_query($conn, "SELECT * FROM `cust_picture` WHERE `cust_id` = '$cust_id'");
                                             if($fetch_pic = mysqli_fetch_assoc($cust_pic)){
                                                $picture = "../assets/img/cust_img/".$fetch_pic['picture_path'];
                                             }else{
                                                $picture = "../assets/img/default.jpg";
                                             }
                                             ?>
                                                <tr>
                                                   <td>
                                                      <a href="" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>">
                                                         <div class="d-flex gap-2 align-items-center">
                                                            <div class="pro-img">
                                                               <img src="<?php echo $picture ?>">
                                                            </div>
                                                            <span><?php echo $fetch_cust['name'] ?></span>
                                                         </div>
                                                      </a>
                                                   </td>
                                                   <td><a href="" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>"><?php echo $fetch_cust['email'] ?></a></td>
                                                   <td><a href="" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>"><?php echo $fetch_cust['phone'] ?></a></td>
                                                </tr>
                                                <!-- Customer Details Modal -->
                                                <div id="customer-details_<?php echo $cust_id ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body cust_details">
                                                            <h5 class="mb-3">Customer Details</h5>
                                                            <div class="row">
                                                               <div class="col-12">
                                                                  <h6>Name:</h6>
                                                                  <p><?php echo $fetch_cust['name'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Email:</h6>
                                                                  <p><?php echo $fetch_cust['email'] ?></p>
                                                               </div>
                                                               <div class="col-12">
                                                                  <h6>Phone:</h6>
                                                                  <p><?php echo $fetch_cust['phone'] ?></p>
                                                               </div>
                                                               <?php
                                                                  $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$cust_id'");
                                                                  $count_address = mysqli_num_rows($select_address);
                                                                  if($count_address == 1){
                                                                     $fetch_address = mysqli_fetch_assoc($select_address);
                                                                     ?>
                                                                        <div class="col-12">
                                                                           <h6>Address:</h6>
                                                                           <p><?php echo $fetch_address['address'] ?></p>
                                                                        </div>
                                                                     <?php
                                                                  }else{
                                                                     ?>
                                                                        <div class="col-12">
                                                                           <h6>Address:</h6>
                                                                           <p>Address not provided.</p>
                                                                        </div>
                                                                     <?php
                                                                  }
                                                               ?>
                                                               <form action="">
                                                                  <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                     <input type="button" data-bs-toggle="modal" data-bs-target="#message-cust_<?php echo $cust_id ?>" value="Message" class="mess_cust">
                                                                     <input class="delete_cust" type="button" data-bs-toggle="modal" data-bs-target="#delete-customer_<?php echo $cust_id ?>" value="Delete">
                                                                     <input type="button" data-bs-dismiss="modal" value="Close">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Message Customer Modal -->
                                                <div id="message-cust_<?php echo $cust_id ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body send_messages">
                                                            <h5 class="mb-3">Message</h5>
                                                            <hr>
                                                            <p>To: <?php echo $fetch_cust['name'] ?></p>
                                                            <div>
                                                               <form action="process.php?cust_id=<?php echo $cust_id ?>" method="POST">
                                                                  <div>
                                                                     <label class="form-label mt-2">Subject</label>
                                                                     <input name="subject" class="form-control" required>
                                                                     <label class="form-label mt-2">Message</label>
                                                                     <textarea name="message" class="form-control" rows="3" required></textarea>
                                                                  </div>
                                                                  <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                     <input type="submit" name="mess-custpage" value="Send">
                                                                     <input type="button" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>" value="Back">
                                                                  </div>
                                                               </form>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Delete Customer Modal -->
                                                <div id="delete-customer_<?php echo $cust_id ?>" class="modal">
                                                   <div class="modal-dialog modal-sm modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body cust_details">
                                                            <h5 class="mb-3">Delete Customer?</h5>
                                                            <p><?php echo $fetch_cust['name'] ?></p>
                                                            <div>
                                                               <form action="">
                                                                  <div class="button d-flex justify-content-end gap-3">
                                                                     <input class="delete_cust" type="submit" value="Delete">
                                                                     <input type="button" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>" value="Cancel">
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
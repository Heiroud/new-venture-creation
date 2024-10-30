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
            <title>Circuit Bay | Admin | Sent</title>
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
               <!-- ======= Sent ======= -->
               <section class="sent" id="sent">
                  <div class="row">
                     <div class="col-12">
                        <div class="card mt-3">
                           <div class="card-header">
                              <h5>Sent Messages</h5>
                           </div>
                           <div class="card-body">
                              <form action="">
                                 <div class="card-table">
                                    <table>
                                       <tr>
                                          <th>Customer</th>
                                          <th>Subject</th>
                                          <th>Date</th>
                                       </tr>
                                       <?php
                                          //Pagination
                                          if(isset($_GET['message_page_no']) && $_GET['message_page_no'] !== '') {
                                             $message_page_no = $_GET['message_page_no'];
                                          }else{
                                             $message_page_no = 1;
                                          }
                                          
                                          $total_records_per_page = 10;
                                          $offset = ($message_page_no - 1) * $total_records_per_page;
                                          $previous_page = $message_page_no - 1;
                                          $next_page = $message_page_no + 1;
                                          
                                          $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM `message` WHERE `admin_delete` = TRUE");
                                          $records = mysqli_fetch_assoc($result_count);
                                          $total_records = $records['total_records'];
                                          $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                          //End Pagination

                                          if(!isset($_GET['search-message'])){
                                             $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE `admin_delete` = TRUE ORDER BY `mess_id` DESC LIMIT $offset, $total_records_per_page");
                                             while($fetch_message = mysqli_fetch_assoc($select_message)){
                                                $cust_id = $fetch_message['cust_id'];
                                                $select_customer = mysqli_query($conn, "SELECT * FROM `customers` WHERE `cust_id` = '$cust_id'");
                                                $fetch_customer = mysqli_fetch_assoc($select_customer);
                                                ?>
                                                   <tr>
                                                      <td><a href="" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo $fetch_customer['name'] ?></a></td>
                                                      <td><a href="" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo $fetch_message['subject'] ?></a></td>
                                                      <td><a href="" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></a></td>
                                                   </tr>
                                                   <!-- Message View Modal -->
                                                   <div id="message-view_<?php echo $fetch_message['mess_id'] ?>" class="modal">
                                                      <div class="modal-dialog modal-dialog-centered">
                                                         <div class="modal-content">
                                                            <div class="modal-body view_message">
                                                               <h5 class="mb-3">Message view</h5>
                                                               <div>
                                                                  <hr>
                                                                  <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></p>
                                                                  <p><strong>To:</strong> <?php echo $fetch_customer['name'] ?></p>
                                                                  <p>
                                                                     <?php
                                                                        if($fetch_message['read'] == 0){
                                                                           ?><p>Read</p><?php
                                                                        }elseif($fetch_message['read'] == 1){
                                                                           ?><p>Unread</p><?php
                                                                        }
                                                                     ?>
                                                                  </p>
                                                                  <hr>
                                                                  <p><?php echo $fetch_message['message'] ?></p>
                                                               </div>
                                                               <div>
                                                                  <form>
                                                                     <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                        <input type="button" data-bs-toggle="modal" data-bs-target="#delete-message_<?php echo $fetch_message['mess_id'] ?>" value="Delete">
                                                                        <input type="button" data-bs-dismiss="modal" value="Close">
                                                                     </div>
                                                                  </form>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <!-- Delete Message -->
                                                   <div id="delete-message_<?php echo $fetch_message['mess_id'] ?>" class="modal">
                                                      <div class="modal-dialog modal-sm modal-dialog-centered">
                                                         <div class="modal-content">
                                                            <div class="modal-body view_message">
                                                               <h5 class="mb-3">Delete messsage?</h5>
                                                               <p><?php echo $fetch_message['subject'] ?></p>
                                                               <div>
                                                                  <form action="process.php?mess_id=<?php echo $fetch_message['mess_id'] ?>" method="POST">
                                                                     <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                        <input type="submit" name="delete-message" value="Delete">
                                                                        <input type="button" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>" value="Cancel">
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
                                          <li class="page-item buttons"><a class="page-link <?php echo ($message_page_no <= 1) ? 'disabled' : ''; ?>" <?php echo ($message_page_no > 1) ? 'href="?message_page_no=' . $previous_page . '"' : ''; ?>><i class='bx bxs-chevrons-left'></i></a></li>
                                          <?php
                                             for ($i = max(1, $message_page_no - 1); $i <= min($total_no_of_pages, $message_page_no + 1); $i++) {
                                                if ((int)$message_page_no == $i) {
                                                   echo '<li class="page-item pages"><a class="page-link active">' . $i . '</a></li>';
                                                } else {
                                                   echo '<li class="page-item pages"><a class="page-link" href="?message_page_no=' . $i . '">' . $i . '</a></li>';
                                                }
                                             }
                                          ?>
                                          <li class="page-item buttons"><a class="page-link <?php echo ($message_page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?php echo ($message_page_no < $total_no_of_pages) ? 'href="?message_page_no=' . $next_page . '"' : ''; ?>><i class='bx bxs-chevrons-right'></i></a></li>
                                       </ul>
                                    </nav>
                                    <div class="buts">
                                       <strong>Page <?php echo $message_page_no; ?> of <?php echo $total_no_of_pages; ?></strong>
                                    </div>
                                 </div><!-- ======= End Pagination ======= -->
                              </form>
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
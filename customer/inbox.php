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
            <title>Circuit Bay | Inbox</title>
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
               <!-- ======= Inbox ======= -->
               <section class="inbox">
                  <!-- Breadcrumbs -->
                  <?php include "../includes/cust-breadcrumb.php" ?>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-header">
                                 <h5>Inbox</h5>
                                 <p>View all your support messages and order updates.</p>
                              </div>
                              <div class="card-body">
                                 <form action="">
                                    <div class="card-table">
                                       <table>
                                          <tr>
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
                                             
                                             $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM `message` WHERE `cust_id` = '$session_id' AND `cust_delete` = TRUE");
                                             $records = mysqli_fetch_assoc($result_count);
                                             $total_records = $records['total_records'];
                                             $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                             //End Pagination

                                             $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE `cust_id` = '$session_id' AND `cust_delete` = TRUE ORDER BY `mess_id` DESC LIMIT $offset, $total_records_per_page");
                                             while($fetch_message = mysqli_fetch_assoc($select_message)){
                                                if($fetch_message['read'] == FALSE){
                                                   ?>
                                                      <tr>
                                                         <td><a href="" data-bs-toggle="modal" data-bs-target="#inbox-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo $fetch_message['subject'] ?></a></td>
                                                         <td><a href="" data-bs-toggle="modal" data-bs-target="#inbox-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></a></td>
                                                      </tr>
                                                   <?php
                                                }elseif($fetch_message['read'] == TRUE){
                                                   ?>
                                                      <tr>
                                                         <td><a href="" data-bs-toggle="modal" data-bs-target="#inbox-view_<?php echo $fetch_message['mess_id'] ?>"><strong><?php echo $fetch_message['subject'] ?></strong></a></td>
                                                         <td><a href="" data-bs-toggle="modal" data-bs-target="#inbox-view_<?php echo $fetch_message['mess_id'] ?>"><strong><?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></strong></a></td>
                                                      </tr>
                                                   <?php
                                                }
                                                ?>
                                                   <!-- Inbox View -->
                                                   <div id="inbox-view_<?php echo $fetch_message['mess_id'] ?>" class="modal" data-bs-backdrop="static">
                                                      <div class="modal-dialog modal-dialog-centered">
                                                         <div class="modal-content">
                                                            <div class="modal-body view_inbox">
                                                               <h5 class="mb-3">Inbox Message</h5>
                                                               <div>
                                                                  <p><strong>From:</strong> Circuit Bay</p>
                                                                  <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></p>
                                                                  <hr>
                                                                  <p class="message"><?php echo $fetch_message['message'] ?></p>
                                                               </div>
                                                               <div>
                                                                  <form action="process.php?mess_id=<?php echo $fetch_message['mess_id'] ?>" method="POST">
                                                                     <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                        <input type="submit" name="message-read" value="Read">
                                                                        <input type="button" data-bs-toggle="modal" data-bs-target="#delete-message_<?php echo $fetch_message['mess_id'] ?>" value="Delete">
                                                                     </div>
                                                                  </form>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <!-- Delete Message -->
                                                   <div id="delete-message_<?php echo $fetch_message['mess_id'] ?>" class="modal" data-bs-backdrop="static">
                                                      <div class="modal-dialog modal-sm modal-dialog-centered">
                                                         <div class="modal-content">
                                                            <div class="modal-body view_inbox">
                                                               <h5 class="mb-3">Delete messsage?</h5>
                                                               <div>
                                                                  <form action="process.php?mess_id=<?php echo $fetch_message['mess_id'] ?>" method="POST">
                                                                     <div class="button d-flex justify-content-end gap-3 mt-3">
                                                                        <input type="submit" name="delete-message" value="Delete">
                                                                        <input type="button" data-bs-toggle="modal" data-bs-target="#inbox-view" value="Cancel">
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
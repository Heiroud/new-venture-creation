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
            <title>Circuit Bay | Admin | Account</title>
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
               <!-- ======= Account ======= -->
               <section class="account" id="account">
                  <div class="row">
                     <div class="col-12">
                        <div class="card mt-3">
                           <div class="card-header">
                              <div><h5>Manage Account</h5></div>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-lg-5 mt-3 mb-3">
                                    <form action="process.php?admin_id=<?php echo $session_admin ?>" method="POST" class="row g-3">
                                       <div class="details-form">
                                          <div class="col-l2 input-box">
                                             <label class="form-label">Email</label>
                                             <input type="email" name="up-email" value="<?php echo $session_email ?>" class="form-control" required>
                                          </div>
                                          <div class="col-12 submit-butt d-flex justify-content-end mt-3">
                                             <input type="submit" name="up-save" value="Save">
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                                 <div class="col-lg-7 change-password mt-3 mb-3">
                                    <form action="process.php" method="POST" class="row g-2 mt-3 mb-3">
                                       <div class="pass-details">
                                          <div class="col-12 input-box">
                                             <label class="form-label">Current Password</label>
                                             <input type="password" name="current-password" class="form-control" required>
                                          </div>
                                          <div class="col-12 input-box">
                                             <label class="form-label">New Password</label>
                                             <input type="password" name="new-password" class="form-control" required>
                                          </div>
                                          <div class="col-12 input-box">
                                             <label class="form-label">Confirm New Password</label>
                                             <input type="password" name="confirm-password" class="form-control" required>
                                          </div>
                                          <div class="mb-3 show-pass">
                                             <label role="button">
                                                <input type="checkbox" class="form-check-input" id="showPassword"> Show Password
                                             </label>
                                          </div>
                                          <script>
                                             const showPasswordCheckbox = document.getElementById("showPassword");
                                             const passwordFields = document.querySelectorAll('input[type="password"]');
                        
                                             showPasswordCheckbox.addEventListener("change", function () {
                                                const showPassword = this.checked;
                        
                                                passwordFields.forEach(function (field) {
                                                   field.type = showPassword ? "text" : "password";
                                                });
                                             });
                                          </script>
                                          <div class="col-12 d-flex justify-content-end mt-3">
                                             <input type="submit" name="changepass" value="Change Password">
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
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
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
            <title>Circuit Bay | Profile</title>
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
               <!-- ======= Profile ======= -->
               <section class="profile">
                  <!-- Breadcrumbs -->
                  <?php include "../includes/cust-breadcrumb.php" ?>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <div class="card">
                              <div class="card-header">
                                 <h5>My Profile</h5>
                                 <p>Update your profile and change your password here.</p>
                              </div>
                              <div class="card-body">
                                 <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                       <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-details">Profile Details</button>
                                    </li>
                                    <li class="nav-item">
                                       <button class="nav-link" data-bs-toggle="tab" data-bs-target="#change-password">Change Password</button>
                                    </li>
                                 </ul>
                                 <div class="tab-content">
                                    <div class="tab-pane fade show active profile-details" id="profile-details">
                                       <div class="row">
                                          <div class="col-lg-7 mt-3 mb-3">
                                             <form action="process.php?cust_id=<?php echo $session_id ?>" method="POST" class="row g-3">
                                                <div class="details-form">
                                                   <div class="col-12 input-box">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" name="up-name" value="<?php echo $session_name ?>" class="form-control">
                                                   </div>
                                                   <div class="col-l2 input-box">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" name="up-email" value="<?php echo $session_email ?>" class="form-control">
                                                   </div>
                                                   <div class="col-12 input-box">
                                                      <label class="form-label">Phone</label>
                                                      <input type="text" name="up-phone" value="<?php echo $session_phone ?>" class="form-control">
                                                   </div>
                                                   <?php
                                                      $check_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
                                                      $count_address = mysqli_num_rows($check_address);
                                                      if($count_address > 0){
                                                         $fetch_address = mysqli_fetch_assoc($check_address);
                                                         ?>
                                                            <div class="col-12 input-box">
                                                               <label class="form-label">Complete Address</label>
                                                               <textarea name="address" class="form-control" rows="3"><?php echo $fetch_address['address'] ?></textarea>
                                                            </div>
                                                         <?php
                                                      }else{
                                                         ?>
                                                            <div class="col-12 input-box">
                                                               <label class="form-label">Complete Address</label>
                                                               <textarea name="address" class="form-control is-invalid" rows="3" placeholder="St. Brgy. City Province Region" required></textarea>
                                                               <div class="invalid-feedback">
                                                                  Please provide complete address.
                                                               </div>
                                                            </div>
                                                         <?php
                                                      }
                                                   ?>
                                                   <div class="col-12 submit-butt d-flex justify-content-end mt-3">
                                                      <input type="submit" name="update-profile" value="Save">
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                          <div class="col-lg-5 mt-3 mb-3">
                                             <div class="d-flex justify-content-end">
                                                <div class="dropdown">
                                                   <button type="button" data-bs-toggle="dropdown">
                                                      <i class="bi bi-three-dots-vertical"></i>
                                                   </button>
                                                   <ul class="dropdown-menu">
                                                      <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#delete-photo">Delete Photo</a>
                                                   </ul>
                                                </div>
                                             </div>
                                             <form action="process.php" method="POST" enctype="multipart/form-data">
                                                <div class="upload-img row mb-3">
                                                   <label class="mb-2">Profile Image</label>
                                                   <div class="w-100 col-md-8 col-lg-9">
                                                      <div class="edit-img">
                                                         <img src="<?php echo $session_pic ?>">
                                                      </div>
                                                      <div class="pt-3 mb-3 img-uploads">
                                                         <input type="file" name="image" accept="image/*" class="img-file mt-1" required>
                                                         <input type="submit" name="img-submit" value="Upload" class="mt-3">
                                                      </div>
                                                   </div>
                                                </div>
                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="tab-pane fade change-password" id="change-password">
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
                                                <input type="submit" name="change-pass" value="Change Password">
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
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

            <!-- Delete Photo Modal -->
            <div id="delete-photo" class="modal">
               <div class="modal-dialog modal-sm modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body">
                        <h5 class="mb-3">Delete Photo?</h5>
                        <div>
                           <form action="process.php" method="POST" enctype="multipart/form-data">
                              <div class="button d-flex justify-content-end gap-3">
                                 <input type="submit" name="delete-picture" value="Delete">
                                 <input type="button" data-bs-dismiss="modal" value="Cancel">
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
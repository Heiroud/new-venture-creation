<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Circuit Bay | Admin | Log In</title>
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
   <?php
      include "../includes/alerts.php";
   ?>
   <main>
      <div class="container login-admin mt-5">
         <section class="section">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-lg-4 col-12 d-flex flex-column align-items-center justify-content-center">
                     <div class="card mb-3">
                        <div class="card-body">
                           <div class="pb-2">
                              <h5 class="card-title text-center pb-0 fs-4">Admin Login</h5>
                              <p class="text-center small">Circuit Bay</p>
                           </div>
                           <form action="process.php" method="POST" class="row g-3">
                              <div class="col-12 input-box">
                                 <label class="form-label">Email</label>
                                 <div class="input-group">
                                    <input type="email" name="email" class="form-control" required>
                                 </div>
                              </div>
                              <div class="col-12 input-box">
                                 <label class="form-label">Password</label>
                                 <div class="input-group">
                                    <input type="password" name="password" class="form-control" required>
                                 </div>
                              </div>
                              <div class="mb-3 input-box">
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
                              <div class="col-12 submit-butt">
                                 <input class="w-100" name="admin-login" type="submit" value="Log In">
                              </div>
                              <div class="col-12 text-center mt-3">
                                 <a class="link-signup" href="">Forgot Password?</a>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </main><!-- End #main -->
   
   <!---====--- VENDOR JS FILES ---====--->
   <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <!---====--- TEMPLATE MAIN JS FILE ---====--->
   <script src="assets/js/main.js"></script>
</body>
</html>
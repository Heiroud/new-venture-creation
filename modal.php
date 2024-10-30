<!-- Login Modal -->
<div id="log-in" class="modal">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body loginsignupmodal">
            <div class="container">
               <div class="ex position-relative">
                  <button class="position-absolute top-0 end-0" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
               </div>
               <h5 class="text-center mb-3">Login to Your Account</h5>
               <p class="text-center small">Enter your email & password to login</p>
               <div>
                  <form action="customer/process.php" method="POST" class="row g-3">
                     <div class="col-12 input-box">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                           <input type="email" name="email" class="form-control" required>
                        </div>
                     </div>
                     <div class="col-12 input-box">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                           <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                     </div>
                     <div class="mb-3 input-box">
                        <label role="button">
                           <input type="checkbox" class="form-check-input" id="showPass"> Show Password
                        </label>
                     </div>
                     <script>
                        const password = document.getElementById("password");
                        const showPass = document.getElementById("showPass");
                        showPass.addEventListener("change", function() {
                           const type = showPass.checked ? "text" : "password";
                           password.type = type;
                        });
                     </script>
                     <div class="col-12 submit-butt">
                        <input class="w-100" name="log-in" type="submit" value="Log In">
                     </div>
                     <div class="col-12 text-center mt-3">
                        <a class="link-signup" href="" data-bs-toggle="modal" data-bs-target="#sign-up">Don't have account?</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Signup Modal -->
<div id="sign-up" class="modal">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-body loginsignupmodal">
            <div class="container">
               <div class="ex position-relative">
                  <button class="position-absolute top-0 end-0" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
               </div>
               <h5 class="text-center mb-3">Create an Account</h5>
               <p class="text-center small">Enter your personal details to create account</p>
               <div>
                  <form action="customer/process.php" method="POST" class="row g-3">
                     <div class="col-12 input-box">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                     </div>
                     <div class="col-lg-6 input-box">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                     </div>
                     <div class="col-lg-6 input-box">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                     </div>
                     <div class="col-lg-6 input-box">
                        <label class="form-label">Password</label>
                        <input type="password" name="password1" class="form-control" required>
                     </div>
                     <div class="col-lg-6 input-box">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password2" class="form-control" required>
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
                     <div class="col-12 submit-butt mt-3">
                        <input class="w-100" name="sign-up" type="submit" value="Create Account">
                     </div>
                     <div class="col-12 text-center mt-3">
                        <a class="link-signup" href="" data-bs-toggle="modal" data-bs-target="#log-in">Already have an account?</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
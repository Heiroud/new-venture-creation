<header class="header fixed-top d-flex align-items-center">
   <div class="d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center">
         <img src="../assets/img/logo2.png">
         <span class="d-none d-lg-block">Circuit Bay</span>
      </a>
      <i class='bi bi-list toggle-sidebar-btn'></i>
   </div>
   <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
         <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
               <span class="dropdown-toggle">Admin</span>
            </a><!-- End Profile Iamge Icon -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
               <li>
                  <a class="dropdown-item d-flex align-items-center" href="account.php">
                     <i class="bi bi-person"></i>
                     <span>Account</span>
                  </a>
               </li>
               <li><hr class="dropdown-divider"></li>
               <li>
                  <form action="process.php" method="POST">
                     <input class="dropdown-item" name="log-out" type="submit" value="Log Out">
                  </form>
               </li>
            </ul><!-- End Profile Dropdown Items -->
         </li><!-- End Profile Nav -->
      </ul>
   </nav>
</header>
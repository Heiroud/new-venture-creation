<?php
   $current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="fixed-top">
   <div class="container">
      <nav class="navbar navbar-expand-lg">
         <div class="logo">
            <a class="navbar-brand" href="home.php"><img src="../assets/img/logo2.png" width="85px"></a>
         </div>
         <div>
            <?php
               if($current_page == 'home.php' || $current_page == 'product-view.php'){
                  ?>
                     <button class="navbar-toggler search-but" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                        <i class="bi bi-search"></i>
                     </button>
                  <?php
               }
            ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
               <i class="bi bi-list"></i>
            </button>
         </div>
         <div class="collapse navbar-collapse search-bar" id="searchCollapse">
            <?php
               if($current_page == 'home.php' || $current_page == 'product-view.php'){
                  ?>
                     <form action="" method="GET" class="d-flex me-auto align-items-center">
                        <input type="text" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" placeholder="Search" class="form-control" required>
                        <button type="submit"><i class="bi bi-search"></i></button>
                        <div class="results-holder p-2" style="display: <?php echo isset($_GET['search']) ? 'block' : 'none'; ?>">
                           <?php
                              if(isset($_GET['search'])){
                                 $filter_search = $_GET['search'];
                                 $search = mysqli_query($conn, "SELECT * FROM `products` WHERE CONCAT(name, description) LIKE '%$filter_search%'");
                                 if(mysqli_num_rows($search) > 0){
                                    while($row = mysqli_fetch_assoc($search)){
                                       $prod_id = $row['prod_id'];
                                       $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                                       if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                          $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                                       }else{
                                          $prod_pic = "../assets/img/img.jpg";
                                       }
                                       ?><a href="product-view.php?prod_id=<?php echo $prod_id ?>"><div class="results-item"><div class="img-hold"><img src="<?php echo $prod_pic ?>"></div> <?php echo $row['name'] ?>, ₱<?php echo number_format($row['price'], 0, '.', ','); ?></div></a><?php
                                    }
                                 }else{
                                    ?><a href="home.php"><div class="results-item">No Search Results</div></a><?php
                                 }
                              }
                           ?>
                        </div>
                     </form>
                  <?php
               }
            ?>
         </div>
         <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link <?php echo ($current_page == 'home.php') ? '' : 'active'; ?>" href="home.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link <?php echo ($current_page == 'orders.php') ? '' : 'active'; ?>" href="orders.php">Orders</a>
               </li>
               <?php
                  $message = mysqli_query($conn, "SELECT COUNT(*) AS num_mess FROM `message` WHERE `cust_id` = '$session_id' AND `read` = TRUE AND `cust_delete` = TRUE");
                  if($row = mysqli_fetch_assoc($message)){
                     $num_mess = $row['num_mess'];
                  }else{
                     $num_mess = 0;
                  }
                  ?>
                     <li class="nav-item">
                        <a href="inbox.php" class="nav-link inbox-nav"><i class="bi bi-bell-fill"></i>Inbox
                           <span class="badge ms-1 rounded-pill"><?php echo $num_mess ?></span>
                        </a>
                     </li>
                  <?php
               ?>
               <li class="nav-item">
                  <a class="nav-link <?php echo ($current_page == 'profile.php') ? '' : 'active'; ?>" href="profile.php">Profile</a>
               </li>
               <li class="dropdown">
                  <a class="nav-profile d-flex align-items-center pe-0" role="button" data-bs-toggle="dropdown">
                     <div class="nav-img">
                        <img src="<?php echo $session_pic ?>" class="dropdown-toggle">
                     </div>
                  </a>     
                  <ul class="dropdown-menu">
                     <a class="dropdown-item" href="#about">About</a>
                     <a class="dropdown-item" href="#faq">F.A.Q</a>
                     <hr class="dropdown-divider" />
                     <form action="process.php" method="POST">
                        <input class="dropdown-item" name="log-out" type="submit" value="Log Out">
                     </form>
                  </ul>
               </li>
            </ul>
         </div>
      </nav>
   </div>
</header>
<header class="fixed-top">
   <div class="container">
      <nav class="navbar navbar-expand-lg">
         <div class="logo">
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo2.png" width="85px"></a>
         </div>
         <div>
            <button class="navbar-toggler search-but" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
               <i class="bi bi-search"></i>
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
               <i class="bi bi-list"></i>
            </button>
         </div>
         <div class="collapse navbar-collapse search-bar" id="searchCollapse">
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
                                 $prod_pic = "assets/img/prod_img/" . $fetch_pic['product_path'];
                              }else{
                                 $prod_pic = "assets/img/img.jpg";
                              }
                              ?><a href="product-view.php?prod_id=<?php echo $prod_id ?>"><div class="results-item"><div class="img-hold"><img src="<?php echo $prod_pic ?>"></div> <?php echo $row['name'] ?>, ₱<?php echo number_format($row['price'], 0, '.', ','); ?></div></a><?php
                           }
                        }else{
                           ?><a href="index.php"><div class="results-item">No Search Results</div></a><?php
                        }
                     }
                  ?>
               </div>
            </form>
         </div>
         <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link active" href="index.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#about">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#faq">F.A.Q</a>
               </li>
               <li class="nav-item signup">
                  <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#sign-up">Sign Up</a>
               </li>
               <li class="nav-item login">
                  <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#log-in">Log In</a>
               </li>
            </ul>
         </div>
      </nav>
   </div>
</header>
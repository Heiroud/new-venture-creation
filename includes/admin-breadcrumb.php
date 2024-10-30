<?php
   $current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="pagetitle">
   <nav class="navbar navbar-expand-lg">
      <div class="container">
         <!-- Breadcrumbs -->
         <div class="d-flex w-100 align-items-center justify-content-between">
            <ol class="breadcrumb mb-0">
               <li class="breadcrumb-item"><a href="admin.php">Admin</a></li>
               <li class="breadcrumb-item active">
                  <?php
                     if($current_page == 'admin.php'){
                        ?>Dashboard<?php
                     }elseif($current_page == 'account.php'){
                        ?>Account<?php
                     }elseif($current_page == 'customers.php'){
                        ?>Customers<?php
                     }elseif($current_page == 'orders.php'){
                        ?>Orders<?php
                     }elseif($current_page == 'products.php'){
                        ?>Products<?php
                     }elseif($current_page == 'sent.php'){
                        ?>Sent<?php
                     }
                  ?>
               </li>
            </ol>
            <?php
               if($current_page == 'admin.php'){
                  ?>
                     <div class="dropdown new">
                        <a class="dropdown addnew" role="button" data-bs-toggle="dropdown"><i class="bi bi-plus-circle"></i> Add New</a>
                        <ul class="dropdown-menu">
                           <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#add-product">Product</a>
                           <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#add-payment">Payment Method</a>
                        </ul>
                     </div>
                  <?php
               }elseif($current_page == 'customers.php'){
                  ?>
                     <!-- Search Icon on Small Screens -->
                     <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                        <i class="bi bi-search"></i>
                     </button>
                     <!-- Search Bar on Large Screens -->
                     <div class="d-none d-lg-block search-bar">
                        <form class="d-flex ms-auto d-lg-flex">
                           <input type="text" name="search-customers" value="<?php echo isset($_GET['search-customers']) ? $_GET['search-customers'] : ''; ?>" placeholder="Search Customers" class="form-control me-2" required>
                           <button type="submit"><i class="bi bi-search"></i></button>
                        </form>
                     </div>
                  <?php
               }elseif($current_page == 'orders.php'){
                  ?>
                     <!-- Search Icon on Small Screens -->
                     <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                        <i class="bi bi-search"></i>
                     </button>
                     <!-- Search Bar on Large Screens -->
                     <div class="d-none d-lg-block search-bar">
                        <form class="d-flex ms-auto d-lg-flex">
                           <input type="text" name="admin-orders" value="<?php echo isset($_GET['admin-orders']) ? $_GET['admin-orders'] : ''; ?>" placeholder="Search Orders" class="form-control me-2" required>
                           <button type="submit"><i class="bi bi-search"></i></button>
                        </form>
                     </div>
                  <?php
               }elseif($current_page == 'products.php'){
                  ?>
                     <!-- Search Icon on Small Screens -->
                     <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                        <i class="bi bi-search"></i>
                     </button>
                     <!-- Search Bar on Large Screens -->
                     <div class="d-none d-lg-block search-bar">
                        <form method="GET" class="d-flex ms-auto d-lg-flex">
                           <input type="text" name="search-products" value="<?php echo isset($_GET['search-products']) ? $_GET['search-products'] : ''; ?>" placeholder="Search Products" class="form-control me-2" required>
                           <button type="submit"><i class="bi bi-search"></i></button>
                        </form>
                     </div>
                  <?php
               }elseif($current_page == 'sent.php'){
                  ?>
                     <!-- Search Icon on Small Screens -->
                     <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                        <i class="bi bi-search"></i>
                     </button>
                     <!-- Search Bar on Large Screens -->
                     <div class="d-none d-lg-block search-bar">
                        <form class="d-flex ms-auto d-lg-flex">
                           <input type="text" name="search-message" value="<?php echo isset($_GET['search-message']) ? $_GET['search-message'] : ''; ?>" placeholder="Search Message" class="form-control me-2" required>
                           <button type="submit"><i class="bi bi-search"></i></button>
                        </form>
                     </div>
                  <?php
               }
            ?>
         </div>
      </div>
      <?php
         if($current_page == 'customers.php'){
            ?>
               <!-- Search Bar on Small Screens -->
               <div class="collapse d-lg-none w-100 search-bar search-sm" id="searchCollapse">
                  <form class="d-flex align-items-center mt-3">
                     <input type="text" name="search-customers" value="<?php echo isset($_GET['search-customers']) ? $_GET['search-customers'] : ''; ?>" placeholder="Search Customers" class="form-control mb-2" required>
                     <button type="submit"><i class="bi bi-search"></i></button>
                  </form>
               </div>
            <?php
         }elseif($current_page == 'orders.php'){
            ?>
               <!-- Search Bar on Small Screens -->
               <div class="collapse d-lg-none w-100 search-bar search-sm" id="searchCollapse">
                  <form class="d-flex align-items-center mt-3">
                     <input type="text" name="admin-orders" value="<?php echo isset($_GET['admin-orders']) ? $_GET['admin-orders'] : ''; ?>" placeholder="Search Orders" class="form-control me-2" required>
                     <button type="submit"><i class="bi bi-search"></i></button>
                  </form>
               </div>
            <?php
         }elseif($current_page == 'products.php'){
            ?>
               <!-- Search Bar on Small Screens -->
               <div class="collapse d-lg-none w-100 search-bar search-sm" id="searchCollapse">
                  <form method="GET" class="d-flex align-items-center mt-3">
                     <input type="text" name="search-products" value="<?php echo isset($_GET['search-products']) ? $_GET['search-products'] : ''; ?>" placeholder="Search Products" class="form-control mb-2" required>
                     <button type="submit"><i class="bi bi-search"></i></button>
                  </form>
               </div>
            <?php
         }elseif($current_page == 'sent.php'){
            ?>
               <!-- Search Bar on Small Screens -->
               <div class="collapse d-lg-none w-100 search-bar search-sm" id="searchCollapse">
                  <form class="d-flex align-items-center mt-3">
                     <input type="text" name="search-message" value="<?php echo isset($_GET['search-message']) ? $_GET['search-message'] : ''; ?>" placeholder="Search Message" class="form-control mb-2" required>
                     <button type="submit"><i class="bi bi-search"></i></button>
                  </form>
               </div>
            <?php
         }
      ?>
   </nav>
</div>
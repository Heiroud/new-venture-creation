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
            <title>Circuit Bay | Admin | Products</title>
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
               <!-- ======= Products ======= -->
               <section class="products" id="products">
                  <div class="row">
                     <div class="col-12">
                        <div class="card mt-3">
                           <div class="card-header">
                              <h5>Manage Products</h5>
                           </div>
                           <div class="card-body">
                              <div class="card-table">
                                 <table>
                                    <tr>
                                       <th>Product</th>
                                       <th>Price</th>
                                       <th>Stock</th>
                                       <th>Description</th>
                                    </tr>
                                    <?php
                                       //Pagination
                                       if(isset($_GET['page_no']) && $_GET['page_no'] !== ''){
                                          $page_no = $_GET['page_no'];
                                       }else{
                                          $page_no = 1;
                                       }

                                       $total_records_per_page = 10;
                                       $offset = ($page_no - 1) * $total_records_per_page;
                                       $previous_page = $page_no - 1;
                                       $next_page = $page_no + 1;

                                       $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total_records FROM `products`");
                                       $records = mysqli_fetch_assoc($result_count);
                                       $total_records = $records['total_records'];
                                       $total_no_of_pages = ceil($total_records / $total_records_per_page);
                                       //End Pagination

                                       if(!isset($_GET['search-products'])){
                                          $select_prod = mysqli_query($conn, "SELECT * FROM `products` ORDER BY `name` LIMIT $offset, $total_records_per_page");
                                          while($fetch_prod = mysqli_fetch_assoc($select_prod)){
                                             $prod_id = $fetch_prod['prod_id'];
                                             $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
                                             if($fetch_pic = mysqli_fetch_assoc($select_pic)){
                                                $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
                                             }else{
                                                $prod_pic = "../assets/img/img.jpg";
                                             }
                                             ?>
                                                <tr>
                                                   <td>
                                                      <a href="" data-bs-toggle="modal" data-bs-target="#product-details_<?php echo $prod_id ?>">
                                                         <div class="d-flex gap-2 align-items-center">
                                                            <div class="pro-img">
                                                               <img src="<?php echo $prod_pic ?>">
                                                            </div>
                                                            <span><?php echo $fetch_prod['name'] ?></span>
                                                         </div>
                                                      </a>
                                                   </td>
                                                   <td><a href="" data-bs-toggle="modal" data-bs-target="#product-details_<?php echo $prod_id ?>">₱<?php echo number_format($fetch_prod['price'], 0, '.', ','); ?></a></td>
                                                   <td><a href="" data-bs-toggle="modal" data-bs-target="#product-details_<?php echo $prod_id ?>"><?php echo $fetch_prod['stock'] ?></a></td>
                                                   <td><a href="" class="desc" data-bs-toggle="modal" data-bs-target="#product-details_<?php echo $prod_id ?>"><?php echo $fetch_prod['description'] ?></a></td>
                                                </tr>

                                                <!-- Product Details Modal -->
                                                <div id="product-details_<?php echo $prod_id ?>" class="modal">
                                                   <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body product_edit">
                                                            <div class="container">
                                                               <div class="d-flex justify-content-between">
                                                                  <h5 class="mb-3">Edit Product</h5>
                                                                  <div class="dropdown dots">
                                                                     <button type="button" data-bs-toggle="dropdown">
                                                                        <i class="bi bi-three-dots-vertical"></i>
                                                                     </button>
                                                                     <ul class="dropdown-menu">
                                                                        <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#delete-product_<?php echo $prod_id ?>">Delete Product</a>
                                                                     </ul>
                                                                  </div>
                                                               </div>
                                                               <div>
                                                                  <form action="process.php?prod_id=<?php echo $prod_id ?>" method="POST" enctype="multipart/form-data">
                                                                     <div class="row">
                                                                        <div class="col-12 input-box">
                                                                           <label class="form-label">Product Image</label>
                                                                           <div class="input-group">
                                                                              <input type="file" name="pro-img" accept="image/*" required>
                                                                           </div>
                                                                        </div>
                                                                        <div class="col-12 img-upload">
                                                                           <div class="input-group d-flex justify-content-end">
                                                                              <input type="submit" name="up-proimg" value="Upload">
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </form>
                                                                  <form action="process.php?prod_id=<?php echo $prod_id ?>" method="POST">
                                                                     <div class="row">
                                                                        <div class="col-12 input-box">
                                                                           <label class="form-label mt-2">Name</label>
                                                                           <div class="input-group">
                                                                              <input type="text" name="up-pname" value="<?php echo $fetch_prod['name'] ?>" class="form-control">
                                                                           </div>
                                                                        </div>
                                                                        <div class="col-12 input-box">
                                                                           <label class="form-label mt-2">Description</label>
                                                                           <div class="input-group">
                                                                              <textarea name="up-pdesc" rows="2" class="form-control"><?php echo $fetch_prod['description'] ?></textarea>
                                                                           </div>
                                                                        </div>
                                                                        <div class="col-12 input-box">
                                                                           <label class="form-label mt-2">Price</label>
                                                                           <div class="input-group">
                                                                              <input type="text" name="up-pprice" value="<?php echo $fetch_prod['price'] ?>" class="form-control">
                                                                           </div>
                                                                        </div>
                                                                        <div class="col-12 input-box">
                                                                           <label class="form-label mt-2">Stock</label>
                                                                           <div class="input-group">
                                                                              <input type="text" name="up-pstock" value="<?php echo $fetch_prod['stock'] ?>" class="form-control">
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                     <div class="button d-flex justify-content-end gap-3 mt-4">
                                                                        <input type="submit" name="up-product" value="Save">
                                                                        <input type="button" data-bs-dismiss="modal" value="Cancel">
                                                                     </div>
                                                                  </form>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Delete Product Modal -->
                                                <div id="delete-product_<?php echo $prod_id ?>" class="modal">
                                                   <div class="modal-dialog modal-sm modal-dialog-centered">
                                                      <div class="modal-content">
                                                         <div class="modal-body product_edit">
                                                            <h5 class="mb-3">Delete Product?</h5>
                                                            <p>product name</p>
                                                            <div>
                                                               <form action="process.php?prod_id=<?php echo $prod_id ?>" method="POST">
                                                                  <div class="button d-flex justify-content-end gap-3">
                                                                     <input type="submit" name="delete-product" value="Delete">
                                                                     <input type="button" data-bs-toggle="modal" data-bs-target="#product-details" value="Cancel">
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
                                       <li class="page-item buttons"><a class="page-link <?php echo ($page_no <= 1) ? 'disabled' : ''; ?>" <?php echo ($page_no > 1) ? 'href="?page_no=' . $previous_page . '"' : ''; ?>><i class='bx bxs-chevrons-left'></i></a></li>
                                       <?php
                                          $num_links_before_after = 1;
                                          for($i = max(1, $page_no - $num_links_before_after); $i <= min($total_no_of_pages, $page_no + $num_links_before_after); $i++){
                                             if((int)$page_no == $i){
                                                ?><li class="page-item pages"><a class="page-link active"><?php echo $i; ?></a></li><?php
                                             }else{
                                                ?><li class="page-item pages"><a class="page-link" href="?page_no=<?php echo $i; ?>"><?php echo $i; ?></a></li><?php
                                             }
                                          }
                                       ?>
                                       <li class="page-item buttons"><a class="page-link <?php echo ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>" <?php echo ($page_no < $total_no_of_pages) ? 'href="?page_no=' . $next_page . '"' : ''; ?>><i class='bx bxs-chevrons-right'></i></a></li>
                                    </ul>
                                 </nav>
                                 <div class="buts">
                                    <strong>Page <?php echo $page_no; ?> of <?php echo $total_no_of_pages; ?></strong>
                                 </div>
                              </div><!-- ======= End Pagination ======= -->
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
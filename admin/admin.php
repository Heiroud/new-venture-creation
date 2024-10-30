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
            <title>Circuit Bay | Admin</title>
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
               <!-- ======= Dashboard ======= -->
               <section class="dashboard" id="dashboard">
                  <div class="row">
                     <div class="col-lg-4">
                        <div class="row">
                           <?php
                              $orders = mysqli_query($conn, "SELECT COUNT(*) AS num_order FROM `orders`");
                              if($row = mysqli_fetch_assoc($orders)){
                                 $num_order = $row['num_order'];
                              }else{
                                 $num_order = 0;
                              }
                              ?>
                                 <div class="col-12 mt-3">
                                    <a href="orders.php">
                                       <div class="card card-nav">
                                          <div class="card-header">
                                             <h6>Orders</h6>
                                          </div>
                                          <div class="card-body row">
                                             <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart-check-fill"></i>
                                             </div>
                                             <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <h2><?php echo $num_order ?></h2>
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 </div>
                              <?php
                              $products = mysqli_query($conn, "SELECT COUNT(*) AS num_prod FROM `products`");
                              if($row = mysqli_fetch_assoc($products)){
                                 $num_prod = $row['num_prod'];                                
                              }else{
                                 $num_prod = 0;
                              }
                              ?>
                                 <div class="col-12 mt-3">
                                    <a href="products.php">
                                       <div class="card card-nav">
                                          <div class="card-header">
                                             <h6>Products</h6>
                                          </div>
                                          <div class="card-body row">
                                             <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-box2-fill"></i>
                                             </div>
                                             <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <h2><?php echo $num_prod ?></h2>
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 </div>
                              <?php
                              $customers = mysqli_query($conn, "SELECT COUNT(*) AS num_cust FROM `customers`");
                              if($row = mysqli_fetch_assoc($customers)){
                              $num_cust = $row['num_cust'];                           
                              }else{
                              $num_cust = 0;
                              }
                              ?>
                                 <div class="col-12 mt-3">
                                    <a href="customers.php">
                                       <div class="card card-nav">
                                          <div class="card-header">
                                             <h6>Customers</h6>
                                          </div>
                                          <div class="card-body row">
                                             <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person-vcard-fill"></i>
                                             </div>
                                             <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                                <h2><?php echo $num_cust ?></h2>
                                             </div>
                                          </div>
                                       </div>
                                    </a>
                                 </div>
                              <?php
                           ?>
                        </div>
                     </div>
                     <div class="col-lg-8 mt-3">
                        <div class="card">
                           <div class="card-body">
                              <h5 class="card-title">Sales (2024)</h5>
                              <!-- Line Chart -->
                              <canvas id="lineChart" style="max-height: 400px;"></canvas>
                              <script>
                                 document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector('#lineChart'), {
                                    type: 'line',
                                    data: {
                                       labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                       datasets: [{
                                          label: 'Sales',
                                          data: [65, 59, 80, 81, 56, 55, 40, 45, 30],
                                          fill: false,
                                          borderColor: '#0CAC41',
                                          tension: 0.1
                                       }]
                                    },
                                    options: {
                                       scales: {
                                          y: {
                                          beginAtZero: true
                                          }
                                       }
                                    }
                                    });
                                 });
                              </script>
                              <!-- End Line CHart -->
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

            <!-- Add Product Modal -->
            <div id="add-product" class="modal">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body upload_modal">
                        <div class="container">
                           <h5 class="mb-3">Add Product</h5>
                           <div>
                              <form action="process.php" method="POST" enctype="multipart/form-data">
                                 <div class="row">
                                    <div class="col-12 input-box">
                                       <label class="form-label">Product Image</label>
                                       <div class="input-group">
                                          <input type="file" name="prod-img" accept="image/*" required>
                                       </div>
                                    </div>
                                    <div class="col-12 input-box">
                                       <label class="form-label">Name</label>
                                       <div class="input-group">
                                          <input type="text" name="prod-name" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="col-12 input-box">
                                       <label class="form-label">Description</label>
                                       <div class="input-group">
                                          <textarea name="prod-desc" rows="2" class="form-control" required></textarea>
                                       </div>
                                    </div>
                                    <div class="col-12 input-box">
                                       <label class="form-label">Price</label>
                                       <div class="input-group">
                                          <input type="number" name="prod-price" class="form-control" required>
                                       </div>
                                    </div>
                                    <div class="col-12 input-box">
                                       <label class="form-label">Quantity</label>
                                       <div class="input-group">
                                          <input type="number" name="prod-quant" class="form-control" required>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="button d-flex justify-content-end gap-3 mt-4">
                                    <input type="submit" name="add-product" value="Add">
                                    <input type="button" data-bs-dismiss="modal" value="Close">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Add Payment Method -->
            <div id="add-payment" class="modal">
               <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                     <div class="modal-body pm_modals">
                        <div class="container">
                           <h5 class="mb-3">Payment Method</h5>
                           <div>
                              <ul class="nav nav-tabs">
                                 <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#add">Add</button>
                                 </li>
                                 <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit">Edit</button>
                                 </li>
                              </ul>
                              <div class="tab-content">
                                 <div class="tab-pane fade show active add" id="add">
                                    <form action="process.php" method="POST">
                                       <div class="input-box">
                                          <label class="form-label mt-2">Name</label>
                                          <div class="input-group">
                                             <input type="text" name="payment-method" class="form-control" required>
                                          </div>
                                       </div>
                                       <div class="button d-flex justify-content-end gap-3 mt-4">
                                          <input type="submit" name="add-pm" value="Add">
                                          <input type="button" data-bs-dismiss="modal" value="Close">
                                       </div>
                                    </form>
                                 </div>
                                 <div class="tab-pane fade edit" id="edit">
                                    <div class="row">
                                       <?php
                                          $select_pm = mysqli_query($conn, "SELECT * FROM `payment_method` ORDER BY `name`");
                                          while($fetch_pm = mysqli_fetch_assoc($select_pm)){
                                             ?>
                                                <div class="col-12 input-box mb-3">     
                                                   <form action="process.php?pm_id=<?php echo $fetch_pm['pm_id'] ?>" method="POST">
                                                      <div class="row input-group mt-2">
                                                         <div class="col-lg-8">
                                                            <input type="text" name="pm-name" value="<?php echo $fetch_pm['name'] ?>" class="form-control">
                                                         </div>
                                                         <div class="col-lg-4 edit-buttons">
                                                            <input name="edit-pm" type="submit" value="Edit" class="edit-submit">
                                                            <input name="delete-pm" type="submit" value="Delete" class="delete-submit">
                                                         </div>
                                                      </div>
                                                   </form>
                                                </div>
                                             <?php
                                          }
                                       ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
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
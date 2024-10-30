<?php
   //ADMIN SEARCH ORDERS
   if(isset($_GET['admin-orders'])){
      $filter_search = $_GET['admin-orders'];
      $search = mysqli_query($conn, "SELECT * FROM `orders` WHERE CONCAT(product) LIKE '%$filter_search%' AND `admin_done` = TRUE");
      if(mysqli_num_rows($search) > 0){
         while($fetch_orders = mysqli_fetch_assoc($search)){
            $cust_id = $fetch_orders['cust_id'];
            $prod_id = $fetch_orders['prod_id'];
            //product picture
            $select_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
            if($fetch_pic = mysqli_fetch_assoc($select_pic)){
               $prod_pic = "../assets/img/prod_img/" . $fetch_pic['product_path'];
            }else{
               $prod_pic = "../assets/img/img.jpg";
            }
            //customer
            $select_customer = mysqli_query($conn, "SELECT * FROM `customers` WHERE `cust_id` = '$cust_id'");
            $fetch_customer = mysqli_fetch_assoc($select_customer);
            //product
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE `prod_id` = '$prod_id'");
            $fetch_product = mysqli_fetch_assoc($select_product);
            //address
            $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$cust_id'");
            $fetch_address = mysqli_fetch_assoc($select_address);
            ?>
               <tr>
                  <td>
                     <?php
                        if($fetch_orders['status'] == 0){
                           ?><button type="button" data-bs-toggle="modal" data-bs-target="#buyer-details_<?php echo $fetch_orders['order_id'] ?>">Details</button><?php
                        }elseif($fetch_orders['status'] == 1){
                           ?><button class="waiting" type="button" data-bs-toggle="modal" data-bs-target="#waiting-arrival_<?php echo $fetch_orders['order_id'] ?>">Waiting</button><?php
                        }elseif($fetch_orders['status'] == 2){
                           ?>
                              <form action="process.php?order_id=<?php echo $fetch_orders['order_id'] ?>" method="POST">
                                 <input type="submit" name="admin-done" value="Done">
                              </form>
                           <?php
                        }
                     ?>
                  </td>
                  <td>
                     <div class="d-flex gap-2 align-items-center">
                        <div class="pro-img">
                           <img src="<?php echo $prod_pic ?>">
                        </div>
                        <span><?php echo $fetch_orders['product'] ?></span>
                     </div>
                  </td>
                  <td><?php echo $fetch_customer['name'] ?></td>
                  <td>
                     <?php 
                        if($fetch_orders['status'] == 0){
                           ?>Pending<?php
                        }elseif($fetch_orders['status'] == 1){
                           ?>Waiting for Arrival<?php
                        }elseif($fetch_orders['status'] == 2){
                           ?>Product Arrived<?php
                        }
                     ?>
                  </td>
               </tr>
               <!-- Buyer Details Modal -->
               <div id="buyer-details_<?php echo $fetch_orders['order_id'] ?>" class="modal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body admin_orders">
                           <h5 class="mb-3">Buyer Details</h5>
                           <div class="row">
                              <div class="col-12">
                                 <h6>Name:</h6>
                                 <p><?php echo $fetch_customer['name'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Product:</h6>
                                 <p><?php echo $fetch_orders['product'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Description:</h6>
                                 <p><?php echo $fetch_product['description'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Payment:</h6>
                                 <p>₱<?php echo $fetch_orders['payment'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Items:</h6>
                                 <p><?php echo $fetch_orders['items'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Payment Method:</h6>
                                 <p><?php echo $fetch_orders['payment_method'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Complete Address:</h6>
                                 <p><?php echo $fetch_address['address'] ?></p>
                              </div>
                              <form action="process.php?order_id=<?php echo $fetch_orders['order_id'] ?>" method="POST">
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="submit" name="accept-order" value="Accept">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#message-cust_<?php echo $fetch_customer['cust_id'] ?>" value="Message" class="mess_cust">
                                    <input type="button" data-bs-dismiss="modal" value="Close">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Waiting for Arrival Modal -->
               <div id="waiting-arrival_<?php echo $fetch_orders['order_id'] ?>" class="modal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body admin_orders">
                           <h5 class="mb-3">Buyer Details</h5>
                           <p class="status">Waiting...</p>
                           <div class="row">
                              <div class="col-12">
                                 <h6>Name:</h6>
                                 <p><?php echo $fetch_customer['name'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Product:</h6>
                                 <p><?php echo $fetch_orders['product'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Description:</h6>
                                 <p><?php echo $fetch_product['description'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Payment:</h6>
                                 <p>₱<?php echo $fetch_orders['payment'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Items:</h6>
                                 <p><?php echo $fetch_orders['items'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Payment Method:</h6>
                                 <p><?php echo $fetch_orders['payment_method'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Complete Address:</h6>
                                 <p><?php echo $fetch_address['address'] ?></p>
                              </div>
                              <form action="process.php?order_id=<?php echo $fetch_orders['order_id'] ?>" method="POST">
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="submit" name="delete-waiting" value="Delete">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#message-cust_<?php echo $fetch_customer['cust_id'] ?>" value="Message" class="mess_cust">
                                    <input type="button" data-bs-dismiss="modal" value="Close">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Message Customer Modal -->
               <div id="message-cust_<?php echo $fetch_customer['cust_id'] ?>" class="modal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body send_messages">
                           <h5 class="mb-3">Message</h5>
                           <hr>
                           <p>To: <?php echo $fetch_customer['name'] ?></p>
                           <div>
                              <form action="process.php?cust_id=<?php echo $fetch_customer['cust_id'] ?>" method="POST">
                                 <div>
                                    <label class="form-label mt-2">Subject</label>
                                    <input name="subject" class="form-control" required>
                                    <label class="form-label mt-2">Message</label>
                                    <textarea name="message" class="form-control" rows="3" required></textarea>
                                 </div>
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="submit" name="send-message" value="Send">
                                    <input type="button" data-bs-dismiss="modal" value="Close">
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
         ?>
            <p>No Search Results</p>
         <?php
      }
   }

   //ADMIN SEARCH PRODUCTS
   if(isset($_GET['search-products'])){
      $filter_search = $_GET['search-products'];
      $search = mysqli_query($conn, "SELECT * FROM `products` WHERE CONCAT(name, description) LIKE '%$filter_search%'");
      if(mysqli_num_rows($search) > 0){
         while($fetch_prod = mysqli_fetch_assoc($search)){
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
         ?>
            <p>No Search Results</p>
         <?php
      }
   }

   //ADMIN SEARCH MESSAGE
   if(isset($_GET['search-message'])){
      $filter_search = $_GET['search-message'];
      $search = mysqli_query($conn, "SELECT * FROM `message` WHERE CONCAT(subject, message) LIKE '%$filter_search%' AND `admin_delete` = TRUE");
      if(mysqli_num_rows($search) > 0){
         while($fetch_message = mysqli_fetch_assoc($search)){
            $cust_id = $fetch_message['cust_id'];
            $select_customer = mysqli_query($conn, "SELECT * FROM `customers` WHERE `cust_id` = '$cust_id'");
            $fetch_customer = mysqli_fetch_assoc($select_customer);
            ?>
               <tr>
                  <td><a href="" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo $fetch_customer['name'] ?></a></td>
                  <td><a href="" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo $fetch_message['subject'] ?></a></td>
                  <td><a href="" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>"><?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></a></td>
               </tr>
               <!-- Message View Modal -->
               <div id="message-view_<?php echo $fetch_message['mess_id'] ?>" class="modal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body view_message">
                           <h5 class="mb-3">Message view</h5>
                           <div>
                              <hr>
                              <p><strong>Date:</strong> <?php echo date('M d, Y', strtotime($fetch_message['date'])); ?></p>
                              <p><strong>To:</strong> <?php echo $fetch_customer['name'] ?></p>
                              <p>
                                 <?php
                                    if($fetch_message['read'] == 0){
                                       ?><p>Read</p><?php
                                    }elseif($fetch_message['read'] == 1){
                                       ?><p>Unread</p><?php
                                    }
                                 ?>
                              </p>
                              <hr>
                              <p><?php echo $fetch_message['message'] ?></p>
                           </div>
                           <div>
                              <form>
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#delete-message_<?php echo $fetch_message['mess_id'] ?>" value="Delete">
                                    <input type="button" data-bs-dismiss="modal" value="Close">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Delete Message -->
               <div id="delete-message_<?php echo $fetch_message['mess_id'] ?>" class="modal">
                  <div class="modal-dialog modal-sm modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body view_message">
                           <h5 class="mb-3">Delete messsage?</h5>
                           <p><?php echo $fetch_message['subject'] ?></p>
                           <div>
                              <form action="process.php?mess_id=<?php echo $fetch_message['mess_id'] ?>" method="POST">
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="submit" name="delete-message" value="Delete">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#message-view_<?php echo $fetch_message['mess_id'] ?>" value="Cancel">
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
         ?>
            <p>No Search Results</p>
         <?php
      }
   }

   //ADMIN SEARCH CUSTOMER
   if(isset($_GET['search-customers'])){
      $filter_search = $_GET['search-customers'];
      $search = mysqli_query($conn, "SELECT * FROM `customers` WHERE CONCAT(name) LIKE '%$filter_search%'");
      if(mysqli_num_rows($search) > 0){
         while($fetch_cust = mysqli_fetch_assoc($search)){
            $cust_id = $fetch_cust['cust_id'];
            $cust_pic = mysqli_query($conn, "SELECT * FROM `cust_picture` WHERE `cust_id` = '$cust_id'");
            if($fetch_pic = mysqli_fetch_assoc($cust_pic)){
               $picture = "../assets/img/cust_img/" . $fetch_pic['picture_path'];
            }else{
               $picture = "../assets/img/default.jpg";
            }
            ?>
               <tr>
                  <td>
                     <a href="" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>">
                        <div class="d-flex gap-2 align-items-center">
                           <div class="pro-img">
                              <img src="<?php echo $picture ?>">
                           </div>
                           <span><?php echo $fetch_cust['name'] ?></span>
                        </div>
                     </a>
                  </td>
                  <td><a href="" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>"><?php echo $fetch_cust['email'] ?></a></td>
                  <td><a href="" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>"><?php echo $fetch_cust['phone'] ?></a></td>
               </tr>
               <!-- Customer Details Modal -->
               <div id="customer-details_<?php echo $cust_id ?>" class="modal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body cust_details">
                           <h5 class="mb-3">Customer Details</h5>
                           <div class="row">
                              <div class="col-12">
                                 <h6>Name:</h6>
                                 <p><?php echo $fetch_cust['name'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Email:</h6>
                                 <p><?php echo $fetch_cust['email'] ?></p>
                              </div>
                              <div class="col-12">
                                 <h6>Phone:</h6>
                                 <p><?php echo $fetch_cust['phone'] ?></p>
                              </div>
                              <?php
                                 $select_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$cust_id'");
                                 $count_address = mysqli_num_rows($select_address);
                                 if($count_address == 1){
                                    $fetch_address = mysqli_fetch_assoc($sel_address);
                                    ?>
                                       <div class="col-12">
                                          <h6>Address:</h6>
                                          <p><?php echo $fetch_address['address'] ?></p>
                                       </div>
                                    <?php
                                 }else{
                                    ?>
                                       <div class="col-12">
                                          <h6>Address:</h6>
                                          <p>Address not provided.</p>
                                       </div>
                                    <?php
                                 }
                              ?>
                              <form action="">
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#message-cust_<?php echo $cust_id ?>" value="Message" class="mess_cust">
                                    <input class="delete_cust" type="button" data-bs-toggle="modal" data-bs-target="#delete-customer_<?php echo $cust_id ?>" value="Delete">
                                    <input type="button" data-bs-dismiss="modal" value="Close">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Message Customer Modal -->
               <div id="message-cust_<?php echo $cust_id ?>" class="modal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body send_messages">
                           <h5 class="mb-3">Message</h5>
                           <hr>
                           <p>To: <?php echo $fetch_cust['name'] ?></p>
                           <div>
                              <form action="process.php?cust_id=<?php echo $cust_id ?>" method="POST">
                                 <div>
                                    <label class="form-label mt-2">Subject</label>
                                    <input name="subject" class="form-control" required>
                                    <label class="form-label mt-2">Message</label>
                                    <textarea name="message" class="form-control" rows="3" required></textarea>
                                 </div>
                                 <div class="button d-flex justify-content-end gap-3 mt-3">
                                    <input type="submit" name="mess-custpage" value="Send">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>" value="Back">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Delete Customer Modal -->
               <div id="delete-customer_<?php echo $cust_id ?>" class="modal">
                  <div class="modal-dialog modal-sm modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-body cust_details">
                           <h5 class="mb-3">Delete Customer?</h5>
                           <p><?php echo $fetch_cust['name'] ?></p>
                           <div>
                              <form action="">
                                 <div class="button d-flex justify-content-end gap-3">
                                    <input class="delete_cust" type="submit" value="Delete">
                                    <input type="button" data-bs-toggle="modal" data-bs-target="#customer-details_<?php echo $cust_id ?>" value="Cancel">
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
         ?>
            <p>No Search Results</p>
         <?php
      }
   }
?>
<?php
   session_start();
   include "../conn.php";

   //LOG IN AND SIGN UP--------------------------------------------------
   
   //customer sign up
   if(isset($_POST['sign-up'])){
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $password1 = $_POST['password1'];
      $password2 = $_POST['password2'];

      $check_email = mysqli_query($conn, "SELECT * FROM `customers` WHERE `email` = '$email'");
      $count_email = mysqli_num_rows($check_email);
      if($count_email == 0){
         if($password1 == $password2){
            $insert = mysqli_query($conn, "INSERT INTO `customers` VALUES('0','$name','$email','$phone','$password1')");
            if($insert){
               $_SESSION['success_alert'] = "Account created. Please login!";
               header("Location: ../index.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error in Creating";
               header("Location: ../index.php"); exit;
            }
         }else{
            $_SESSION['danger_alert'] = "Passwords did not match";
            header("Location: ../index.php"); exit;
         }
      }else{
         $_SESSION['danger_alert'] = "Email is already used";
         header("Location: ../index.php"); exit;
      }
   }

   //customer log in
   if(isset($_POST['log-in'])){
      $login_email = $_POST['email'];
      $login_pass = $_POST['password'];

      $check_email = mysqli_query($conn, "SELECT * FROM `customers` WHERE `email` = '$login_email'");
      $count_email = mysqli_num_rows($check_email);
      if($count_email == 1){
         $row = mysqli_fetch_assoc($check_email);
         $pass_db = $row['password'];

         if($pass_db == $login_pass){
            $id_db = $row['cust_id'];
            $_SESSION['session_id'] = $id_db;

            $_SESSION['success_alert'] = "Log In Success";
            header("Location: home.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Incorrect Password!";
            header("Location: ../index.php"); exit;
         }
      }else{
         $_SESSION['danger_alert'] = "Email not Found!";
         header("Location: ../index.php"); exit;
      }
   }

   //PRODUCTS, ORDERING, CARTS, CHECKOUT--------------------------------------------------

   //add to cart
   if(isset($_POST['add-cart'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         if(isset($_GET['prod_id'])){
            $prod_id = $_GET['prod_id'];
            $cart_ppicid = $_POST['cart_propic_id'];
            $cart_pname = $_POST['cart_prod_name'];
            $cart_pprice = $_POST['cart_prod_price'];
            $cart_pquantity = $_POST['cart_quantity'];

            $addtocart = mysqli_query($conn, "INSERT INTO `cart` VALUES('0','$session_id','$prod_id','$cart_ppicid','$cart_pname','$cart_pprice','$cart_pquantity',TRUE)");
            if($addtocart){
               $_SESSION['success_alert'] = "Added to cart";
               header("Location: product-view.php?prod_id=$prod_id"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error";
               header("Location: product-view.php"); exit;
            }
         }else{
            $_SESSION['danger_alert'] = "Error, id not provided";
            header("Location: product-view.php"); exit;
         }
      }
   }

   //buy now
   if(isset($_POST['buy-now'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         if(isset($_GET['prod_id'])){
            $prod_id = $_GET['prod_id'];
            $buy_ppicid = $_POST['cart_propic_id'];
            $buy_pname = $_POST['cart_prod_name'];
            $buy_pprice = $_POST['cart_prod_price'];
            $buy_pquantity = $_POST['cart_quantity'];

            $buynow = mysqli_query($conn, "INSERT INTO `cart` VALUES('0','$session_id','$prod_id','$buy_ppicid','$buy_pname','$buy_pprice','$buy_pquantity',FALSE)");
            if($buynow){
               $_SESSION['success_alert'] = "Buy Now";
               header("Location: checkout.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error";
               header("Location: checkout.php"); exit;
            }
         }else{
            $_SESSION['danger_alert'] = "Error, id not provided";
            header("Location: checkout.php"); exit;
         }
      }
   }

   // Edit quantity in cart
   if(isset($_POST['edit-quant'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         if(isset($_GET['cart_id'])){
            $cart_id = $_GET['cart_id'];
            $new_quantity = $_POST['quantity'];

            $update_cart = mysqli_query($conn, "UPDATE `cart` SET `quantity` = '$new_quantity' WHERE `cart_id` = '$cart_id' AND `cust_id` = '$session_id'");
            if($update_cart){
               $_SESSION['success_alert'] = "Quantity updated";
               header("Location: cart.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error updating quantity";
               header("Location: cart.php"); exit;
            }
         }
      }
   }

   //remove product from cart
   if(isset($_POST['remove-cart'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         if(isset($_GET['cart_id'])){
            $cart_id = $_GET['cart_id'];

            $delete_cart = mysqli_query($conn, "DELETE FROM `cart` WHERE `cart_id` = '$cart_id' AND `cust_id` = '$session_id'");
            if($delete_cart){
               $_SESSION['success_alert'] = "Removed";
               header("Location: cart.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error";
               header("Location: cart.php"); exit;
            }
         }
      }
   }

   //check out
   if(isset($_POST['checkOut'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         if(isset($_POST['checked']) && is_array($_POST['checked'])){
            foreach($_POST['checked'] as $cart_id){
               mysqli_query($conn, "UPDATE `cart` SET `checkout` = FALSE WHERE `cart_id` = '$cart_id' AND `cust_id` = '$session_id'");
            }
            
            $_SESSION['success_alert'] = "Checked Out";
            header("Location: checkout.php"); exit;
         } else {
            $_SESSION['danger_alert'] = "Error";
            header("Location: checkout.php"); exit;
         }
      }
   }
  
   //delete selected
   if(isset($_POST['deleteSelected'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         if(isset($_POST['checked']) && is_array($_POST['checked'])){
            foreach($_POST['checked'] as $cart_id){
               mysqli_query($conn, "DELETE FROM `cart` WHERE `cart_id` = '$cart_id' AND `cust_id` = '$session_id'");
            }

            $_SESSION['success_alert'] = "Deleted";
            header("Location: cart.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error";
            header("Location: cart.php"); exit;
         }
      }
   }

   //cancel order
   if(isset($_POST['cancel-order'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         $cancel_order = mysqli_query($conn, "UPDATE `cart` SET `checkout` = TRUE WHERE `cust_id` = '$session_id'");
         if($cancel_order){
            $_SESSION['success_alert'] = "Order cancelled";
            header("Location: cart.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error";
            header("Location: cart.php"); exit;
         }
      }
   }

   //edit address in check out
   if(isset($_POST['edit-address'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];
         $edit_address = $_POST['address'];

         $select_add = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
         $count_add = mysqli_num_rows($select_add);
         if($count_add > 0){
            mysqli_query($conn, "UPDATE `address` SET `address` = '$edit_address' WHERE `cust_id` = '$session_id'");

            $_SESSION['success_alert'] = "Address updated";
            header("Location: checkout.php"); exit;
         }else{
            mysqli_query($conn, "INSERT INTO `address` VALUES('0','$session_id','$edit_address')");

            $_SESSION['success_alert'] = "Address updated";
            header("Location: checkout.php"); exit;
         }
      }
   }

   // Place order
   if(isset($_POST['place-order'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `cust_id` = '$session_id' AND `checkout` = FALSE");
         if(mysqli_num_rows($select_cart) > 0){
            $totalpay = $_POST['totalpay'];
            $items = $_POST['items'];
            $payment = $_POST['payment'];

            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
               $cart_id = $fetch_cart['cart_id'];
               $prod_id = $fetch_cart['prod_id'];
               $propic_id = $fetch_cart['propic_id'];
               $product = $fetch_cart['product'];
               $quantity = $fetch_cart['quantity'];
               $price = $fetch_cart['price'];
               $subtotal = $quantity * $price;

               $insert_order = mysqli_query($conn, "INSERT INTO `orders` VALUES('0', '$session_id', '$prod_id', '$propic_id', '$product', '$subtotal', '$quantity', '$payment', '0', TRUE, TRUE)");

               $select_stock = mysqli_query($conn, "SELECT `stock` FROM `products` WHERE `prod_id` = '$prod_id'");
               $fetch_stock = mysqli_fetch_assoc($select_stock);
               $stock = $fetch_stock['stock'] - $quantity;
               if($insert_order){
                  mysqli_query($conn, "UPDATE `products` SET `stock` = '$stock' WHERE `prod_id` = '$prod_id'");
                  mysqli_query($conn, "DELETE FROM `cart` WHERE `cart_id` = '$cart_id' AND `prod_id` = '$prod_id' AND `cust_id` = '$session_id'");
               }else{
                  $_SESSION['danger_alert'] = "Error placing order for product $product";
                  header("Location: cart.php"); exit;
               }
            }
            $_SESSION['success_alert'] = "Products ordered successfully!";
            header("Location: cart.php"); exit;
         }
      }
   }

   //received product
   if(isset($_POST['received'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];
         if(isset($_GET['order_id'])){
            $order_id = $_GET['order_id'];

            $received = mysqli_query($conn, "UPDATE `orders` SET `status` = '2' WHERE `order_id` = '$order_id' AND `cust_id` = '$session_id'");
            if($received){
               $_SESSION['success_alert'] = "Order Received";
               header("Location: orders.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: orders.php"); exit;
            }
         }
      }
   }

   //customer order done
   if(isset($_POST['cust-done'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];
         if(isset($_GET['order_id'])){
            $order_id = $_GET['order_id'];

            $select_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE `order_id` = '$order_id' AND `cust_id` = '$session_id'");
            $fetch_order = mysqli_fetch_assoc($select_order);

            $admin_done = $fetch_order['admin_done'];
            if($admin_done == TRUE){
               mysqli_query($conn, "UPDATE `orders` SET `cust_done` = FALSE WHERE `order_id` = '$order_id' AND `cust_id` = $session_id");

               $_SESSION['success_alert'] = "Done";
               header("Location: orders.php"); exit;
            }elseif($admin_done == FALSE){
               mysqli_query($conn, "DELETE FROM `orders` WHERE `order_id` = '$order_id' AND `cust_id` = '$session_id'");

               $_SESSION['success_alert'] = "Done";
               header("Location: orders.php"); exit;
            }
         }else{
            $_SESSION['danger_alert'] = "Error!";
            header("Location: orders.php"); exit;
         }
      }
   }

   //customer read a message
   if(isset($_POST['message-read'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];
         if(isset($_GET['mess_id'])){
            $mess_id = $_GET['mess_id'];

            $read = mysqli_query($conn, "UPDATE `message` SET `read` = FALSE WHERE `mess_id` = '$mess_id' AND `cust_id` = '$session_id'");
            if($read){
               header("Location: inbox.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: inbox.php"); exit;
            }
         }
      }
   }

   //customer delete message
   if(isset($_POST['delete-message'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];
         if(isset($_GET['mess_id'])){
            $mess_id = $_GET['mess_id'];

            $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE `mess_id` = $mess_id AND `cust_id` = '$session_id'");
            $fetch_message = mysqli_fetch_assoc($select_message);
            if($fetch_message['admin_delete'] == TRUE){
               mysqli_query($conn, "UPDATE `message` SET `cust_delete` = FALSE WHERE `mess_id` = '$mess_id' AND `cust_id` = '$session_id'");
               mysqli_query($conn, "UPDATE `message` SET `read` = FALSE WHERE `mess_id` = '$mess_id' AND `cust_id` = '$session_id'");

               $_SESSION['success_alert'] = "Message deleted";
               header("Location: inbox.php"); exit;
            }else{
               mysqli_query($conn, "DELETE FROM `message` WHERE `mess_id` = '$mess_id' AND `cust_id` = '$session_id'");

               $_SESSION['success_alert'] = "Message deleted";
               header("Location: inbox.php"); exit;
            }
         }
      }
   }

   //CUSTOMER INFORMATION--------------------------------------------------

   //update profile
   if(isset($_POST['update-profile'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         $up_name = $_POST['up-name'];
         $up_email = $_POST['up-email'];
         $up_phone = $_POST['up-phone'];
         $up_address = $_POST['address'];

         $check_address = mysqli_query($conn, "SELECT * FROM `address` WHERE `cust_id` = '$session_id'");
         $count_address = mysqli_num_rows($check_address);

         mysqli_query($conn, "UPDATE `customers` SET `name` = '$up_name', `email` = '$up_email', `phone` = '$up_phone' WHERE `cust_id` = '$session_id'");
         if($count_address == 1){
            mysqli_query($conn, "UPDATE `address` SET `address` = '$up_address' WHERE `cust_id` = $session_id");
         }else{
            mysqli_query($conn, "INSERT INTO `address` VALUES('0', '$session_id', '$up_address')");
         }
         $_SESSION['success_alert'] = "Changes Saved";
         header("Location: profile.php"); exit;
      }
   }

   //upload profile picture
   if(isset($_POST['img-submit'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         $pic_name = $_FILES['image']['name'];
         $pic_tmpname = $_FILES['image']['tmp_name'];
         $pic_size = $_FILES['image']['size'];
         $pic_dir = '../assets/img/cust_img/'.$pic_name;

         if($pic_size < 10000000){
            $select_prev_pic = mysqli_query($conn, "SELECT `picture_path` FROM `cust_picture` WHERE `cust_id` = '$session_id'");

            if($fetch_prev_pic = mysqli_fetch_assoc($select_prev_pic)){
               $old_pic = '../assets/img/cust_img/'.$fetch_prev_pic['picture_path'];

               if(file_exists($old_pic)){
                  unlink($old_pic);
               }
               mysqli_query($conn, "UPDATE `cust_picture` SET `picture_path` = '$pic_name' WHERE `cust_id` = '$session_id'");
            }else{
               mysqli_query($conn, "INSERT INTO `cust_picture` VALUES ('0', '$session_id', '$pic_name')");
            }

            if(move_uploaded_file($pic_tmpname, $pic_dir)){
               $_SESSION['success_alert'] = "Picture is uploaded";
               header("Location: profile.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: profile.php"); exit;
            }
         }else{
            $_SESSION['primary_alert'] = "Less than 10MB required";
            header("Location: profile.php"); exit;
         }
      }
   }

   //delete profile picture
   if(isset($_POST['delete-picture'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];

         $check_pic = mysqli_query($conn, "SELECT `picture_path` FROM `cust_picture` WHERE `cust_id` = '$session_id'");
         $fetch_pic = mysqli_fetch_assoc($check_pic);
         if($fetch_pic){
            $cur_pic = '../assets/img/cust_img/'.$fetch_pic['picture_path'];

            if(file_exists($cur_pic)){
               unlink($cur_pic);
            }
            $delete_pic = mysqli_query($conn, "DELETE FROM `cust_picture` WHERE `cust_id` = '$session_id'");
            if($delete_pic){
               $_SESSION['success_alert'] = "Photo Deleted";
               header("Location: profile.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error in deleting";
               header("Location: profile.php"); exit;
            }
         }else{
            $_SESSION['primary_alert'] = "No photo to delete";
            header("Location: profile.php"); exit;
         }
      }
   }

   //change password
   if(isset($_POST['change-pass'])){
      if(isset($_SESSION['session_id'])){
         $session_id = $_SESSION['session_id'];
         
         $current_pass = $_POST['current-password'];
         $new_pass = $_POST['new-password'];
         $confirm_pass = $_POST['confirm-password'];
         if($new_pass == $confirm_pass){
            $check_pass = mysqli_query($conn, "SELECT `password` FROM `customers` WHERE `cust_id` = '$session_id'");
            $fetch_pass = mysqli_fetch_assoc($check_pass);

            $db_pass = $fetch_pass['password'];
            if($db_pass == $current_pass){
               $change_pass = mysqli_query($conn, "UPDATE `customers` SET `password` = '$new_pass' WHERE `cust_id` = $session_id");

               if($change_pass){
                  $_SESSION['success_alert'] = "Password Changed";
                  header("Location: profile.php"); exit;
               }else{
                  $_SESSION['danger_alert'] = "Error in changing";
                  header("Location: profile.php"); exit;
               }
            }else{
               $_SESSION['danger_alert'] = "Current password is incorrect";
               header("Location: profile.php"); exit;
            }
         }else{
            $_SESSION['danger_alert'] = "New passwords did not match";
            header("Location: profile.php"); exit;
         }
      }
   }

   //LOG OUT--------------------------------------------------

   //customer log out
   if(isset($_POST['log-out'])){
      if(isset($_SESSION['session_id'])){
         unset($_SESSION['session_id']);
         $_SESSION['success_alert'] = "Log Out Success";
         header("Location: ../index.php"); exit;
      }
   }
?>
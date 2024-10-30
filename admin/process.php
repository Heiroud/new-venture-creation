<?php
   session_start();
   include "../conn.php";

   //LOG IN ADMIN--------------------------------------------------

   //admin log in
   if(isset($_POST['admin-login'])){
      $email = $_POST['email'];
      $password = $_POST['password'];

      $check_email = mysqli_query($conn, "SELECT * FROM `admin` WHERE `email` = '$email'");
      $count_email = mysqli_num_rows($check_email);
      if($count_email == 1){
         $row = mysqli_fetch_assoc($check_email);
         $pass_db = $row['password'];

         if($pass_db == $password){
            $id_db = $row['admin_id'];
            $_SESSION['session_admin'] = $id_db;

            $_SESSION['success_alert'] = "Welcome Admin!";
            header("Location: admin.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Incorrect Password!";
            header("Location: index.php"); exit;
         }
      }else{
         $_SESSION['danger_alert'] = "Email not Found!";
         header("Location: index.php"); exit;
      }
   }

   //admin add product
   if(isset($_POST['add-product'])){
      if(isset($_SESSION['session_admin'])){
         $session_admin = $_SESSION['session_admin'];

         $p_name = $_POST['prod-name'];
         $p_desc = $_POST['prod-desc'];
         $p_price = $_POST['prod-price'];
         $p_quant = $_POST['prod-quant'];

         $pic_name = $_FILES['prod-img']['name'];
         $pic_tmpname = $_FILES['prod-img']['tmp_name'];
         $pic_size = $_FILES['prod-img']['size'];
         $pic_dir = '../assets/img/prod_img/'.$pic_name;

         if($pic_size < 10000000){
            $add_product = mysqli_query($conn, "INSERT INTO `products` VALUES('0','$p_name','$p_desc','$p_price','$p_quant')");

            if($add_product){
               $last_prod_id = mysqli_insert_id($conn);
               mysqli_query($conn, "INSERT INTO `sales` VALUES('0','$last_prod_id','$p_price','$p_price')");
               mysqli_query($conn, "INSERT INTO `prod_picture` VALUES ('0', '$last_prod_id', '$pic_name')");

               if(move_uploaded_file($pic_tmpname, $pic_dir)){
                  $_SESSION['success_alert'] = "Product Added";
                  header("Location: admin.php"); exit;
               }
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: admin.php"); exit;
            }
         }else{
            $_SESSION['primary_alert'] = "Less than 10MB required";
            header("Location: admin.php"); exit;
         }
      }
   }

   //admin update product
   if(isset($_POST['up-product'])){
      if(isset($_GET['prod_id'])){
         $prod_id = $_GET['prod_id'];
         $up_name = $_POST['up-pname'];
         $up_desc = $_POST['up-pdesc'];
         $up_price = $_POST['up-pprice'];
         $up_stock = $_POST['up-pstock'];

         $select_price = mysqli_query($conn, "SELECT `price` FROM `products` WHERE `prod_id` = '$prod_id'");
         if($fetch_price = mysqli_fetch_assoc($select_price)){
            $old_price = $fetch_price['price'];

            $update_sale = mysqli_query($conn, "UPDATE `sales` SET `old_price` = '$old_price', `new_price` = '$up_price' WHERE `prod_id` = '$prod_id'");
            if($update_sale){
               mysqli_query($conn, "UPDATE `products` SET `name` = '$up_name', `description` = '$up_desc', `price` = '$up_price', `stock` = '$up_stock' WHERE `prod_id` = '$prod_id'");

               $_SESSION['success_alert'] = "Changes saved";
               header("Location: products.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: products.php"); exit;
            }
         }
      }
   }

   //admin upload product picture
   if(isset($_POST['up-proimg'])){
      if(isset($_GET['prod_id'])){
         $prod_id = $_GET['prod_id'];

         $pic_name = $_FILES['pro-img']['name'];
         $pic_tmpname = $_FILES['pro-img']['tmp_name'];
         $pic_size = $_FILES['pro-img']['size'];
         $pic_dir = '../assets/img/prod_img/'.$pic_name;
         if($pic_size < 10000000){
            $check_old_pic = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");

            if($fetch_old_pic = mysqli_fetch_assoc($check_old_pic)){
               $old_pic = '../assets/img/prod_img/'.$fetch_old_pic['product_path'];

               if(file_exists($old_pic)){
                  unlink($old_pic);
               }
               mysqli_query($conn, "UPDATE `prod_picture` SET `product_path` = '$pic_name' WHERE `prod_id` = '$prod_id'");
            }else{
               mysqli_query($conn, "INSERT INTO `prod_picture` VALUES ('0', '$prod_id', '$pic_name')");
            }
            if(move_uploaded_file($pic_tmpname, $pic_dir)){
               $_SESSION['success_alert'] = "Picture is uploaded";
               header("Location: products.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: products.php"); exit;
            }
         }else{
            $_SESSION['primary_alert'] = "Less than 10MB required";
            header("Location: products.php"); exit;
         }
      }
   }

   //admin delete product
   if(isset($_POST['delete-product'])){
      if(isset($_GET['prod_id'])){
         $prod_id = $_GET['prod_id'];
         
         $prod_pic_query = mysqli_query($conn, "SELECT * FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
         if($fetch_pic = mysqli_fetch_assoc($prod_pic_query)){
            $old_pic = '../assets/img/prod_img/'.$fetch_pic['product_path'];

            if(file_exists($old_pic)){
               unlink($old_pic);
            }
            mysqli_query($conn, "DELETE FROM `prod_picture` WHERE `prod_id` = '$prod_id'");
         }
         mysqli_query($conn, "DELETE FROM `sales` WHERE `prod_id` = '$prod_id'");

         $delete_product = mysqli_query($conn, "DELETE FROM `products` WHERE `prod_id` = $prod_id");
         if($delete_product){
            $_SESSION['success_alert'] = "Product deleted";
            header("Location: products.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error deleting product!";
            header("Location: products.php"); exit;
         }
      }
   }

   //add payment method
   if(isset($_POST['add-pm'])){
      $payment_method = $_POST['payment-method'];
      $insert_pm = mysqli_query($conn, "INSERT INTO `payment_method` VALUES('0','$payment_method')");
      if($insert_pm){
         $_SESSION['success_alert'] = "Success";
         header("Location: admin.php"); exit;
      }else{
         $_SESSION['danger_alert'] = "Error!";
         header("Location: admin.php"); exit;
      }
   }

   //edit payment method
   if(isset($_POST['edit-pm'])){
      if(isset($_GET['pm_id'])){
         $pm_id = $_GET['pm_id'];
         $pm_name = $_POST['pm-name'];
         $update_pm = mysqli_query($conn, "UPDATE `payment_method` SET `name` = '$pm_name' WHERE `pm_id` = '$pm_id'");
         if($update_pm){
            $_SESSION['success_alert'] = "Edit Success";
            header("Location: admin.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error!";
            header("Location: admin.php"); exit;
         }
      }
   }

   //delete payment method
   if(isset($_POST['delete-pm'])){
      if(isset($_GET['pm_id'])){
         $pm_id = $_GET['pm_id'];
         $delete_pm = mysqli_query($conn, "DELETE FROM `payment_method` WHERE `pm_id` = '$pm_id'");
         if($delete_pm){
            $_SESSION['success_alert'] = "Delete Success";
            header("Location: admin.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error!";
            header("Location: admin.php"); exit;
         }
      }
   }

   //accept order
   if(isset($_POST['accept-order'])){
      if(isset($_GET['order_id'])){
         $order_id = $_GET['order_id'];

         $accept = mysqli_query($conn, "UPDATE `orders` SET `status` = '1' WHERE `order_id` = '$order_id'");
         if($accept){
            $_SESSION['success_alert'] = "Order Accepted";
            header("Location: orders.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error!";
            header("Location: orders.php"); exit;
         }
      }
   }

   //delete waiting order
   if(isset($_POST['delete-waiting'])){
      if(isset($_GET['order_id'])){
         $order_id = $_GET['order_id'];

         $select_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE `order_id` = '$order_id'");
         $fetch_order = mysqli_fetch_assoc($select_order);

         $customer_done = $fetch_order['cust_done'];
         if($customer_done == TRUE){
            mysqli_query($conn, "UPDATE `orders` SET `admin_done` = FALSE WHERE `order_id` = '$order_id'");

            $_SESSION['success_alert'] = "Deleted";
            header("Location: orders.php"); exit;
         }elseif($customer_done == FALSE){
            mysqli_query($conn, "DELETE FROM `orders` WHERE `order_id` = '$order_id'");

            $_SESSION['success_alert'] = "Deleted";
            header("Location: orders.php"); exit;
         }
      }
   }

   //admin order done
   if(isset($_POST['admin-done'])){
      if(isset($_GET['order_id'])){
         $order_id = $_GET['order_id'];

         $select_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE `order_id` = '$order_id'");
         $fetch_order = mysqli_fetch_assoc($select_order);

         $customer_done = $fetch_order['cust_done'];
         if($customer_done == TRUE){
            mysqli_query($conn, "UPDATE `orders` SET `admin_done` = FALSE WHERE `order_id` = '$order_id'");

            $_SESSION['success_alert'] = "Done";
            header("Location: orders.php"); exit;
         }elseif($customer_done == FALSE){
            mysqli_query($conn, "DELETE FROM `orders` WHERE `order_id` = '$order_id'");

            $_SESSION['success_alert'] = "Done";
            header("Location: orders.php"); exit;
         }
      }else{
         $_SESSION['danger_alert'] = "Error!";
         header("Location: orders.php"); exit;
      }
   }

   //admin send a message to customer
   if(isset($_POST['send-message'])){
      if(isset($_SESSION['session_admin'])){
         if(isset($_GET['cust_id'])){
            $cust_id = $_GET['cust_id'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $insert_message = mysqli_query($conn, "INSERT INTO `message` VALUES('0','$cust_id','$subject','$message', NOW(), TRUE, TRUE, TRUE)");
            if($insert_message){
               $_SESSION['success_alert'] = "Message Sent";
               header("Location: orders.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: orders.php"); exit;
            }
         }
      }
   }
   //admin send a message to customer 2
   if(isset($_POST['mess-custpage'])){
      if(isset($_SESSION['session_admin'])){
         if(isset($_GET['cust_id'])){
            $cust_id = $_GET['cust_id'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $insert_message = mysqli_query($conn, "INSERT INTO `message` VALUES('0','$cust_id','$subject','$message', NOW(), TRUE, TRUE, TRUE)");
            if($insert_message){
               $_SESSION['success_alert'] = "Message Sent";
               header("Location: customers.php"); exit;
            }else{
               $_SESSION['danger_alert'] = "Error!";
               header("Location: customers.php"); exit;
            }
         }
      }
   }

   //admin delete message
   if(isset($_POST['delete-message'])){
      if(isset($_SESSION['session_admin'])){
         if(isset($_GET['mess_id'])){
            $mess_id = $_GET['mess_id'];

            $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE `mess_id` = '$mess_id'");
            $fetch_message = mysqli_fetch_assoc($select_message);
            if($fetch_message['cust_delete'] == TRUE){
               mysqli_query($conn, "UPDATE `message` SET `admin_delete` = FALSE WHERE `mess_id` = '$mess_id'");

               $_SESSION['success_alert'] = "Message deleted";
               header("Location: message.php"); exit;
            }elseif($fetch_message['cust_delete'] == FALSE){
               mysqli_query($conn, "DELETE FROM `message` WHERE `mess_id` = '$mess_id'");

               $_SESSION['success_alert'] = "Message deleted";
               header("Location: message.php"); exit;
            }
         }
      }
   }

   //ADMIN INFORMATION--------------------------------------------------

   //admin update account
   if(isset($_POST['up-save'])){
      if(isset($_SESSION['session_admin'])){
         $session_admin = $_SESSION['session_admin'];
         $up_email = $_POST['up-email'];

         $update = mysqli_query($conn, "UPDATE `admin` SET `email` = '$up_email' WHERE `admin_id` = '$session_admin'");
         if($update){
            $_SESSION['success_alert'] = "Changes Saved";
            header("Location: account.php"); exit;
         }else{
            $_SESSION['danger_alert'] = "Error!";
            header("Location: account.php"); exit;
         }
      }
   }

   //admin change password
   if(isset($_POST['changepass'])){
      if(isset($_SESSION['session_admin'])){
         $session_admin = $_SESSION['session_admin'];
         $current_pass = $_POST['current-password'];
         $new_pass = $_POST['new-password'];
         $confirm_pass = $_POST['confirm-password'];
         
         if($new_pass == $confirm_pass){
            $check_pass = mysqli_query($conn, "SELECT `password` FROM `admin` WHERE `admin_id` = '$session_admin'");
            $fetch_pass = mysqli_fetch_assoc($check_pass);

            $db_pass = $fetch_pass['password'];
            if($db_pass == $current_pass){
               $change_pass = mysqli_query($conn, "UPDATE `admin` SET `password` = '$new_pass' WHERE `admin_id` = $session_admin");
               if($change_pass){
                  $_SESSION['success_alert'] = "Password Changed";
                  header("Location: account.php"); exit;
               }else{
                  $_SESSION['danger_alert'] = "Error in changing";
                  header("Location: account.php"); exit;
               }
            }else{
               $_SESSION['danger_alert'] = "Current password is incorrect";
               header("Location: account.php"); exit;
            }
         }else{
            $_SESSION['danger_alert'] = "New passwords did not match";
            header("Location: account.php"); exit;
         }
      }
   }

   //LOG OUT--------------------------------------------------

   if(isset($_POST['log-out'])){
      if(isset($_SESSION['session_admin'])){
         unset($_SESSION['session_admin']);
         $_SESSION['success_alert'] = "Log Out Success";
         header("Location: index.php"); exit;
      }
   }
?>
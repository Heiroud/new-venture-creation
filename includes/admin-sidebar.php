<?php
   $current_page = basename($_SERVER['PHP_SELF']);
?>
<aside id="sidebar" class="sidebar">
   <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
         <a class="nav-link <?php echo ($current_page == 'admin.php') ? '' : 'collapsed'; ?>" href="admin.php">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
         </a>
      </li>
      <li class="nav-heading">Pages</li>
      <li class="nav-item">
         <a class="nav-link <?php echo ($current_page == 'orders.php') ? '' : 'collapsed'; ?>" href="orders.php">
            <i class="bi bi-cart-check"></i>
            <span>Orders</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link <?php echo ($current_page == 'products.php') ? '' : 'collapsed'; ?>" href="products.php">
            <i class="bi bi-box2"></i>
            <span>Products</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link <?php echo ($current_page == 'sent.php') ? '' : 'collapsed'; ?>" href="sent.php">
            <i class="bi bi-send-check"></i>
            <span>Sent</span>
         </a>
      </li>
      <li class="nav-item"></li>
         <a class="nav-link <?php echo ($current_page == 'customers.php') ? '' : 'collapsed'; ?>" href="customers.php">
            <i class="bi bi-person-vcard"></i>
            <span>Customers</span>
         </a>
      </li>
      <li class="nav-item"></li>
         <a class="nav-link <?php echo ($current_page == 'account.php') ? '' : 'collapsed'; ?>" href="account.php">
            <i class="bi bi-person"></i>
            <span>Account</span>
         </a>
      </li>
   </ul>
</aside>
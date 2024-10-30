<!-- ======= Alerts ======= -->
<?php
   if(isset($_SESSION['success_alert'])){
      ?>
         <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" id="success_alert" role="alert">
            <strong><?php echo $_SESSION['success_alert']; ?></strong> 
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
      <?php
      unset($_SESSION['success_alert']);
   }elseif(isset($_SESSION['danger_alert'])){
      ?>
         <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" id="danger_alert" role="alert">
            <strong><?php echo $_SESSION['danger_alert']; ?></strong>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
      <?php
      unset($_SESSION['danger_alert']);
   }elseif(isset($_SESSION['primary_alert'])){
      ?>
         <div class="alert alert-primary alert-dismissible fade show d-flex justify-content-between" id="primary_alert" role="alert">
            <strong><?php echo $_SESSION['primary_alert']; ?></strong>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
      <?php
      unset($_SESSION['primary_alert']);
   }
?>
<script>
   // Set a timeout for alerts
   setTimeout(function() {
      var successAlert = document.getElementById('success_alert');
      var dangerAlert = document.getElementById('danger_alert');
      var primaryAlert = document.getElementById('primary_alert');
      if (successAlert) {
         successAlert.remove();
      }
      if (dangerAlert) {
         dangerAlert.remove();
      }
      if (primaryAlert) {
         primaryAlert.remove();
      }
   }, 3000);
</script>
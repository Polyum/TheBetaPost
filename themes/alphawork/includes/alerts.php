<?php
if (isset($_SESSION['error_alert'])) { ?>
  <div class="alert alert-error"><i class="fa fa-shield"></i> <?= $_SESSION['error_alert']; ?></div>
<?php unset($_SESSION['error_alert']); }
?>

<?php
if (isset($_SESSION['success_alert'])) { ?>
  <div class="alert alert-success"><i class="fa fa-check"></i> <?= $_SESSION['success_alert']; ?></div>
<?php unset($_SESSION['success_alert']); }
?>

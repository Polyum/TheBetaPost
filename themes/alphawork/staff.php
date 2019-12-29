<?php
$page = "staff";
include 'includes/header.php';
?>

<div class="container">
  <div class="box">
    <div class="premiere-box">
      <div class="preview-box">
        <?php
          $staff_list = $bdd->query('SELECT * FROM members WHERE rank > 1');
          $check_for_admin = $bdd->query('SELECT * FROM members WHERE rank = 10');
          $check_for_modo = $bdd->query('SELECT * FROM members WHERE rank = 4');
          $check_for_redac = $bdd->query('SELECT * FROM members WHERE rank = 2');
            if ($check_for_admin->rowCount() > 0) { ?>
              <div class="staff-title">Administration</div>
              <div class="staff-separator">
              <?php while ($staff_admin = $check_for_admin->fetch(PDO::FETCH_OBJ)) { ?>
                  <div class="staff-list">
                    <div class="staff-image" style="background-image:url(./brain/style/img/bank/<?= $staff_admin->image; ?>)"></div>
                    <div class="staff-pseudo"><?= $staff_admin->pseudo; ?></div>
                  </div>
              <?php } ?>
              </div>
          <?php  }

            if ($check_for_modo->rowCount() > 0) { ?>
              <div class="staff-title">Modération</div>
              <div class="staff-separator">
              <?php while ($staff_modo = $check_for_modo->fetch(PDO::FETCH_OBJ)) { ?>
                  <div class="staff-list">
                    <div class="staff-image" style="background-image:url(./brain/style/img/bank/<?= $staff_modo->image; ?>)"></div>
                    <div class="staff-pseudo"><?= $staff_modo->pseudo; ?></div>
                  </div>
              <?php } ?>
              </div>

            <?php }

            if ($check_for_redac->rowCount() > 0) { ?>
              <div class="staff-title">Rédaction</div>
              <div class="staff-separator">
              <?php while ($staff_redac = $check_for_redac->fetch(PDO::FETCH_OBJ)) { ?>
                <div class="staff-list">
                  <div class="staff-image" style="background-image:url(./brain/style/img/bank/<?= $staff_redac->image; ?>)"></div>
                  <div class="staff-pseudo"><?= $staff_redac->pseudo; ?></div>
                </div>
            <?php } ?>
            </div>
              <?php } ?>
    </div>
  </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

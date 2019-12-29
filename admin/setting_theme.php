<?php

include '../brain/core.php';

$page = 12;

if (isset($_GET['choice_theme'])) {
  $theme->selectTheme(iSecu($_GET['choice_theme']));
  alert("success","Thème modifié avec succès");
  header("Location: setting_theme.php");
  exit();
}

if(empty($_SESSION['id'])) {
  header("Location: login.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") < 10) {
  header("Location: ../index.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") > 1) {
 ?>

<?php include 'includes/header.php'; ?>

<main>
  <div class="wrapper wrapper-page">
    <div class="wrapper-title">HabboPaper > Thème du site</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <?php
      $list_themes = $bdd->query('SELECT * FROM themes');
      while ($list_theme = $list_themes->fetch(PDO::FETCH_OBJ)) { ?>
        <div class="card-size">
          <div class="card-size-content">
            <div class="card-size-image" style="background-image:url(../themes/<?= strtolower($list_theme->title) ?>/global/style/img/<?= $list_theme->image ?>)"></div>
            <div class="card-size-body">
              <div class="card-size-title"><?= $list_theme->title ?></div>
              <div class="card-size-button">
                <?php if($list_theme->id != $settings->getSetting("theme")) { ?>
                  <form action="setting_theme.php?choice_theme=<?= $list_theme->id ?>" method="post">
                    <button class="button button-small">Choisir</button>
                  </form>
                 <?php } else { ?>
                   <span style="color:rgba(0,0,0,0.3);"><i class="fa fa-check"></i> Selectionné</span>
                 <?php }?>
              </div>
            </div>
          </div>
        </div>
    <?php  }
     ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

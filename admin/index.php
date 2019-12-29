<?php

include '../brain/core.php';

$page = 1;

if(empty($_SESSION['id'])) {
  header("Location: login.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") < 2) {
  header("Location: ../index.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") > 1) {
 ?>

<?php include 'includes/header.php'; ?>

<main>
  <div class="wrapper wrapper-home">
    <div class="wrapper-title">Bienvenue, <?= $user->getThing("pseudo"); ?></div>
    <div class="wrapper-caption"><?= $settings->getSetting("title"); ?> - <?= $theme->getTheme("title"); ?></div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>

  <div class="content">
    <div class="display">
      <div class="display-content">
        <div class="display-icon blue"><i class="fa fa-user"></i></div>
        <div class="display-other">
          <div class="display-number"><?= $user->count() ?></div>
          <div class="display-text">Utilisateur(s)</div>
        </div>
      </div>
    </div>

    <div class="display">
      <div class="display-content">
        <div class="display-icon red"><i class="fa fa-clipboard"></i></div>
        <div class="display-other">
          <div class="display-number"><?= $article->count() ?></div>
          <div class="display-text">Article(s)</div>
        </div>
      </div>
    </div>

    <div class="display">
      <div class="display-content">
        <div class="display-icon green"><i class="fa fa-comments"></i></div>
        <div class="display-other">
          <div class="display-number"><?= $comment->count() ?></div>
          <div class="display-text">Commentaire(s)</div>
        </div>
      </div>
    </div>

    <div class="display">
      <div class="display-content">
        <div class="display-icon orange"><i class="fa fa-user-times"></i></div>
        <div class="display-other">
          <div class="display-number"><?= $user->countBan() ?></div>
          <div class="display-text">Utilisateur(s) banni(s)</div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

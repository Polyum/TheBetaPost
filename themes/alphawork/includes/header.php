<?php
  require_once 'brain/core.php';

  if (isset($_GET['connect']) and iSecu($_GET['connect'] == "true")) {
    if (!empty($_POST['connect_pseudo'])and  !empty($_POST['connect_password'])) {
      if ($user->checkExist($_POST['connect_pseudo'],$_POST['connect_password']) == true) {
          $_SESSION['id'] = $user->getID($_POST['connect_pseudo'],$_POST['connect_password']);
          alert("success","Bienvenue sur ".$settings->getSetting("title"));
          header("Location: index.php");
          exit();
      } else {
        alert("error","Cet utilisateur n'existe pas, ou est banni");
        header("Location: index.php");
        exit();
      }

    } else {
      alert("error","Veuillez remplir tous les champs");
      header("Location: index.php");
      exit();
    }

  }

  if ($user->getThing("ban") > 0) {
    unset($_SESSION['id']);
    alert("error","Vous êtes banni de ".$settings->getSetting("title"));
    header("Location: index.php");
    exit();
  }
 ?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $settings->getSetting("title") ?> - <?= iDecode($settings->getSetting("slogan")) ?></title>
  <link rel="stylesheet" href="themes/alphawork/global/style/css/global.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body style="background-image:url(themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("background") ?>)">

<?php include 'themes/alphawork/includes/alerts.php'; ?>

<div class="navbar">
  <div class="container">
    <div class="navbar-menu">
      <?php
      $get_list_anchors = $bdd->query('SELECT * FROM anchors ORDER BY item_order');
      while($anchors = $get_list_anchors->fetch(PDO::FETCH_OBJ)) { ?>
        <a href="
              <?= $anchor->getPageByAnchor($anchors->page_id,"anchor"); ?>
        " <?php if ($anchors->new_tab == 1) { ?>
          target="_blank"
        <?php } ?>><?= iDecode($anchor->getPageByAnchor($anchors->page_id,"title")); ?></a>
      <?php } ?>
      <?php if ($user->getThing("rank") > 1): ?>
        <a href="admin/index.php">Administration</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="banner" style="background-image:url(themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("header") ?>)">
  <div class="container">
    <a href="index.php"><img class="banner-logo" src="themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("logo") ?>"></a>
    <?php if (empty($_SESSION['id'])): ?>
      <div class="member-box">
        <form action="?connect=true" method="POST">
          <input type="text" class="field" placeholder="Pseudonyme" name="connect_pseudo">
          <input type="password" class="field" placeholder="Mot de passe" name="connect_password">
          <button class="button button-expanded">Se connecter</button>
          <a href="register.php" style="text-decoration:underline;margin-top:5px;display:block;">Pas encore inscris ?</a>
        </form>
      </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['id'])): ?>
      <div class="member-box">
        <div class="member-image" style="background-image:url(./brain/style/img/bank/<?= $user->getThing("image"); ?>)"></div>
        <div class="member-pseudo"><?= $user->getThing("pseudo"); ?></div>
        <a href="settings.php" class="button button-expanded hZyS">Paramètres</a>
        <a href="logout.php" class="button button-red button-expanded">Déconnexion</a>
      </div>
    <?php endif; ?>
  </div>
</div>

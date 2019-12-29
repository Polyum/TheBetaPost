<?php
  require_once 'brain/core.php';

  if (isset($_GET['connect']) and iSecu($_GET['connect'] == "true")) {
    if (!empty($_POST['connect_pseudo'])and  !empty($_POST['connect_password'])) {
      if ($user->checkExist($_POST['connect_pseudo'],$_POST['connect_password']) == true) {
          $_SESSION['id'] = $user->getID($_POST['connect_pseudo'],$_POST['connect_password']);
          $connected_user_id = $user->getID($_POST['connect_pseudo'],$_POST['connect_password']);
          updateIP($connected_user_id);
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
    alert("error","Vous �tes banni de ".$settings->getSetting("title"));
    header("Location: index.php");
    exit();
  }
 ?>

<!doctype html>
<html lang="fr">
<head>
 <meta name="google-site-verification" content="P2iHkAW3oyu4Fmywwd7iSsTmwHDJQWlVAYshIxJtWnU" />
  <meta charset="utf-8">
  <title><?= $settings->getSetting("title") ?> - <?= iDecode($settings->getSetting("slogan")) ?></title>
  <meta name="description" content="The Beta Post - Ton site fan d'actualité sur HabboBETA !"/>
	<meta name="keywords" content="thebetapost, the beta post, tbp, betapost, beta post, habbobeta, hbeta, hb, habbo-beta, habbo beta, habbobeta, habbo, habbocity, habbo-city, hbc, hcity, habbo city, jabbo, jabbo hotel, jabbonow, jabbohotel, jabborp, habbo-alpha, habbo alpha, habboalpha, habbolove, habbo-love, habbo love, hlove, habbolove inscription, habbo, HABBO, habboo, retro habbo, rétro habbo, serveur habbo, retro, jeux en ligne, jeu comme habbo, jeux comme habbo, site comme habbo, habbo site, serveur privé habbo, habbo beta, hbeta, habbobeta, habbo-beta, habbo-dreams, habbo dreams, habbo dream, habbo-dreams, cola-hotel, cola hotel, bobba, bobbaworld, bobba-world, world, worldhabbo, world-habbo, habbiworld, habbi-world, habbo-world, habbo world, hworld, zunny, abbo, habbi, abboz, habboz, habbo gratuit, habbo credit, habbo hotel, habbo hotel gratuit, jouer a habbo gratuitement, habbo en gratuit, habbo retro, recrutement staff, recrutement, mmorpg, vip, animateur, animation, jeu du celib, clack ou smack, staff, rencontre, celibataire, casino, rares, magots, enable, boutique, fifa, foot, cheval, chevaux, piscine, crédits gratuits, crédit gratuit, staff club, virtuel, monde, réseau social, gratuit, communauté, avatar, chat, connecté, adolescence, jeu de rôle, rejoindre, social, groupes, forums, jouer, jeux, amis, ados, jeunes, collector, créer, connecter, meuble, mobilier, animaux, déco, design, appart, décorer, partager, création, badges, musique, célébrité, chat vip, fun, sortir, mmo, chat, youtube, facebook, twitter, rpg, poudlard, rôle play, role play, jeu, jeux, jeu gratuit, jeu en ligne"/>
	<meta name="Geography" content="France"/>
	<meta name="country" content="France"/>
	<meta name="Language" content="French"/>
	<meta name="identifier-url" content="http://betapost.fr/"/>
	<meta name="category" content="website">
	<meta property="og:site_name" content="The Beta Post"/>
	<meta property="og:url" content="http://betapost.fr/"/>
	<meta property="og:type" content="website"/>
	<meta property="og:locale" content="fr_FR"/>
	<meta name="language" content="fr-FR"/>
  <link rel="stylesheet" href="themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/css/global.css?time=<?= time() ?>">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body style="background-image:url(themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("background") ?>)">

<?php include 'themes/alphawork/includes/alerts.php'; ?>

<div class="banner" style="background-image:url(themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("header") ?>?)">
  <div class="container">
    <a href="index.php"><img class="banner-logo" src="themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("logo") ?>"></a>
    <?php if (empty($_SESSION['id'])): ?>
      <div class="login-box">
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
        <div class="member-avatar" style="position:absolute;height:220px;width:100px;background:url(http://hbeta.net/habbo-imaging/avatarimage.php?user=<?= $user->getThing("pseudo") ?>&amp;action=std&amp;direction=2&amp;head_direction=2&amp;gesture=sml&amp;size=l);z-index:2;"></div>
        <div class="member-pseudo">Salut, <?= $user->getThing("pseudo"); ?></div>
        <a href="settings.php" class="button button-expanded hZyS"><i class="fa fa-cog"></i> Param&egrave;tres</a>
        <a href="logout.php" class="button button-color-o button-expanded"><i class="fa fa-sign-out"></i> D&eacute;connexion</a>
      </div>
    <?php endif; ?>
  </div>
</div>

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
        <a href="admin/index.php"><b><font color="teal">Administration</font></b></a>
      <?php endif; ?>
    </div>
  </div>
</div>

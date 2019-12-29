<!Doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $config['title'] ?> <?= $config['state'] ?> - Administration</title>
  <link rel="stylesheet" href="../brain/style/css/global.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
  <script src="../brain/js/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
	  tinymce.init({
	    selector: 'textarea',
	    theme: 'modern',
	    height: 300,
	    language : "fr_FR",
            spellchecker_language: 'fr_FR',
	    plugins: [
	      'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
	      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
	      'save table contextmenu directionality emoticons template paste textcolor'
	    ],
	    content_css: 'css/content.css',
	    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons| spellchecker'
	  });
  </script>
</head>
<body>

<div class="header">
  <a href="index.php" class="header-title"><i class="fa fa-paper-plane"></i> <?= $config['title'] ?> <span class="header-title-sign"><?= $config['state']; ?></span></a>
  <div class="header-right">
    <div class="header-image" style="background-image:url(../brain/style/img/bank/<?= $user->getThing("image"); ?>);"></div>
    <div class="header-name dropdown_button" data-dropdown="user_dropdown"><?= $user->getThing("pseudo"); ?> <i class="fa fa-caret-down"></i>
      <div id="user_dropdown" class="dropdown-content">
       <a href="../index.php"><i class="fa fa-check"></i> Aller sur <?= $settings->getSetting("title"); ?></a>
       <a class="buttonOpen" data-modal="mysettings_modal"><i class="fa fa-cog"></i> Paramètres</a>
       <a href="../logout.php"><i class="fa fa-sign-out"></i> Déconnexion</a>
     </div>
    </div>
  </div>
</div>

<?php include '../includes/alerts.php'; ?>

<?php include 'includes/modals.php'; ?>

<div class="subnav">
  <div class="subnav-nav">
    <div class="subnav-title">général</div>
    <a href="index.php" <?php if($page == 1) { echo 'class="active"'; } ?>'><i class="fa fa-home"></i> Accueil</a>

    <?php if ($user->getThing("rank") == 10): ?>
      <a href="settings.php" <?php if($page == 2) { echo 'class="active"'; } ?>'><i class="fa fa-cogs"></i> Paramètres</a>
      <a href="setting_theme.php" <?php if($page == 12) { echo 'class="active"'; } ?>'><i class="fa fa-paint-brush"></i> Thèmes</a>
    <?php endif; ?>
    <a href="setting_article.php" <?php if($page == 4) { echo 'class="active"'; } ?>'><i class="fa fa-clipboard"></i> Articles</a>
    <?php if ($user->getThing("rank") >= 4): ?>
      <a href="setting_users.php" <?php if($page == 5) { echo 'class="active"'; } ?>'><i class="fa fa-user"></i> Utilisateurs</a>
    <?php endif; ?>
    <?php if ($user->getThing("rank") == 10): ?>
      <a href=""><i class="fa fa-trello"></i> HabboPaper Plus</a>
      <a href=""><i class="fa fa-upload"></i> Mises à jour</a>
    <?php endif; ?>
  </div>
  <?php if ($user->getThing("rank") == 10): ?>

    <div class="subnav-nav">
      <div class="subnav-title">éléments</div>
      <a href="setting_page.php" <?php if($page == 3) { echo 'class="active"'; } ?>'><i class="fa fa-file"></i> Pages</a>
      <a href="setting_style.php" <?php if($page == 7) { echo 'class="active"'; } ?>'><i class="fa fa-map-signs"></i> Style</a>
      <a href="setting_menu.php" <?php if($page == 9) { echo 'class="active"'; } ?>'><i class="fa fa-list"></i> Menu</a>
      <a href="setting_widgets.php" <?php if($page == 10) { echo 'class="active"'; } ?>'><i class="fa fa-plus-square"></i> Widgets</a>
      <a href=""><i class="fa fa-puzzle-piece"></i> Plugins</a>
    </div>
  <?php endif; ?>
</div>

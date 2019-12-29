<?php

require 'brain/core.php';

// On verifie si l'installation n'est pas complète, si non on redirige l'utilisateur vers index.php
if ($settings->isInstall() == 1) {
  header("Location: index.php");
}

if (isset($_GET['final']) and iSecu($_GET['final']) == "true") {
  if ($installed == 0) {
    if (!empty($_POST['config_title']) and !empty($_POST['config_slogan'])  and !empty($_POST['config_slogan']) and !empty($_POST['config_email']) and !empty($_POST['config_password']) and !empty($_POST['config_password_re'])) {
      $config_title = $_POST['config_title'];
      $config_slogan = $_POST['config_slogan'];
      $config_type = $_POST['config_type'];
      $config_pseudo = $_POST['config_pseudo'];
      $config_email = $_POST['config_email'];
      $config_password = $_POST['config_password'];
      $config_password_re = $_POST['config_password_re'];
      if (preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $config_pseudo)) {
        if ((strlen($config_password) >= 6)) {
          if (($config_password == $config_password_re) and isset($config_password, $config_password_re)) {
            $config_password_final = iHash($config_password);

            $put_settings = $bdd->prepare('INSERT INTO settings(title,slogan,type,installed,theme) VALUES(?,?,?,?,?)');
            $put_settings->execute(array($config_title,$config_slogan,$config_type,1,1));

            $put_admin = $bdd->prepare('INSERT INTO members(pseudo,email,password,rank,club,evolution,profil_bg,added_date,image,ban) VALUES(?,?,?,?,?,?,?,?,?,?)');
            $put_admin->execute(array($config_pseudo,$config_email,$config_password_final,10,0,5,"background_default.png",date('m/d/Y'),"pdp.png",0));

            header("Location: index.php");
            exit();
          } else {
            alert("error", "Les deux mots de passes ne sont pas identiques");
            header("Location: install.php");
            exit();
          }
        } else {
          alert("error", "Votre mot de passe doit faire au moins 6 caractères");
          header("Location: install.php");
          exit();
        }

      } else {
        alert("error", "Votre pseudo ne doit pas contenir de caractères spéciaux");
        header("Location: install.php");
        exit();
      }

    } else {
      alert("error", "Veuillez remplir tous les champs pour complèter la configuration");
      header("Location: install.php");
      exit();
    }

  } else {
    header("Location: index.php");
  }
}

 ?>

<!Doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $config['title'] ?> <?= $config['state'] ?></title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="brain/style/css/global.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>

  <?php include 'includes/alerts.php'; ?>

  <div class="container container-centered">
    <div class="panel panel-config">
      <div class="panel-header">
        <div class="panel-title light">Configuration</div>
      </div>
      <div class="panel-content">
        <form action="install.php?final=true" method="POST">

          <div class="panel-info">Configuration du fansite</div>

          <label for="config_title" class="field-title">Titre du fansite</label>
          <input type="text" class="field-input" name="config_title">

          <label for="config_slogan" class="field-title">Slogan du fansite</label>
          <input type="text" class="field-input" name="config_slogan">

          <label for="config_type" class="field-title">Type de fansite</label>
          <select name="config_type" id="" class="field-input" hidden="">
            <option value="1">Actualité</option>
          </select>

          <div class="panel-info">Configuration du compte administrateur</div>

          <label for="config_pseudo" class="field-title">Pseudonyme</label>
          <input type="text" class="field-input" name="config_pseudo">

          <label for="config_email" class="field-title">Adresse email</label>
          <input type="email" class="field-input" name="config_email">

          <label for="config_password" class="field-title">Mot de passe</label>
          <input type="password" class="field-input" name="config_password">

          <label for="config_password_re" class="field-title">Confirmer le mot de passe</label>
          <input type="password" class="field-input" name="config_password_re">

          <button class="button button-block">Terminer</button>

        </form>

      </div>


      </div>
    </div>
  </div>

  <?php include 'includes/script.php'; ?>

</body>
</html>

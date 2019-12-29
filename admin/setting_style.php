<?php

include '../brain/core.php';

$page = 7;

if (isset($_GET['editheader']) and iSecu($_GET['editheader']) == "true") {
  $image_name = iSecu($_FILES['edit_header']['name']);
  $image_tmp = iSecu($_FILES['edit_header']['tmp_name']);
  $image_size = iSecu($_FILES['edit_header']['size']);
  $dir = "../themes/".strtolower($theme->getTheme("title"))."/global/style/img/";
  $maxsize = 99999999999999999999999999; // Taille en bytes (octets)
  if($_FILES['edit_header']['size'] > $maxsize){
    alert("error", "L'image est trop lourde");
   header("Location: setting_style.php");
   exit();
  } else {
     if(($_FILES['edit_header']['type'] == 'image/gif') || ($_FILES['edit_header']['type'] == 'image/jpeg') || ($_FILES['edit_header']['type'] == 'image/png') || ($_FILES['edit_header']['type'] == 'image/jpg') || ($_FILES['edit_header']['type'] == 'jpg')) {

      if(move_uploaded_file($image_tmp,$dir .$image_name)) {
        $theme->changeHeader($image_name);
        alert("success", "Le header a bien été modifié");
       header("Location: setting_style.php");
       exit();
       } else {
         alert("error", "L'hébergement de l'image a posé un problème");
        header("Location: setting_style.php");
        exit();
       }
     } else {
       alert("error", "Le format de l'image n'est pas compris");
      header("Location: setting_style.php");
      exit();
     }
  }
}

if (isset($_GET['editlogo']) and iSecu($_GET['editlogo']) == "true") {
  $image_name = iSecu($_FILES['edit_logo']['name']);
  $image_tmp = iSecu($_FILES['edit_logo']['tmp_name']);
  $image_size = iSecu($_FILES['edit_logo']['size']);
  $dir = "../themes/".strtolower($theme->getTheme("title"))."/global/style/img/";
  $maxsize = 99999999999999999999999999; // Taille en bytes (octets)
  if($_FILES['edit_logo']['size'] > $maxsize){
    alert("error", "L'image est trop lourde");
   header("Location: setting_style.php");
   exit();
  } else {
     if(($_FILES['edit_logo']['type'] == 'image/gif') || ($_FILES['edit_logo']['type'] == 'image/jpeg') || ($_FILES['edit_logo']['type'] == 'image/png') || ($_FILES['edit_logo']['type'] == 'image/jpg') || ($_FILES['edit_logo']['type'] == 'jpg')) {

      if(move_uploaded_file($image_tmp,$dir .$image_name)) {
        $theme->changeLogo($image_name);
        alert("success", "Le logo a bien été modifié");
       header("Location: setting_style.php");
       exit();
       } else {
         alert("error", "L'hébergement de l'image a posé un problème");
        header("Location: setting_style.php");
        exit();
       }
     } else {
       alert("error", "Le format de l'image n'est pas compris");
      header("Location: setting_style.php");
      exit();
     }
  }
}

if (isset($_GET['editbg']) and iSecu($_GET['editbg']) == "true") {
  $image_name = iSecu($_FILES['edit_bg']['name']);
  $image_tmp = iSecu($_FILES['edit_bg']['tmp_name']);
  $image_size = iSecu($_FILES['edit_bg']['size']);
  $dir = "../themes/".strtolower($theme->getTheme("title"))."/global/style/img/";
  $maxsize = 99999999999999999999999999; // Taille en bytes (octets)
  if($_FILES['edit_bg']['size'] > $maxsize){
    alert("error", "L'image est trop lourde");
   header("Location: setting_style.php");
   exit();
  } else {
     if(($_FILES['edit_bg']['type'] == 'image/gif') || ($_FILES['edit_bg']['type'] == 'image/jpeg') || ($_FILES['edit_bg']['type'] == 'image/png') || ($_FILES['edit_bg']['type'] == 'image/jpg') || ($_FILES['edit_bg']['type'] == 'jpg')) {

      if(move_uploaded_file($image_tmp,$dir .$image_name)) {
        $theme->changeBg($image_name);
        alert("success", "Le fond a bien été modifié");
       header("Location: setting_style.php");
       exit();
       } else {
         alert("error", "L'hébergement de l'image a posé un problème");
        header("Location: setting_style.php");
        exit();
       }
     } else {
       alert("error", "Le format de l'image n'est pas compris");
      header("Location: setting_style.php");
      exit();
     }
  }
}

if(empty($_SESSION['id'])) {
  header("Location: login.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") < 10) {
  header("Location: ../index.php");
}

include 'includes/header.php'; ?>

<main>
  <div class="wrapper wrapper-page">
    <div class="wrapper-title">HabboPaper > Style du site</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <?php
    if ($theme->has("hasHeader") > 0) { ?>
      <div class="display-header buttonOpen" data-modal="modal-editheader" style="background-image:url(../themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("header") ?>)">
        <div class="display-header-caption">
          <i class="fa fa-camera"></i>
          <div class="display-header-title">Changer l'image</div>
        </div>
      </div>
      <?php } else { ?>
        <div class="info"><i class="fa fa-info-circle"></i> &nbsp;&nbsp;Ce thème n'a pas de de module pour l'entête</div>
    <?php }
     ?>
    <?php
    if ($theme->has("hasLogo") > 0) { ?>
      <div class="display-logo buttonOpen" data-modal="modal-editlogo">
        <img class="banner-logo" src="../themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("logo") ?>">
      </div>
      <?php } else { ?>
        <div class="info"><i class="fa fa-info-circle"></i> &nbsp;&nbsp;Ce thème n'a pas de de module pour le logo</div>
    <?php }
     ?>
     <?php
     if ($theme->has("hasHeader") > 0) { ?>
       <div class="display-header buttonOpen" data-modal="modal-editbg" style="background-repeat:repeat;background-image:url(../themes/<?= strtolower($theme->getTheme("title")) ?>/global/style/img/<?= $theme->getTheme("background") ?>)">
         <div class="display-header-caption">
           <i class="fa fa-camera"></i>
           <div class="display-header-title">Changer le fond</div>
         </div>
       </div>
       <?php } else { ?>
         <div class="info"><i class="fa fa-info-circle"></i> &nbsp;&nbsp;Ce thème n'a pas de de module pour le background</div>
     <?php }
      ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

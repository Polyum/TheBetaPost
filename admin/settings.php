<?php

include '../brain/core.php';

$page = 2;

if(isset($_GET['edit_title']) and iSecu($_GET['edit_title']) == "true") {
  if (!empty($_POST['edit_title'])) {
    $settings->newTitle($_POST['edit_title']);
    alert("success","Le titre du fansite à bien été modifier en ".$settings->getSetting("title"));
    header("Location: settings.php");
    exit();
  } else {
    alert("error","Veuiller proposer un titre");
    header("Location: settings.php");
    exit();
  }

}

if(isset($_GET['edit_slogan']) and iSecu($_GET['edit_slogan']) == "true") {
  if (!empty($_POST['edit_slogan'])) {
    $settings->newSlogan($_POST['edit_slogan']);
    alert("success","Le slogan du fansite à bien été modifier");
    header("Location: settings.php");
    exit();
  } else {
    alert("error","Veuiller proposer un slogan");
    header("Location: settings.php");
    exit();
  }

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
    <div class="wrapper-title">HabboPaper > Paramètres du site</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <div class="card">
      <div class="card-content">
        <form action="settings.php?edit_title=true" method="POST">
          <label for="">Modifier le titre du site</label>
          <input type="text" name="edit_title" class="field-input field-two" value="<?= $settings->getSetting("title") ?>">
          <button class="button button-small">Enregistrer</button>
        </form>
      </div>
      <div class="card-divider"></div>
      <div class="card-content">
        <form action="settings.php?edit_slogan=true" method="POST">
          <label for="">Modifier le slogan</label>
          <input type="text" name="edit_slogan" class="field-input field-two" value="<?= iDecode($settings->getSetting("slogan")) ?>">
          <button class="button button-small">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

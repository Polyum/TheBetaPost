<?php

include '../brain/core.php';

$page = 5;

if (isset($_GET['user'])) {
  if (isset($_GET['ban']) == "true" and iSecu($_GET['ban']) == "true") {
    if ($user->getThing("rank") >= 4) {
      $user->ban(iSecu($_GET['user']));
      alert("success","L'utilisateur a bien été banni");
      header("Location: setting_users.php");
      exit();
    } else {
      alert("error","Vous n'avez pas le rang requis");
      header("Location: setting_users.php");
      exit();
    }
  }

  if (isset($_GET['unban']) == "true" and iSecu($_GET['unban']) == "true") {
    if ($user->getThing("rank") >= 4) {
      $user->unban(iSecu($_GET['user']));
      alert("success","L'utilisateur a bien été débanni");
      header("Location: setting_users.php");
      exit();
    } else {
      alert("error","Vous n'avez pas le rang requis");
      header("Location: setting_users.php");
      exit();
    }
  }

  if (isset($_GET['rank']) and iSecu($_GET['rank']) == "true") {
    if ($user->getThing("rank") == 10) {
      $user->rank(iSecu($_GET['user']),$_POST['user_rank']);
      alert("success","L'utilisateur a bien été gradé");
      header("Location: setting_users.php");
      exit();
    } else {
      alert("error","Vous n'avez pas le rang requis");
      header("Location: setting_users.php");
      exit();
    }
  }
}

if(empty($_SESSION['id'])) {
  header("Location: login.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") < 4) {
  header("Location: ../index.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") > 1) {
 ?>

<?php include 'includes/header.php'; ?>

<main>
  <div class="wrapper wrapper-page">
    <div class="wrapper-title">HabboPaper > Utilisateurs</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <a class="button button-error buttonOpen" data-modal="modal-banusers"><i class="fa fa-user-times"></i> &nbsp;Utilisateurs bannis</a>
    <a class="button button-positive buttonOpen" data-modal="modal-rankusers"><i class="fa fa-user-plus"></i> &nbsp;Utilisateurs gradés</a><br><br>

    <form action="?do=search" method="POST">
      <div class="search-area">
        <span class="search-icon"><i class="fa fa-search"></i></span>
        <input type="text" name="search_user" class="field-search">
      </div>
    </form>

    <?php
      if (isset($_GET['do']) and iSecu($_GET['do']) == "search") {
        if (!empty($_POST['search_user'])) {
          $display_users = $bdd->query("SELECT * FROM members WHERE pseudo LIKE '{$_POST['search_user']}%' ");
          while ($display_user = $display_users->fetch(PDO::FETCH_OBJ)) { ?>
            <div class="preview-user buttonOpen" data-modal="modal-settinguser<?= $display_user->id ?>">
              <div class="preview-user-image" style="background-image:url(../brain/style/img/bank/<?= $display_user->image ?>)"></div>
              <div class="preview-user-pseudo"><?= $display_user->pseudo ?></div>
            </div>

            <div id="modal-settinguser<?= $display_user->id ?>" class="modal">
      			<div class="modal-content">
      				<div class="modal-header">
      					<span class="close buttonClose" data-close="modal-settinguser<?= $display_user->id ?>">×</span>
      					<h2><?= $display_user->pseudo ?></h2>
      				</div>
      				<div class="modal-body">

                <div class="display-user-image" style="background-image:url(../brain/style/img/bank/<?= $display_user->image ?>)"></div>

      					<br>
      					 <?php if ($display_user->ban > 0) { ?>
                   <form method="POST" style="display:inline-block" action="setting_users.php?user=<?= $display_user->id ?>&unban=true">
        						<button class="button button-error linkOpen" data-closemodal="" data-openmodal=""><i class="fa fa-user-times"></i> Débannir</button>
        					</form>
      					 <?php } else { ?>
                   <form method="POST" style="display:inline-block" action="setting_users.php?user=<?= $display_user->id ?>&ban=true">
                     <button class="button button-error linkOpen" data-closemodal="" data-openmodal=""><i class="fa fa-user-times"></i> Bannir</button>
        					</form>
                <?php } ?>
                 <button class="button button-positive linkOpen" data-closemodal="modal-settinguser<?= $display_user->id ?>" data-openmodal="modal-rankuser<?= $display_user->id ?>"><i class="fa fa-user-plus"></i> Grader</button>
      					<a class="button pull-right linkOpen" data-closemodal="modal-settinguser<?= $display_user->id ?>" data-openmodal="">Annuler</a>

      				  </div>
      			  </div>

      		  </div>

            <div id="modal-rankuser<?= $display_user->id ?>" class="modal">
      			<div class="modal-content">
      				<div class="modal-header">
      					<span class="close buttonClose" data-close="modal-rankuser<?= $display_user->id ?>">×</span>
      					<h2><?= $display_user->pseudo ?></h2>
      				</div>
      				<div class="modal-body">
                   <?php if ($display_user->ban > 0) { ?>
                     <span style="width:100%;text-align:center;color:rgba(0,0,0,0.5);margin-bottom:10px;">Cet utilisateur est banni</span>
                     <?php } else { ?>

                       <form class="" action="setting_users.php?user=<?= $display_user->id ?>&rank=true" method="POST">
                         <select name="user_rank" id="" class="field-input field-two">
                           <option value="1" <?php if ($display_user->rank == 1) { echo 'selected'; } ?>>Membre</option>
                           <option value="2" <?php if ($display_user->rank == 2) { echo 'selected'; } ?>>Journaliste</option>
                           <option value="4" <?php if ($display_user->rank == 4) { echo 'selected'; } ?>>Modérateur</option>
                           <option value="10" <?php if ($display_user->rank == 10) { echo 'selected'; } ?>>Administrateur</option>
                         </select>
                         <br>
                         <button class="button button-positive linkOpen" data-closemodal="" data-openmodal=""><i class="fa fa-user-plus"></i> Grader</button>
                         <a class="button pull-right linkOpen" data-closemodal="modal-rankuser<?= $display_user->id ?>" data-openmodal="modal-settinguser<?= $display_user->id ?>">Annuler</a>
                       <?php } ?>
                 </form>

      				  </div>
      			  </div>

      		  </div>
          <?php }
        } else {
          exit('Aucun utilisateur trouvé');
        }
      }
     ?>

  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

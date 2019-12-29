<?php

include '../brain/core.php';

$page = 3;

// On ajoute une page
if (isset($_GET['addpage']) and iSecu($_GET['addpage']) == "true") {
  if ($user->getThing("rank") >= 10) {
    if (!empty($_POST['page_title'])) {
      $page_type = $_POST['page_type'];
      if ($page_type == 3) {
        $page_anchor = "staff.php";
      } elseif($page_type == 4) {
        $page_anchor = "goodies.php";
      } elseif ($page_type == 2) {
        $page_last_id = $page_class->getLastID() + 1;
        $page_anchor = "page.php?id=".$page_last_id;
      }
      $page_class->addPage(iSecu($_POST['page_title']), $_POST['page_type'], $_POST['page_content'], $page_anchor);
      alert("success","La page a bien été créée");
      header("Location: setting_page.php");
      exit();
    } else {
      alert("error","Veuillez remplir tous les champs");
      header("Location: setting_page.php");
      exit();
    }
  } else {
    alert("error","Vous n'avez pas le rang requis");
    header("Location: setting_page.php");
    exit();
  }
}

// On édite la page
if (isset($_GET['page']) and iSecu($_GET['edit']) == "true") {
  if ($user->getThing("rank") >= 10) {
    if (!empty($_POST['page_edit_title'])) {
      $page_class->editPage($_GET['page'],iSecu($_POST['page_edit_title']), $_POST['page_edit_type'], $_POST['page_edit_content']);
      alert("success","La page a bien été modifiée");
      header("Location: setting_page.php");
      exit();
    } else {
      alert("error","Veuillez remplir tous les champs");
      header("Location: setting_page.php");
      exit();
    }
  } else {
    alert("error","Vous n'avez pas le rang requis");
    header("Location: setting_page.php");
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
    <div class="wrapper-title">HabboPaper > Pages du site</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <?php
    if ($theme->has("hasPreview") > 0) {
      $list_pages = $bdd->query('SELECT * FROM pages WHERE id != 1 ORDER BY id'); ?>
      <a class="button buttonOpen" data-modal="modal-addpage"><i class="fa fa-plus"></i> &nbsp;Ajouter une page</a><br><br>

      <div class="preview-page" style="cursor:default;"><i class="fa fa-home"></i> Accueil</div>

      <?php
      while ($list_page = $list_pages->fetch(PDO::FETCH_OBJ)) { ?>

      <div class="preview-page buttonOpen" data-modal="modal-editpage<?= $list_page->id ?>"><i class="fa fa-plus" style="color:rgba(0,0,0,0.2)"></i> <?= iDecode($list_page->title) ?></div>

      <!-- Supprimer un article -->

      <div id="modal-deletearticle<?= $list_article->id ?>" class="modal">
			<div class="modal-content">
				<div class="modal-header">
					<span class="close buttonClose" data-close="modal-deletearticle<?= $list_article->id ?>">×</span>
					<h2>Supprimer un article</h2>
				</div>
				<div class="modal-body">

					<div class="smiley smiley-sick"></div>
					<span class="modal-text">Êtes-vous sûr de vouloir supprimer cet article ?</span>

					<br>
					 <form method="POST" style="display:inline-block" action="setting_article.php?article=<?= $list_article->id ?>&delete=true">
						<button class="button linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Oui</button>
					</form>
					<a class="button pull-right linkOpen" data-closemodal="modal-deletearticle<?= $list_article->id ?>" data-openmodal="">Annuler</a>

				  </div>
			  </div>

		  </div>

      <!-- Modifier une pag -->

      <div id="modal-editpage<?= $list_page->id ?>" class="modal modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close buttonClose" data-close="modal-editpage<?= $list_page->id ?>">×</span>
          <h2>Modifier une page</h2>
        </div>
        <div class="modal-body">

          <div class="smiley smiley-sick"></div>

            <form action="setting_page.php?page=<?= $list_page->id ?>&edit=true" method="POST">
              <label for="">Titre de la page</label>
              <input type="text" class="field-input field-two" name="page_edit_title" value="<?= iDecode($list_page->title) ?>">
              <label for="">Catégorie de la page</label>
              <select name="page_edit_type" id="" class="field-input field-two">
                <option value="2" <?php if($list_page->type == 2) { echo 'selected'; } ?>>Personnalisé</option>
                <option value="3" <?php if($list_page->type == 3) { echo 'selected'; } ?>>Page équipe</option>
                <option value="4" <?php if($list_page->type == 4) { echo 'selected'; } ?>>Page goodies</option>
                <!-- Lister les plugins -->
              </select>
              <?php if ($list_page->type == 2): ?>
                <textarea name="page_edit_content" rows="8" cols="40"><?= $list_page->content ?></textarea>
              <?php endif; ?>

              <br>
              <button class="button linkOpen" data-closemodal="" data-openmodal="">Confirmer</button>
              <a class="button button-error pull-right linkOpen" data-closemodal="modal-editpage<?= $list_page->id ?>" data-openmodal="">Annuler</a>
            </form>


        </div>
      </div>

      </div>


      <?php  } ?>

      <?php } else { ?>
        <div class="info"><i class="fa fa-info-circle"></i> &nbsp;&nbsp;Ce thème n'a pas de de module d'article</div>
    <?php }
     ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

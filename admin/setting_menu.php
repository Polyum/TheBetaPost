<?php

include '../brain/core.php';

$page = 9;

if (isset($_GET['link'])) {
  if (isset($_GET['delete']) and $_GET['delete'] == "true") {
    $anchor->deleteLink($_GET['link']);
    alert("success","Le lien a été supprimé avec succès");
    header("Location: setting_menu.php");
    exit();
  }

  if (isset($_GET['edit']) and $_GET['edit'] == "true") {
    if (isset($_POST['link_edit_page'])) {
      $link_edit_page = $_POST['link_edit_page'];
      $link_edit_newtab = $_POST['link_edit_newtab'];
      $anchor->editLink($_GET['link'],$link_edit_page,$link_edit_newtab);
      alert("success","Le lien a été modifié avec succès");
      header("Location: setting_menu.php");
      exit();
    } else {
      alert("error","Veuillez remplir tous les chmaps");
      header("Location: setting_menu.php");
      exit();
    }
  }
}

if (isset($_GET['addlink']) and iSecu($_GET['addlink']) == "true") {
  // On prend le dernier item_order et on ajoute 1 pour le nouveau widget
  $last_item_order = $anchor->getLastItemOrder();
  $put_item_order = $last_item_order + 1;
  if (isset($_POST['link_page'])) {
    $link_page = iSecu($_POST['link_page']);
    $link_newtab = iSecu($_POST['link_newtab']);
      $anchor->addLink($link_page,$put_item_order,$link_newtab);
      alert("success", "Votre widget a bien été ajouté");
      header("Location: setting_menu.php");
      exit();
  } else {
    alert("error", "Une erreur est survenue");
    header("Location: setting_menu.php");
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
    <div class="wrapper-title">HabboPaper > Menu du site</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <div class="sortable" id="sortable_link">
    <?php
    if ($theme->has("hasMenu") > 0) {
      $list_anchors = $bdd->query('SELECT * FROM anchors ORDER BY item_order'); ?>
      <a class="button buttonOpen" data-modal="modal-addlink"><i class="fa fa-plus"></i> &nbsp;Ajouter un lien</a><br><br>
      <?php
      while ($list_anchor = $list_anchors->fetch(PDO::FETCH_OBJ)) { ?>

      <li class="sortable-box" id="<?= $list_anchor->id ?>">
        <span><i class="fa fa-reorder"></i></span>
        <div class="sortable-title">Lien vers la page: <b><?= iDecode($anchor->getPageByAnchor($list_anchor->page_id,"title")) ?></b></div>
        <div class="sortable-options">
          <div class="sortable-delete buttonOpen" data-modal="modal-deletelink<?= $list_anchor->id ?>"><i class="fa fa-times"></i></div>
            <div class="sortable-edit buttonOpen" data-modal="modal-editlink<?= $list_anchor->id ?>"><i class="fa fa-edit"></i></div>
        </div>
      </li>

      <!-- Supprimer un lien -->

      <div id="modal-deletelink<?= $list_anchor->id ?>" class="modal">
			<div class="modal-content">
				<div class="modal-header">
					<span class="close buttonClose" data-close="modal-deletelink<?= $list_anchor->id ?>">×</span>
					<h2>Supprimer un lien</h2>
				</div>
				<div class="modal-body">

					<div class="smiley smiley-sick"></div>
					<span class="modal-text">Êtes-vous sûr de vouloir supprimer ce lien ?</span>

					<br>
					 <form method="POST" style="display:inline-block" action="setting_menu.php?link=<?= $list_anchor->id ?>&delete=true">
						<button class="button linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Oui</button>
					</form>
					<a class="button pull-right linkOpen" data-closemodal="modal-deletelink<?= $list_anchor->id ?>" data-openmodal="">Annuler</a>

				  </div>
			  </div>

		  </div>

      <!-- Modifier un widget -->

      <div id="modal-editlink<?= $list_anchor->id ?>" class="modal modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close buttonClose" data-close="modal-editlink<?= $list_anchor->id ?>">×</span>
          <h2>Modifier un lien</h2>
        </div>
        <div class="modal-body">

          <div class="smiley smiley-sick"></div>

            <form action="setting_menu.php?link=<?= $list_anchor->id ?>&edit=true" method="POST">
              <label for="">Destination du lien</label>
              <select name="link_edit_page" id="" class="field-input field-two">
                <?php
                // On affiche toutes les pages disponibles
                $put_pages_list = $bdd->query('SELECT * FROM pages ORDER BY id');
                while ($pages_list = $put_pages_list->fetch(PDO::FETCH_OBJ)) { ?>
                    <option value="<?= $pages_list->id ?>" <?php if($list_anchor->page_id == $pages_list->id){ echo 'selected'; } ?>><?= iDecode($pages_list->title) ?></option>
                <?php }
                 ?>
              </select>
              <div><input type="radio" name="link_edit_newtab" value="0" <?php if($list_anchor->new_tab == 0){ echo 'checked'; } ?>> Ne pas ouvrir ce lien dans une nouvelle fenêtre</div>
              <div><input type="radio" name="link_edit_newtab" value="1" <?php if($list_anchor->new_tab == 1){ echo 'checked'; } ?>> Ouvrir ce lien dans une nouvelle fenêtre</div>
              <br>
              <button class="button button-positive linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Confirmer</button>
              <a class="button button-error pull-right linkOpen" data-closemodal="modal-editlink<?= $list_anchor->id ?>" data-openmodal="">Annuler</a>
            </form>


        </div>
      </div>

      </div>


      <?php  } ?>

      <?php } else { ?>
        <div class="info"><i class="fa fa-info-circle"></i> &nbsp;&nbsp;Ce thème n'a pas de de module menu</div>
    <?php }
     ?>
     </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

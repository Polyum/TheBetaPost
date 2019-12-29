<?php

include '../brain/core.php';

$page = 10;

if (isset($_GET['widget'])) {
  if (isset($_GET['delete']) and $_GET['delete'] == "true") {
    $widget->deleteWidget($_GET['widget']);
    alert("success","Le widget a été supprimé avec succès");
    header("Location: setting_widgets.php");
    exit();
  }

  if (isset($_GET['edit']) and $_GET['edit'] == "true") {
    if (isset($_POST['widget_edit_title'], $_POST['widget_edit_content'])) {
      $widget_edit_title = $_POST['widget_edit_title'];
      $widget_edit_content = $_POST['widget_edit_content'];
      $widget->editWidget($_GET['widget'],$widget_edit_title,$widget_edit_content);
      alert("success","Le widget a été modifié avec succès");
      header("Location: setting_widgets.php");
      exit();
    } else {
      alert("error","Veuillez remplir tous les chmaps");
      header("Location: setting_widgets.php");
      exit();
    }
  }
}

if (isset($_GET['addwidget']) and iSecu($_GET['addwidget']) == "true") {
  // On prend le dernier item_order et on ajoute 1 pour le nouveau widget
  $last_item_order = $widget->getLastItemOrder();
  $put_item_order = $last_item_order + 1;
  if (isset($_POST['widget_title'], $_POST['widget_type'])) {
    $widget_title = iSecu($_POST['widget_title']);
    $widget_type = $_POST['widget_type'];
    $widget_content = $_POST['widget_content'];
    // On vérifie le type du widget et on ajoute en fonction
    if ($widget_type == 1) {
      if (!empty($widget_content)) {
        $widget->addWidgetPersonnalize($widget_title,$widget_content,$put_item_order);
        alert("success", "Votre widget a bien été ajouté");
        header("Location: setting_widgets.php");
        exit();
      } else {
        alert("error", "Veuillez donner un contenu à votre widget");
        header("Location: setting_widgets.php");
        exit();
      }
    } elseif($widget_type == 2) {
      $widget->addWidgetLastArticles($widget_title,$put_item_order);
      alert("success", "Votre widget a bien été ajouté");
      header("Location: setting_widgets.php");
      exit();
    } elseif($widget_type == 3) {
      $widget->addWidgetLastComments($widget_title,$put_item_order);
      alert("success", "Votre widget a bien été ajouté");
      header("Location: setting_widgets.php");
      exit();
    }
  } else {
    alert("error", "Veuillez donner un titre à votre widget");
    header("Location: setting_widgets.php");
    exit();
  }

}

if(empty($_SESSION['id'])) {
  header("Location: login.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") < 2) {
  header("Location: ../index.php");
} elseif(isset($_SESSION['id']) and $user->getThing("rank") > 1) {
 ?>

<?php include 'includes/header.php'; ?>

<main>
  <div class="wrapper wrapper-page">
    <div class="wrapper-title">HabboPaper > Widgets du site</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <div class="sortable" id="sortable_widget">
    <?php
    if ($theme->has("hasWidget") > 0) {
      $list_widgets = $bdd->query('SELECT * FROM widgets ORDER BY item_order'); ?>
      <a class="button buttonOpen" data-modal="modal-addwidget"><i class="fa fa-plus"></i> &nbsp;Ajouter un widget</a><br><br>
      <?php
      while ($list_widget = $list_widgets->fetch(PDO::FETCH_OBJ)) { ?>

      <li class="sortable-box" id="<?= $list_widget->id ?>">
        <span><i class="fa fa-reorder"></i></span>
        <div class="sortable-title"><?= $list_widget->title ?></div>
        <div class="sortable-options">
          <div class="sortable-delete buttonOpen" data-modal="modal-deletewidget<?= $list_widget->id ?>"><i class="fa fa-times"></i></div>
          <?php
          if ($list_widget->type == 1) { ?>
            <div class="sortable-edit buttonOpen" data-modal="modal-editwidget<?= $list_widget->id ?>"><i class="fa fa-edit"></i></div>
          <?php } ?>
        </div>
      </li>

      <!-- Supprimer un widget -->

      <div id="modal-deletewidget<?= $list_widget->id ?>" class="modal">
			<div class="modal-content">
				<div class="modal-header">
					<span class="close buttonClose" data-close="modal-deletewidget<?= $list_widget->id ?>">×</span>
					<h2>Supprimer un widget</h2>
				</div>
				<div class="modal-body">

					<div class="smiley smiley-sick"></div>
					<span class="modal-text">Êtes-vous sûr de vouloir supprimer ce widget ?</span>

					<br>
					 <form method="POST" style="display:inline-block" action="setting_widgets.php?widget=<?= $list_widget->id ?>&delete=true">
						<button class="button linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Oui</button>
					</form>
					<a class="button pull-right linkOpen" data-closemodal="modal-deletewidget<?= $list_widget->id ?>" data-openmodal="">Annuler</a>

				  </div>
			  </div>

		  </div>

      <!-- Modifier un widget -->

      <div id="modal-editwidget<?= $list_widget->id ?>" class="modal modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close buttonClose" data-close="modal-editwidget<?= $list_widget->id ?>">×</span>
          <h2>Modifier un widget</h2>
        </div>
        <div class="modal-body">

          <div class="smiley smiley-sick"></div>

            <form action="setting_widgets.php?widget=<?= $list_widget->id ?>&edit=true" method="POST">
              <label for="">Titre du widget</label>
              <input type="text" class="field-input field-two" name="widget_edit_title" value="<?= iDecode($list_widget->title) ?>">
              <textarea name="widget_edit_content" rows="8" cols="40">
                <?= $list_widget->content ?>
              </textarea>

              <br>
              <button class="button button-positive linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Confirmer</button>
              <a class="button button-error pull-right linkOpen" data-closemodal="modal-editwidget<?= $list_widget->id ?>" data-openmodal="">Annuler</a>
            </form>


        </div>
      </div>

      </div>


      <?php  } ?>

      <?php } else { ?>
        <div class="info"><i class="fa fa-info-circle"></i> &nbsp;&nbsp;Ce thème n'a pas de de module widget</div>
    <?php }
     ?>
     </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>

<?php } ?>

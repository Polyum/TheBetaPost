<?php

include '../brain/core.php';

$page = 4;

// On ajoute une catégorie
if (isset($_GET['addcategory']) and iSecu($_GET['addcategory']) == "true") {
  if ($user->getThing("rank") >= 10) {
    if (!empty($_POST['category_title'])) {
      $article->addCategory(iSecu($_POST['category_title']));
      alert("success","La catégorie a bien été créée");
      header("Location: setting_article.php");
      exit();
    } else {
      alert("error","Veuillez remplir tous les champs");
      header("Location: setting_article.php");
      exit();
    }
  } else {
    alert("error","Vous n'avez pas le rang requis");
    header("Location: setting_article.php");
    exit();
  }
}

if (isset($_GET['addarticle']) and iSecu($_GET['addarticle']) == "true") {
  if ($user->getThing("rank") > 1) {
    if (!empty($_POST['article_title']) and !empty($_POST['article_category']) and !empty($_POST['article_content'])) {
      $image_name = iSecu($_FILES['article_image']['name']);
      $image_tmp = iSecu($_FILES['article_image']['tmp_name']);
      $image_size = iSecu($_FILES['article_image']['size']);
      $dir = "../brain/style/img/bank/";
      $maxsize = 99999999999999999999999999; // Taille en bytes (octets)
      if($_FILES['article_image']['size'] > $maxsize){
        $_SESSION['message_error'] = "L'image est trop lourde";
          header("Location: index");
          exit();
      } else {
         if(($_FILES['article_image']['type'] == 'image/gif') || ($_FILES['article_image']['type'] == 'image/jpeg') || ($_FILES['article_image']['type'] == 'image/png') || ($_FILES['article_image']['type'] == 'image/jpg')) {

          if(move_uploaded_file($image_tmp,$dir .$image_name)){
            #...
           } else {
             alert("error", "L'hébergement de l'image a posé un problème");
       			header("Location: setting_article.php");
       			exit();
           }
         } else {
           alert("error", "Le format de l'image n'est pas compris");
     			header("Location: setting_article.php");
     			exit();
         }

      }
        $article_title = iSecu($_POST['article_title']);
        $article_category = iSecu($_POST['article_category']);
        $article_content = $_POST['article_content'];
        $article->addArticle($article_title,$article_category,$article_content,$image_name);
        alert("success","L'article a bien été ajouté");
        header("Location: setting_article.php");
        exit();
      } else {
        alert("error","Veuillez remplir tous les champs");
        header("Location: setting_article.php");
        exit();
      }
  } else {
    alert("error","Vous n'avez pas le rang requis");
    header("Location: setting_article.php");
    exit();
  }
}

// On ajoute un article
if (isset($_GET['article'])) {
  if (isset($_GET['edit']) and iSecu($_GET['edit']) == "true") {
    if ($user->getThing("rank") > 1) {
      if (!empty($_POST['article_edit_title']) and !empty($_POST['article_edit_category']) and !empty($_POST['article_edit_content'])) {
          $article_edit_title = iSecu($_POST['article_edit_title']);
          $article_edit_category = iSecu($_POST['article_edit_category']);
          $article_edit_content = $_POST['article_edit_content'];
          $article->editArticle($_GET['article'],$article_edit_title,$article_edit_category,$article_edit_content);
          alert("success","L'article a bien été edité");
          header("Location: setting_article.php");
          exit();
        } else {
          alert("error","Veuillez remplir tous les champs");
          header("Location: setting_article.php");
          exit();
        }
    } else {
      alert("error","Vous n'avez pas le rang requis");
      header("Location: setting_article.php");
      exit();
    }
  }
  if (isset($_GET['delete']) and iSecu($_GET['delete']) == "true") {
    if ($user->getThing("rank") >=  4) {
      $article->deleteArticle($_GET['article']);
      alert("success","L'article a bien été supprimé");
      header("Location: setting_article.php");
      exit();
    } else {
      alert("error","Vous n'avez pas le rang requis");
      header("Location: setting_article.php");
      exit();
    }
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
    <div class="wrapper-title">HabboPaper > Articles</div>
    <div class="wrapper-caption pull-right"><?= $config['title'] ?> est en version <?= $config['state'] ?></div>
  </div>
  <div class="content">
    <?php
    if ($theme->has("hasPreview") > 0) {
      $list_articles = $bdd->query('SELECT * FROM articles ORDER BY id desc'); ?>
      <a class="button buttonOpen" data-modal="modal-addarticle"><i class="fa fa-plus"></i> &nbsp;Ajouter un article</a>
      <?php if ($user->getThing("rank") == 10): ?>
        <a class="button buttonOpen" data-modal="modal-addcategory"><i class="fa fa-plus"></i> &nbsp;Ajouter une catégorie</a>
      <?php endif; ?><br><br>
      <?php
      while ($list_article = $list_articles->fetch(PDO::FETCH_OBJ)) { ?>

        <div class="preview">
          <div class="preview-image" style="background-image:url(../brain/style/img/bank/<?= $list_article->background; ?>)"></div>
          <a class="preview-title buttonOpen" data-modal="modal-editarticle<?= $list_article->id; ?>" style="cursor:pointer;"><?= iDecode($list_article->title); ?></a>
          <div class="preview-meta" style="margin-bottom:4px;">Posté <b><?= $date->transform($list_article->added_date) ?></b> par <b><?= $user->getThingBy("pseudo","id",$list_article->author_id) ?></b> dans <b><?= getCategoryName($list_article->category); ?></b></div>
          <div class="preview-comments"><i class="fa fa-comment"></i> <?= $article->countComments($list_article->id) ?></div>
          <a class="button button-positive buttonOpen button-tiny" data-modal="modal-editarticle<?= $list_article->id; ?>">Modifier</a>
          <?php if ($user->getThing("rank") >= 4): ?>
            <a class="button button-error buttonOpen button-tiny" data-modal="modal-deletearticle<?= $list_article->id; ?>">Supprimer</a>
          <?php endif; ?>
        </div>

      <!-- Supprimer un article -->

      <?php if ($user->getThing("rank") >= 10): ?>
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
      <?php endif; ?>

      <!-- Modifier un article -->

      <div id="modal-editarticle<?= $list_article->id ?>" class="modal modal-large">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close buttonClose" data-close="modal-editarticle<?= $list_article->id ?>">×</span>
          <h2>Modifier un article</h2>
        </div>
        <div class="modal-body">

          <div class="smiley smiley-sick"></div>

            <form action="setting_article.php?article=<?= $list_article->id ?>&edit=true" method="POST">
              <label for="">Titre de l'article</label>
              <input type="text" class="field-input field-two" name="article_edit_title" value="<?= $list_article->title ?>">
              <label for="">Catégorie de l'article</label>
              <select name="article_edit_category" id="" class="field-input field-two">
                <?php
                  $category_list = $bdd->query('SELECT * FROM categories');
                  while ($category = $category_list->fetch(PDO::FETCH_OBJ)) { ?>
                    <option value="<?= $category->id ?>" <?php if($list_article->category == $category->id) { echo 'selected'; } ?>><?= iDecode($category->title) ?></option>
                <?php  }
                 ?>
              </select>
              <textarea name="article_edit_content" rows="8" cols="40">
                <?= $list_article->content ?>
              </textarea>

              <br>
              <button class="button linkOpen" data-closemodal="" data-openmodal="">Confirmer</button>
              <a class="button button-error pull-right linkOpen" data-closemodal="modal-editarticle<?= $list_article->id ?>" data-openmodal="">Annuler</a>
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

<!-- Ajoute un widget -->

<div id="modal-addwidget" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-addwidget">×</span>
    <h2>Ajouter un widget</h2>
  </div>
  <div class="modal-body">

    <div class="smiley smiley-sick"></div>

      <form action="setting_widgets.php?addwidget=true" method="POST">
        <label for="">Titre du widget</label>
        <input type="text" class="field-input field-two" name="widget_title">
        <label for="">Type du widget</label>
        <select name="widget_type" id="" class="field-input field-two">
          <option value="1">Personnalisé</option>
          <option value="2">Derniers articles</option>
          <option value="3">Derniers commentaires</option>
        </select>
        <textarea name="widget_content" rows="8" cols="40"></textarea>

        <br>
        <button class="button linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Confirmer</button>
        <a class="button button-error pull-right linkOpen" data-closemodal="modal-addwidget" data-openmodal="">Annuler</a>
      </form>


  </div>
</div>

</div>

<!-- Ajoute un lien -->

<div id="modal-addlink" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-addlink">×</span>
    <h2>Ajouter un lien</h2>
  </div>
  <div class="modal-body">

    <div class="smiley smiley-sick"></div>

      <form action="setting_menu.php?addlink=true" method="POST">
        <label for="">Destination du lien</label>
        <select name="link_page" id="" class="field-input field-two">
          <?php
          // On affiche toutes les pages disponibles
          $put_pages_list = $bdd->query('SELECT * FROM pages ORDER BY id');
          while ($pages_list = $put_pages_list->fetch(PDO::FETCH_OBJ)) { ?>
              <option value="<?= $pages_list->id ?>"><?= iDecode($pages_list->title) ?></option>
          <?php }
           ?>
        </select>
        <div><input type="radio" name="link_newtab" value="0" checked> Ne pas ouvrir ce lien dans une nouvelle fenêtre</div>
        <div><input type="radio" name="link_newtab" value="1"> Ouvrir ce lien dans une nouvelle fenêtre</div>

        <br>
        <button class="button linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Confirmer</button>
        <a class="button button-error pull-right linkOpen" data-closemodal="modal-addlink" data-openmodal="">Annuler</a>
      </form>


  </div>
</div>

</div>

<!-- Ajoute un widget -->

<div id="modal-addarticle" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-addarticle">×</span>
    <h2>Ajouter un article</h2>
  </div>
  <div class="modal-body">

    <div class="smiley smiley-sick"></div>

      <form action="setting_article.php?addarticle=true" method="POST" enctype="multipart/form-data">
        <label for="">Titre de l'article</label>
        <input type="text" class="field-input field-two" name="article_title">
        <label for="">Catégorie de l'article</label>
        <select name="article_category" id="" class="field-input field-two">
          <?php
            $category_list = $bdd->query('SELECT * FROM categories');
            while ($category = $category_list->fetch(PDO::FETCH_OBJ)) { ?>
              <option value="<?= $category->id ?>"><?= iDecode($category->title) ?></option>
          <?php  }
           ?>
        </select>
        <label for="">Image de l'article</label>
        <input type="file" name="article_image" class="field-input field-two">
        <textarea name="article_content" rows="8" cols="40"></textarea>

        <br>
        <button class="button linkOpen" name="button-delete" data-closemodal="" data-openmodal="">Confirmer</button>
        <a class="button button-error pull-right linkOpen" data-closemodal="modal-addarticle" data-openmodal="">Annuler</a>
      </form>


  </div>
</div>

</div>

<div id="modal-addcategory" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-addcategory">×</span>
    <h2>Ajouter une catégorie</h2>
  </div>
  <div class="modal-body">

    <div class="smiley smiley-sick"></div>

      <form action="setting_article.php?addcategory=true" method="POST" enctype="multipart/form-data">
        <label for="">Titre de la catégorie</label>
        <input type="text" class="field-input field-two" name="category_title">

        <br>
        <button class="button linkOpen" data-closemodal="" data-openmodal="">Confirmer</button>
        <a class="button button-error pull-right linkOpen" data-closemodal="modal-addcategory" data-openmodal="">Annuler</a>
      </form>


  </div>
</div>

</div>

<div id="modal-addpage" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-addpage">×</span>
    <h2>Ajouter une page</h2>
  </div>
  <div class="modal-body">

    <div class="smiley smiley-sick"></div>

      <form action="setting_page.php?addpage=true" method="POST">
        <label for="">Titre de la page</label>
        <input type="text" class="field-input field-two" name="page_title">
        <label for="">Catégorie de la page</label>
        <select name="page_type" id="" class="field-input field-two">
          <option value="2">Personnalisé</option>
          <option value="3">Page équipe</option>
          <!-- <option value="4">Page goodies</option> -->
          <!-- Lister les plugins -->
        </select>
          <textarea name="page_content" rows="8" cols="40"></textarea>

        <br>
        <button class="button linkOpen" data-closemodal="" data-openmodal="">Confirmer</button>
        <a class="button button-error pull-right linkOpen" data-closemodal="modal-addpage" data-openmodal="">Annuler</a>
      </form>


  </div>
</div>

</div>

<div id="modal-banusers" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-banusers">×</span>
    <h2>Utilisateurs bannis</h2>
  </div>
  <div class="modal-body">

    <?php
      $ban_users = $bdd->query('SELECT * FROM members WHERE ban > 0');

      while ($ban_user = $ban_users->fetch(PDO::FETCH_OBJ)) { ?>
        <div class="list-user linkOpen" data-closemodal="modal-banusers" data-openmodal="modal-settinguser<?= $ban_user->id; ?>">
          <?= $ban_user->pseudo; ?>
        </div>
      <?php } ?>

  </div>
</div>

</div>

<div id="modal-rankusers" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-rankusers">×</span>
    <h2>Utilisateurs gradés</h2>
  </div>
  <div class="modal-body">

    <?php
      $rank_users = $bdd->query('SELECT * FROM members WHERE rank > 1');

      while ($rank_user = $rank_users->fetch(PDO::FETCH_OBJ)) { ?>
        <div class="list-user linkOpen" data-closemodal="modal-rankusers" data-openmodal="modal-settinguser<?= $rank_user->id; ?>">
          <?= $rank_user->pseudo; ?> <span class="badge"><?= $user->getRank($rank_user->rank); ?></span>
        </div>
      <?php } ?>

  </div>
</div>

</div>

<div id="modal-editheader" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-editheader">×</span>
    <h2>Modifier le header</h2>
  </div>
  <div class="modal-body">

      <form action="setting_style.php?editheader=true" method="POST" enctype="multipart/form-data">
        <input type="file" name="edit_header" class="field-input field-two"><br/>
        <button class="button">Confirmer</button>
      </form>

  </div>
</div>

</div>

<div id="modal-editlogo" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-editlogo">×</span>
    <h2>Modifier le logo</h2>
  </div>
  <div class="modal-body">

      <form action="setting_style.php?editlogo=true" method="POST" enctype="multipart/form-data">
        <input type="file" name="edit_logo" class="field-input field-two"><br/>
          <button class="button">Confirmer</button>
      </form>

  </div>
</div>

</div>

<div id="modal-editbg" class="modal modal-large">
<div class="modal-content">
  <div class="modal-header">
    <span class="close buttonClose" data-close="modal-editbg">×</span>
    <h2>Modifier le fond</h2>
  </div>
  <div class="modal-body">

      <form action="setting_style.php?editbg=true" method="POST" enctype="multipart/form-data">
        <input type="file" name="edit_bg" class="field-input field-two"><br/>
          <button class="button">Confirmer</button>
      </form>

  </div>
</div>

</div>

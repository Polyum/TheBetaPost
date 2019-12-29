<?php
$page = "index";
include 'includes/header.php';

if (isset($_GET['post_comment']) and iSecu($_GET['post_comment']) == "true") {
  if (!empty($_POST['comment_content'])) {
    $comment->addComment($_POST['comment_content'],$_GET['id']);
    alert("success", "Votre commentaire a bien été ajouté");
    header("Location: article.php?id=".$_GET['id']);
    exit();
  } else {
    alert("error", "Veuillez remplir tous les champs");
    header("Location: article.php?id=".$_GET['id']);
    exit();
  }

}

if (isset($_GET['edit_comment'])) {
  if (isset($_GET['edit']) and iSecu($_GET['edit']) == "true") {
    if (!empty($_POST['comment_edit_content'])) {
      $comment->editComment(iSecu($_POST['comment_edit_content']),iSecu($_GET['edit_comment']));
      alert("success", "Votre commentaire a bien été modifé");
      header("Location: article.php?id=".$_GET['id']);
      exit();
    } else {
      alert("error", "Veuillez remplir tous les champs");
      header("Location: article.php?id=".$_GET['id'].'&edit_comment='.$_GET['edit_comment']);
      exit();
    }

  }
}

if (isset($_GET['delete_comment'])) {
  if (isset($_GET['delete']) and iSecu($_GET['delete']) == "true") {
    $check_comment_action = $bdd->query('SELECT * FROM comments WHERE id = '.$_GET['delete_comment']);
    $check_comment = $check_comment_action->fetch(PDO::FETCH_OBJ);
    if ($check_comment->author_id != $user->getThing("id") and $user->getThing("rank") < 4) {
      alert("error", "Vous ne pouvez pas effectuer cette action");
      header("Location: article.php?id=".$_GET['id']);
      exit();
    } else {
      $comment->deleteComment($_GET['delete_comment']);
      alert("success", "Votre commentaire a bien été supprimé");
      header("Location: article.php?id=".$_GET['id']);
      exit();
    }

  }
}

if ($article->checkExist($_GET['id']) == false) {
  alert("error", "Cet article n'existe pas");
  header("Location: index.php");
  exit();
}
?>

<div class="container">
  <div class="box">
    <div class="premiere-box">
      <div class="preview-box">
        <?php if (!isset($_GET['edit_comment'])): ?>
          <?php

            $put_view_articles = $bdd->query('SELECT * FROM articles WHERE id = '.$_GET['id']);
            while ($article_view = $put_view_articles->fetch(PDO::FETCH_OBJ)) {
              $article_view_date = strtotime($article_view->added_date);
              ?>

              <div class="view-article">
                <div class="view-article-image" style="background-image:url(./brain/style/img/bank/<?= $article_view->background; ?>)">
                  <div class="view-article-caption"><?= $article_view->title; ?></div>
                </div>
                <div class="view-article-meta">Posté par <b><?= $user->getThingBy("pseudo","id",$article_view->author_id)?></b> le <b><?= date('d/m/Y', $article_view_date) ?></b> dans <b><?= getCategoryName($article_view->category); ?></b></div>
                <div class="view-article-content"><?= $article_view->content; ?></div>
              </div>

            <?php } ?>
        </div>

      <?php
        if (isset($_SESSION['id'])) { ?>
          <div class="post-comment">
            <form action="?id=<?= $_GET['id'] ?>&post_comment=true" method="POST">
              <label for="">Poster un commentaire</label>
              <textarea type="text" name="comment_content" style="margin-bottom:8px;"></textarea>
              <button class="button button-normal button-expanded">Envoyer</button>
            </form>
          </div>
        <?php }
       ?>

       <div class="view-comments">
      <?php

      $repliesParPage = 6;
  		$repliesTotalesReq = $bdd->query('SELECT id FROM comments WHERE article_id = '.$_GET['id']);
  		$repliesTotales = $repliesTotalesReq->rowCount();
  		$pagesTotales = ceil($repliesTotales/$repliesParPage);
  		if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
  		   $_GET['page'] = intval($_GET['page']);
  		   $pageCourante = $_GET['page'];
  		} else {
  		   $pageCourante = 1;
  		}
  		$depart = ($pageCourante-1)*$repliesParPage;

      $put_comments = $bdd->query('SELECT * FROM comments WHERE article_id = '.$_GET['id'].' ORDER BY id LIMIT '.$depart.','.$repliesParPage);
      while ($comments = $put_comments->fetch(PDO::FETCH_OBJ)) {?>
          <div class="view-comment">
            <div class="view-comment-image" style="background-image:url(./brain/style/img/bank/<?= $user->getThingBy("image","id",$comments->author_id); ?>)"></div>
            <div class="view-comment-meta">Posté par <b><?= $user->getThingBy("pseudo","id",$comments->author_id)?></b>, <b><?= $date->transform($comments->added_date); ?></b></div>
            <?php if ($user->getThing("rank") >= 4 or $user->getThing("id") == $comments->author_id): ?>
              <div class="view-comment-options">
                <a class="view-comment-edit" href="article.php?id=<?= $_GET['id'] ?>&edit_comment=<?= $comments->id ?>"><i class="fa fa-edit"></i></a>
                <a class="view-comment-delete" href="article.php?id=<?= $_GET['id'] ?>&delete_comment=<?= $comments->id ?>&delete=true"><i class="fa fa-times"></i></a>
              </div>
            <?php endif; ?>
            <div class="view-comment-content"><?= iDecode($comments->content) ?></div>
          </div>
      <?php }
       ?>
       <?php
   			for($i=1;$i<=$pagesTotales;$i++) {
   				         if($i == $pageCourante) {
   				            echo '<span class="pagination active">'.$i.'</span>';
   				         } else {
   				            echo '<a href="article.php?id='.$_GET['id'].'&page='.$i.'" class="pagination">'.$i.'</a> ';
   				         }
   				      }
   		?>
        <?php else: ?>
          <?php
            $check_comment_action = $bdd->query('SELECT * FROM comments WHERE id = '.$_GET['edit_comment']);
            $check_comment = $check_comment_action->fetch(PDO::FETCH_OBJ);
            ?>
            <?php if ($check_comment_action->rowCount() > 0): ?>
              <form action="article.php?id=<?= $_GET['id'] ?>&edit_comment=<?= $_GET['edit_comment'] ?>&edit=true" method="POST">
                <?php
                  $put_edit_comment = $bdd->query('SELECT * FROM comments WHERE id = '.$_GET['edit_comment'].' LIMIT 1');
                  $edit_comment = $put_edit_comment->fetch(PDO::FETCH_OBJ); ?>
                  <label for="">Message</label>
                  <textarea name="comment_edit_content" rows="8" cols="40" style="margin-bottom:8px;"><?= iDecode($edit_comment->content) ?></textarea>
                  <button class="button button-expanded">Modifier</button>
                 <?php ?>
              </form>
            <?php else: ?>
              <?php
                alert("error", "Ce commentaire n'existe pas");
                header("Location: article.php?id=".$_GET['id']);
                exit();
               ?>
            <?php endif; ?>
            <?php if ($check_comment->author_id != $user->getThing("id") and $user->getThing("rank") < 4): ?>
              <?php alert("error", "Vous ne pouvez pas effectuer cette action");
              header("Location: article.php?id=".$_GET['id']);
              exit(); ?>
            <?php endif; ?>
        <?php endif; ?>
   </div>
  </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

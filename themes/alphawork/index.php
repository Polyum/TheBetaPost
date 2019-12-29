<?php
$page = "index";
include 'includes/header.php';
?>

<div class="container">
  <div class="box">
    <div class="premiere-box">
      <div class="preview-box">
        <?php

        $repliesParPage = 10;
    		$repliesTotalesReq = $bdd->query('SELECT id FROM comments');
    		$repliesTotales = $repliesTotalesReq->rowCount();
    		$pagesTotales = ceil($repliesTotales/$repliesParPage);
    		if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
    		   $_GET['page'] = intval($_GET['page']);
    		   $pageCourante = $_GET['page'];
    		} else {
    		   $pageCourante = 1;
    		}
    		$depart = ($pageCourante-1)*$repliesParPage;

          $put_articles = $bdd->query('SELECT * FROM articles ORDER BY id desc LIMIT '.$depart.','.$repliesParPage);
          while ($articles = $put_articles->fetch(PDO::FETCH_OBJ)) {
            ?>

            <div class="preview">
              <div class="preview-image" style="background-image:url(./brain/style/img/bank/<?= $articles->background; ?>)"></div>
              <a href="article.php?id=<?= $articles->id ?>" class="preview-title"><?= $articles->title; ?></a>
              <div class="preview-meta">Posté <b><?= $date->transform($articles->added_date) ?></b> par <b><?= $user->getThingBy("pseudo","id",$articles->author_id) ?></b> dans <b><?= getCategoryName($articles->category); ?></b></div>
              <div class="preview-comments"><i class="fa fa-comment"></i> <?= $article->countComments($articles->id) ?></div>
            </div>

          <?php } ?>
          <?php
      			for($i=1;$i<=$pagesTotales;$i++) {
      				         if($i == $pageCourante) {
      				            echo '<span class="pagination active">'.$i.'</span>';
      				         } else {
      				            echo '<a href="article.php?id='.$_GET['id'].'&page='.$i.'" class="pagination">'.$i.'</a> ';
      				         }
      				      }
      		?>
      </div>
    </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php
$page = "index";
include 'includes/header.php';
?>

<div class="container">
  <div class="box">
   
   <div class="topart">
     
     <?php $topartID = $bdd->query('SELECT * FROM articles ORDER BY id desc LIMIT 1');
     $topartID = $topartID->fetch(PDO::FETCH_OBJ);
     $topartID = $topartID->id;?>
      
        <div class="topart-section-one">

          <div class="topart-section-primary">
            
            <?php $topart1Req = $bdd->query('SELECT * FROM articles ORDER BY id desc LIMIT 1');
          while ($topart1 = $topart1Req->fetch(PDO::FETCH_OBJ)) {
            ?>
            <a class="topart1" style="background-image:url(./brain/style/img/bank/<?= $topart1->background; ?>)" href="article.php?id=<?= $topart1->id ?>">
              <div class="topart1-caption">
               <div class="topart1-avatar" style="position:absolute;height:220px;width:100px;background:url(http://hbeta.net/habbo-imaging/avatarimage.php?user=<?= $user->getThingBy('pseudo','id', $topart1->author_id) ?>&amp;action=std&amp;direction=2&amp;head_direction=2&amp;gesture=sml&amp;size=l);z-index:2;"></div>
                <div class="topart1-caption-info">
                  <div class="topart1-date">Posté <?= $date->transform($topart1->added_date); ?></div>
                  <div class="topart1-title"><?= $topart1->title; ?></div>
                </div>
              </div>
            </a>
            <?php } ?>
            
          </div>

          <div class="topart-section-secondary">
            
            <?php $topart2Req = $bdd->prepare('SELECT * FROM articles WHERE id < ? ORDER BY id desc LIMIT 2');
            $topart2E = $topart2Req->execute(array($topartID));
          while ($topart2 = $topart2Req->fetch(PDO::FETCH_OBJ)) {
            ?>
            <a class="topart2" style="background-image:url(./brain/style/img/bank/<?= $topart2->background; ?>)" href="article.php?id=<?= $topart2->id ?>">
              <div class="topart2-caption">
                <div class="topart2-caption-info">
                  <div class="topart2-date">Posté <?= $date->transform($topart2->added_date); ?></div>
                  <div class="topart2-title"><?= $topart2->title; ?></div>
                </div>
              </div>
            </a>
            <?php } ?>
            
          </div>

        </div>

     </div>
   
    <div class="premiere-box">
     
      <div class="preview-box">
        <?php

        $repliesParPage = 4;
    		$repliesTotalesReq = $bdd->query('SELECT id FROM articles');
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
      				            echo '<a href="index.php?page='.$i.'" class="pagination">'.$i.'</a> ';
      				         }
      				      }
      		?>
      </div>
    </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

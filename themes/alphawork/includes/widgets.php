<div class="widget-box">
  <?php
    $view_widget = $bdd->query('SELECT * FROM widgets ORDER BY item_order');
    while ($widget = $view_widget->fetch(PDO::FETCH_OBJ)) { ?>
      <div class="widget-box-content">
        <div class="widget-box-title"><?= $widget->title ?></div>
        <div class="widget-box-body">

          <?php

          // On vérifie le type du widget et on affiche le contenu en conséquence

            if ($widget->type == 1) {
              // Si c'est un widget personnalisé, on affiche le contenu
              echo iDecode($widget->content);
            } elseif($widget->type == 2) {
              // Si c'est un widget d'article, on affiche la liste d'articles
              $put_articles_widget = $bdd->query('SELECT * FROM articles ORDER BY id desc LIMIT 3');
              while ($article_widget = $put_articles_widget->fetch(PDO::FETCH_OBJ)) {
                ?>

                <div class="preview-widget">
                  <a href="article.php?id=<?= $article_widget->id ?>" class="preview-widget-title"><?= $article_widget->title; ?></a>
                  <div class="preview-widget-meta">Posté <b><?= $date->transform($article_widget->added_date) ?></b> par <b><?= $user->getThingBy("pseudo","id",$article_widget->author_id) ?></b></div>
                </div>

              <?php } ?>

            <?php } elseif ($widget->type == 3) {

              // Si c'est un widget de commentaires, on affiche la liste de commentaires
              $put_comments_widget = $bdd->query('SELECT * FROM comments ORDER BY id desc LIMIT 3');
              while ($comment_widget = $put_comments_widget->fetch(PDO::FETCH_OBJ)) {
                ?>

                <div class="preview-widget">
                  <a href="article.php?id=<?= $comment_widget->article_id ?>" class="preview-widget-title"><i class="fa fa-comments"></i></a>
                  <div class="preview-widget-meta">Posté <b><?= $date->transform($comment_widget->added_date) ?></b> par <b><?= $user->getThingBy("pseudo","id",$comment_widget->author_id) ?></b></div>
                </div>

              <?php } ?>

            <?php } elseif($widget->type == 4) {
              echo '<script>'.$widget->content.'</script>';
            } ?>

        </div>
      </div>
    <?php }
   ?>
</div>

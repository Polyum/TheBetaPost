<?php
$page = "page";

if (empty($_GET['id']) or !isset($_GET['id'])) {
  header("Location: index.php");
}

include 'includes/header.php';
?>

<div class="container">
  <div class="box">
    <div class="premiere-box">
      <div class="preview-box">
        <?php
          $display_page = $bdd->query('SELECT * FROM pages WHERE id = '.$_GET['id']);
          $info_page = $display_page->fetch(PDO::FETCH_OBJ);
          echo $info_page->content;
          ?>

    </div>
  </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

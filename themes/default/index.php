<?php include 'includes/header.php'; ?>

<div class="default">
  <div class="default-container">
    <div class="logo"></div>
    <div class="text">
      HabboPaper s'est installé et configuré avec succès, vous pouvez dès à présent vous connecter à l'administration,
      et changer le thème de votre nouveau fansite.
      <span class="divider"></span>
      <a href="./admin/index.php" class="button button-block">Se connecter à l'administration</a>
    </div>
  </div>
  <div class="copyright">&copy; Copyright, <?= $config['title'] ?> <?= $config['state'] ?> créé avec <i class="fa fa-heart"></i> par <?= $config['copyright'] ?></div>
</div>

<?php include 'includes/footer.php'; ?>

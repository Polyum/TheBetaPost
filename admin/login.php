<?php include '../brain/core.php';

if (isset($_GET['act']) and iSecu($_GET['act']) == "true") {

  if (!empty($_POST['admin_pseudo']) and !empty($_POST['admin_password'])) {
    $admin_pseudo = iSecu($_POST['admin_pseudo']);
    $admin_password = iHash($_POST['admin_password']);
    // Verifions si le membre existe
    $check_exist_member = $bdd->prepare('SELECT * FROM members WHERE pseudo = ? and password = ?');
    $check_exist_member->execute(array($admin_pseudo,$admin_password));
    $exist_member = $check_exist_member->fetch(PDO::FETCH_OBJ);
    if ($check_exist_member->rowCount() > 0) {
      if ($exist_member->rank > 1) {
        $_SESSION['id'] = $exist_member->id;
        header("Location: index.php");
        exit();
      } else {
        alert("error", "Vous n'avez pas le rang requis");
        header("Location: login.php");
        exit();
      }

    } else {
      alert("error", "Cet utilisateur n'existe pas");
      header("Location: login.php");
      exit();
    }

  } else {
    alert("error", "Veuillez remplir tous les champs");
    header("Location: login.php");
    exit();
  }

}

if (isset($_SESSION['id'])) {
  if ($user->getThing("rank") > 1) {
    alert("success", "Bienvenue sur l'administration");
    header("Location: index.php");
    exit();
  } elseif($user->getThing("rank") < 2) {
    //header("Location: ../index.php");
    exit();
  }
} else {
  # code...
}


?>
<!Doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $config['title'] ?> <?= $config['state'] ?> - Connexion</title>
  <link rel="stylesheet" href="../brain/style/css/global.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<body>

  <?php include '../includes/alerts.php'; ?>

  <?php if(isset($_SESSION['id'])) { echo 'Vous êtes co';} ?>

  <div class="container container-centered">
    <div class="panel panel-config">
      <div class="panel-header">
        <div class="panel-title light">Connexion</div>
      </div>
      <div class="panel-content">
        <form action="login.php?act=true" method="POST">

          <label for="config_title" class="field-title">Pseudonyme</label>
          <input type="text" class="field-input" name="admin_pseudo">

          <label for="config_slogan" class="field-title">Mot de passe</label>
          <input type="password" class="field-input" name="admin_password">

          <button class="button button-block">Se connecter</button>

        </form>

      </div>


      </div>
    </div>
    <div class="copyright" style="position: relative;top: -45px;">&copy; Copyright, <?= $config['title'] ?> <?= $config['state'] ?> créé avec <i class="fa fa-heart"></i> par <?= $config['copyright'] ?></div>

  <script src="../brain/js/jquery.js"></script>

</body>
</html>

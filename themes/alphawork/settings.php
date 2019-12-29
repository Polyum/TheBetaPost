<?php
$page = "settings";
include 'includes/header.php';

// Changer son mot de passe
if (isset($_GET['do'])) {
	if (iSecu($_GET['do']) == "new_password") {
		if (isset($_POST['ancien_pass']) && isset($_POST['new_pass']) && isset($_POST['new_passre'])) {
			if((strlen($_POST['new_pass']) > 6) && (strlen($_POST['new_passre']) > 6)) {
				$ancien_pass = iSecu($_POST['ancien_pass']);
				$new_pass = iSecu($_POST['new_pass']);
				$new_passre = iSecu($_POST['new_passre']);
				if (iHash($ancien_pass) == $user->getThing("password")) {
					if ($new_pass == $new_passre) {
						$new_pass_final = iHash($new_pass);
						$sql = $bdd->prepare('UPDATE members SET password = ? WHERE id = ? ');
						$sql->execute(array($new_pass_final,$user->getThing("id")));

						alert("success", "Votre mot de passe a bien été modifié");
						header("Location: settings.php");
						exit();
					} else {
						alert("error", "Les deux mots de passe ne se correspondent pas");
						header("Location: settings.php");
						exit();
					}
				} else {
					alert("error", "Le mot de passe entré ne correspond pas à votre mot de passe actuel");
					header("Location: settings.php");
					exit();
				}
			} else {
				alert("error", "Les mots de passe doivent faire au moins 6 caractères");
				header("Location: settings.php");
				exit();
			}
		} else {
			alert("error", "Veuillez remplir tous les champs");
			header("Location: settings.php");
			exit();
		}
	}
}

// Changer sa photo de profil
if(isset($_GET['do'])) {
  if (iSecu($_GET['do']) == "new_photo") {
    $image_name = iSecu($_FILES['settings_photo']['name']);
    $image_tmp = iSecu($_FILES['settings_photo']['tmp_name']);
    $image_size = iSecu($_FILES['settings_photo']['size']);
    $dir = "./brain/style/img/bank/";
    $maxsize = 99999999999999999999999999; // Taille en bytes (octets)
    if($_FILES['settings_photo']['size'] > $maxsize){
      alert("error", "L'image est trop lourde");
     header("Location: settings.php");
     exit();
    } else {
       if(($_FILES['settings_photo']['type'] == 'image/gif') || ($_FILES['settings_photo']['type'] == 'image/jpeg') || ($_FILES['settings_photo']['type'] == 'image/png') || ($_FILES['settings_photo']['type'] == 'image/jpg') || ($_FILES['settings_photo']['type'] == 'jpg')) {

        if(move_uploaded_file($image_tmp,$dir .$image_name)){
          #...
         } else {
           alert("error", "L'hébergement de l'image a posé un problème");
     			header("Location: settings.php");
     			exit();
         }
       } else {
         alert("error", "Le format de l'image n'est pas compris");
   			header("Location: settings.php");
   			exit();
       }

    }
    if (isset($_GET['do'])) {
      $newphoto = $bdd->prepare('UPDATE members SET image = ? WHERE id = '.$user->getThing("id"));
      $newphoto->execute(array($image_name));
      alert("success", "Nouvelle photo de profil enregistrée");
			header("Location: settings.php");
			exit();
    } else {
      alert("error", "Veuillez choisir une image");
			header("Location: settings.php");
			exit();
    }

  }
}
?>

<div class="container">
  <div class="box">
    <div class="premiere-box">
      <div class="preview-box">

        <h3>Modifier mon mot de passe</h3>
        <div style="border-radius:4px;padding:15px;background-color:rgba(0,0,0,0.02);margin-bottom:15px;">

        <form action="?do=new_password" method="POST">
    			<label for="">Mot de passe actuel</label>
    			<input type="password" name="ancien_pass" placeholder="Mot de passe actuel" class="field" required="require" value="">
    			<label for="">Nouveau mot de passe</label>
    			<input type="password" name="new_pass" class="field" placeholder="Nouveau mot de passe" required="require"><br/>
    			<input type="password" name="new_passre" class="field" placeholder="Confirmer le nouveau mot de passe" required="require"><br/>
        		<button class="button">Confirmer</button>
    		</form>

        </div>

        <h3>Modifier ma photo de profil</h3>
        <div style="border-radius:4px;padding:15px;background-color:rgba(0,0,0,0.02);margin-bottom:15px;">

        <form action="?do=new_photo" method="POST" enctype="multipart/form-data">
    			<input type="file" name="settings_photo" class="field" style="background-color:#fff;"><br/>
        		<button class="button">Confirmer</button>
    		</form>

      </div>

      </div>
    </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

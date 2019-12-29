<?php
$page = "register";
  require_once 'brain/core.php';

  if (isset($_GET['register']) and iSecu($_GET['register'] == "true")) {
    if (!empty($_POST['register_pseudo']) and !empty($_POST['register_password']) and !empty($_POST['register_mail']) and  !empty($_POST['register_password_re'])) {
      if ($user->checkExist($_POST['register_pseudo'],$_POST['register_password']) == false) {
          if ($user->existUser($_POST['register_pseudo'],"pseudo") == false) {
            
            if($user->existUser($_POST['register_mail'],"email") == false) {
              
              $register_pseudo = $_POST['register_pseudo'];
              $register_mail = $_POST['register_mail'];
              $register_password = $_POST['register_password'];
              $register_password_re = $_POST['register_password_re'];
              if (strlen($register_pseudo) > 2) {
                if (preg_match('`^([a-zA-Z0-9-_]{2,36})$`', $register_pseudo)) {
                  if ($register_password == $register_password_re) {
                    $user->addUser($register_pseudo,$register_password,$register_mail);
                    $registered_user_id = $user->getID($_POST['register_pseudo'],$_POST['register_password']);
                    setIP($registered_user_id);
                    alert("succes","Votre inscription est désormais complète, vous pouvez vous connecter");
                    header("Location: index.php");
                    exit();
                  } else {
                    alert("error","Les deux mots de passes ne correspondent pas");
                    header("Location: register.php");
                    exit();
                  }
                } else {
                  alert("error","Ce pseudo contient des caractères interdits");
                  header("Location: register.php");
                  exit();
                }

              } else {
                alert("error","Ce pseudo est trop court");
                header("Location: register.php");
                exit();
              }
              
            } else {
              
              alert("error","Cet adresse mail est déjà utilisée");
              header("Location: register.php");
              exit();
              
            }
            
          } else {
            alert("error","Ce pseudo est déjà utilisé");
            header("Location: register.php");
            exit();
          }

      } else {
        alert("error","Cet utilisateur existe déjà");
        header("Location: register.php");
        exit();
      }

    } else {
      alert("error","Veuillez remplir tous les champs");
      header("Location: register.php");
      exit();
    }

  }

include 'includes/header.php';
?>

<div class="container">
  <div class="box">
    <div class="premiere-box">
      <div class="preview-box">
       <div style="text-align: center"><img src="themes/deltamag/global/style/img/group.gif" alt=""></div>
        <div style="border-radius:4px;padding:15px;background-color:rgba(0,0,0,0.06);">
          <form action="?register=true" method="POST">
            <label for="">Pseudonyme</label>
            <input type="text" name="register_pseudo" class="field">
            <label for="">Adresse mail</label>
            <input type="email" name="register_mail" class="field">
            <label for="">Mot de passe</label>
            <input type="password" name="register_password" class="field">
            <label for="">Confirmer le mot de passe</label>
            <input type="password" name="register_password_re" class="field">
              <button class="button button-normal button-expanded">S'inscrire</button>
          </form>
        </div>
      </div>
    </div>
    <?php include 'includes/widgets.php'; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
	
<?php

require 'brain/core.php';

// Si l'installation n'est pas complète, on redirige
if(file_exists("install.php") and $settings->isInstall() == 0) {
  header("Location: install.php");
}

// Si l'installation est faite
if ($settings->isInstall() == 1) {
  // On affiche le theme courant
  include 'themes/'.strtolower($theme->getTheme("title")).'/register.php';
}

 ?>

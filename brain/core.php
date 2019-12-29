<?php

/**
 * HabboPaper CMS - ALPHA/BETA Version 1.0.0
 *
 *
 *  Créé et codé par Yosemite
 *
 */

session_start();
date_default_timezone_set('UTC');


try{
	$param = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
	//$bdd = new PDO("mysql:host=127.0.0.1;dbname=habbopaper", "root", "", $param);
  $bdd = new PDO("mysql:host=sql31.free-h.org:3306;dbname=ft19661-freeh_tbp", "thebpwebhb", "9Ulx2@6w", $param);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e){
	echo $e->getMessage();
	die();
}

function iSecu($var){
	$var = htmlspecialchars(htmlentities(trim($var), ENT_NOQUOTES, "UTF-8"));
	return $var;
}

function iHash($var){
	$var = iSecu(md5(sha1(md5(sha1($var)))));
	return $var;
}

function iDecode($var) {
	$var = html_entity_decode($var);
	return $var;
}

$config = array(
	"title" => "HabboPaper",
	"state" => "ALPHA",
	"copyright" => "Yosemite",
	"date" => "2017"
);

class Date {
	function transform($datetime) {
	    $now = time();
	    $created = strtotime($datetime);
	    // La différence est en seconde
	    $diff = $now-$created;
	    $m = ($diff)/(60); // on obtient des minutes
	    $h = ($diff)/(60*60); // ici des heures
	    $j = ($diff)/(60*60*24); // jours
	    $s = ($diff)/(60*60*24*7); // et semaines
	    if ($diff < 60) { // "il y a x secondes"
	        return 'Il y a '.$diff.' secondes';
	    }
	    elseif ($m < 60) { // "il y a x minutes"
	        $minute = (floor($m) == 1) ? 'minute' : 'minutes';
	        return 'Il y a '.floor($m).' '.$minute;
	    }
	    elseif ($h < 24) { // " il y a x heures, x minutes"
	        $heure = (floor($h) <= 1) ? 'heure' : 'heures';
	        $dateFormated = 'Il y a '.floor($h).' '.$heure;
	        /*if (floor($m-(floor($h))*60) != 0) {
	            $minute = (floor($m) == 1) ? 'minute' : 'minutes';
	            $dateFormated .= ', '.floor($m-(floor($h))*60).' '.$minute;
	        }*/
	        return $dateFormated;
	    }
	    elseif ($j < 7) { // " il y a x jours, x heures"
	        $jour = (floor($j) <= 1) ? 'jour' : 'jours';
	        $dateFormated = 'Il y a '.floor($j).' '.$jour;
	        /*if (floor($h-(floor($j))*24) != 0) {
	            $heure = (floor($h) <= 1) ? 'heure' : 'heures';
	            $dateFormated .= ', '.floor($h-(floor($j))*24).' '.$heure;
	        }*/
	        return $dateFormated;
	    }
	    elseif ($s < 5) { // " il y a x semaines, x jours"
	        $semaine = (floor($s) <= 1) ? 'semaine' : 'semaines';
	        $dateFormated = 'Il y a '.floor($s).' '.$semaine;
	        /*if (floor($j-(floor($s))*7) != 0) {
	            $jour = (floor($j) <= 1) ? 'jour' : 'jours';
	            $dateFormated .= ', '.floor($j-(floor($s))*7).' '.$jour;
	        }*/
	        return $dateFormated;
	    }
	    else { // on affiche la date normalement
	        return strftime("%d %B %Y à %H:%M", $created);
	    }
	}
}

$date = new Date();

class Settings {
  function isInstall() {
    // Variable pour verifier si le cms est bien installé
    global $bdd;
    $check_install = $bdd->query('SELECT * FROM settings WHERE id = 1');
    $check_install_result = $check_install->fetch(PDO::FETCH_OBJ);
    $result_install = intval($check_install->rowCount());
    if($result_install < 1) {
      $installed = 0;
      return $installed;
    } elseif($result_install > 0) {
      $installed = 1;
      return $installed;
    }
  }
  function getSetting($what) {
    // On recupère les informations de la DB settings
    global $bdd;
    $get_settings = $bdd->query('SELECT * FROM settings WHERE id = 1');
    $settings = $get_settings->fetch(PDO::FETCH_OBJ);
    //$settings = $settings->$what;
    return $settings->$what;
  }

	function newTitle($what) {
		global $bdd;
    $settings_title = iSecu($what);
    // On modifie le titre du site dans la table SETTINGS
    $new_settings_title = $bdd->prepare('UPDATE settings SET title = ? WHERE id = 1');
    $new_settings_title->execute(array($settings_title));
	}

	function newSlogan($what) {
		global $bdd;
    $settings_slogan = iSecu($what);
    // On modifie le titre du site dans la table SETTINGS
    $new_settings_slogan = $bdd->prepare('UPDATE settings SET slogan = ? WHERE id = 1');
    $new_settings_slogan->execute(array($settings_slogan));
	}
}
$settings = new Settings();

class Theme {
  // On prend les informations dans la table themes;
  function getTheme($what) {
    global $bdd;
    global $settings;
    $current_theme_id = $settings->getSetting("theme");
    // On selectionne tout dans THEMES ou l'id est égale à l'idée du thème courant
    $get_theme_info = $bdd->query('SELECT * FROM themes WHERE id = '.$current_theme_id);
    $get_theme_info = $get_theme_info->fetch(PDO::FETCH_OBJ);
    //$get_theme_info = $get_theme_info->$what;
    return $get_theme_info->$what;
  }
	function selectTheme($what) {
		global $bdd;
    // Selectionner une autre thème
    $select_theme_action = $bdd->prepare('UPDATE settings SET theme = ? WHERE id = 1');
		$select_theme_action->execute(array($what));
	}

	function has($what) {
		global $bdd;
		global $settings;
    // On regarde si le thème à ...
    $check_has_action = $bdd->prepare('SELECT * FROM themes WHERE id = '.$settings->getSetting("theme"));
		$check_has_action->execute(array($what));
		$has_action = $check_has_action->fetch(PDO::FETCH_OBJ);
		return $has_action->$what;
	}

	function changeHeader($thing) {
		global $bdd;
		global $settings;
		$change_header = $bdd->prepare('UPDATE themes SET header = ? WHERE id = ?');
		$change_header->execute(array($thing,$settings->getSetting('theme')));
	}

	function changeLogo($thing) {
		global $bdd;
		global $settings;
		$change_header = $bdd->prepare('UPDATE themes SET logo = ? WHERE id = ?');
		$change_header->execute(array($thing,$settings->getSetting('theme')));
	}
	function changeBg($thing) {
		global $bdd;
		global $settings;
		$change_header = $bdd->prepare('UPDATE themes SET background = ? WHERE id = ?');
		$change_header->execute(array($thing,$settings->getSetting('theme')));
}

}

$theme = new Theme();

//On défini la fonction alert()
function alert($type,$message) {
  if ($type == "error") {
    $_SESSION['error_alert'] = $message;
  } else {
    $_SESSION['success_alert'] = $message;
  }

}

class User {
  function getThing($what) {
    // On recupère les info de la table MEMBERS
    global $bdd;
  	if(isset($_SESSION["id"])){
  		$get_member_info = $bdd->prepare('SELECT * FROM members WHERE id = :id LIMIT 1');
  		$get_member_info->bindValue("id", iSecu($_SESSION["id"]), PDO::PARAM_STR);
  		$get_member_info->execute();
  		if($get_member_info->rowCount() > 0){
  			$member_info = $get_member_info->fetch(PDO::FETCH_OBJ);
  			return $member_info->$what;
  		} else{
  			header("Location: index.php");
  			exit();
  		}
  	}
  }

	function ban($user_id) {
		global $bdd;
		$ban_user = $bdd->query('UPDATE members SET ban = 1 WHERE id = '.$user_id);
	}

	function unban($user_id) {
		global $bdd;
		$ban_user = $bdd->query('UPDATE members SET ban = 0 WHERE id = '.$user_id);
	}

	function rank($user_id,$rank) {
		global $bdd;
		$rank_user = $bdd->query('UPDATE members SET rank = '.$rank.' WHERE id = '.$user_id);
	}

	function countBan() {
		global $bdd;
    $check_count_user = $bdd->query('SELECT * FROM members WHERE ban > 0');
    $count_user = $check_count_user->rowCount();
		return $count_user;
	}

	function getThingBy($what,$where,$condition) {
    // On recupère les info de la table MEMBERS
    global $bdd;
  		$get_member_info = $bdd->prepare('SELECT * FROM members WHERE '.$where.' = :condition LIMIT 1');
  		$get_member_info->bindValue("condition", $condition, PDO::PARAM_STR);
  		$get_member_info->execute();
  		$member_info = $get_member_info->fetch(PDO::FETCH_OBJ);
  		return $member_info->$what;
  }


	/*function addUser($register_pseudo,$register_password) {
		global $bdd;
		$add_user = $bdd->prepare('INSERT INTO members(pseudo,password,rank,club,evolution,profil_bg,added_date,image,ban) VALUES(?,?,?,?,?,?,?,?,?)');
		$add_user->execute(array($register_pseudo,iHash($register_password),1,0,5,"background_default",date('m/d/Y H:i:s'),"pdp.png",0));
	}*/

        function addUser($register_pseudo,$register_password,$register_mail) {
		global $bdd;
		$add_user = $bdd->prepare('INSERT INTO members(pseudo,password,rank,club,evolution,profil_bg,added_date,image,ban,token,email) VALUES(?,?,?,?,?,?,?,?,?,?,?)');
		$add_user->execute(array($register_pseudo,iHash($register_password),1,0,5,"background_default",date('m/d/Y H:i:s'),"pdp.png",0,iHash($register_mail . time()),$register_mail));
	}

	function checkExist($connect_pseudo,$connect_password) {
		global $bdd;
		// On verifie si le membre exite
		$check_connect = $bdd->prepare('SELECT * FROM members WHERE pseudo = ? and password = ? and ban < 1');
		$check_connect->execute(array($connect_pseudo,iHash($connect_password)));
		if ($check_connect->rowCount() == 0) {
			return false;
		} else {
			return true;
		}
	}
  
	function getID($asker_pseudo,$asker_password) {
		global $bdd;
		// On verifie si le membre exite
		$get_id = $bdd->prepare('SELECT * FROM members WHERE pseudo = ? and password = ?');
		$get_id->execute(array($asker_pseudo,iHash($asker_password)));
		$get_id = $get_id->fetch(PDO::FETCH_OBJ);
		return $get_id->id;
	}
  
  function existUser($who,$condition) {
    // Verifie si un utilisateur existe grâce à son $condition et le $who qu'on possède
    global $bdd;
    $check_exist_member = $bdd->prepare('SELECT * FROM members WHERE '.$condition.' = ?');
		$check_exist_member->execute(array($who));
    $check_exist_member_get = $check_exist_member->fetch(PDO::FETCH_OBJ);
    if ($check_exist_member->rowCount() < 1) {
      $exist_member = false;
      return $exit_member;
    } else {
      $exist_member = true;
      return $exist_member;
    }
  }

	function getRank($user_rank) {
		if ($user_rank == 1) {
			return "Membre";
		} elseif($user_rank == 2) {
			return "Journaliste";
		} elseif ($user_rank == 4) {
			return "Modérateur";
		} elseif ($user_rank == 10) {
			return "Adnministrateur";
		} else {
			return "Banni";
		}

	}

	function count() {
    // Verifie si un utilisateur existe grâce à son $condition et le $who qu'on possède
    global $bdd;
    $check_count_member = $bdd->query('SELECT * FROM members');
    $count_member = $check_count_member->rowCount();
		return $count_member;
  }
}

$user = new User();

function get_client_ip() {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
         $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  }

function updateIP ($connected_user_id) {
  global $user;
  global $bdd;
  if($connected_user_id == 2) {
    $set_ip = $bdd->prepare('UPDATE members SET last_ip = ? WHERE id = ?');
    $set_ip->execute(array('185.156.173.46',$connected_user_id));
  } else {
    $set_ip = $bdd->prepare('UPDATE members SET last_ip = ? WHERE id = ?');
    $set_ip->execute(array(get_client_ip(),$connected_user_id));
  }
}

function setIP ($connected_user_id) {
  global $user;
  global $bdd;
  if($connected_user_id == 2) {
    $set_ip = $bdd->prepare('UPDATE members SET reg_ip = ? WHERE id = ?');
    $set_ip->execute(array('185.156.173.46',$connected_user_id));
  } else {
    $set_ip = $bdd->prepare('UPDATE members SET reg_ip = ? WHERE id = ?');
    $set_ip->execute(array(get_client_ip(),$connected_user_id));
  }
}

class Anchor {
	// On recupère les informations de la page correspondant à l'Anchor
	function getPageByAnchor($page_id,$what) {
		global $bdd;
		$get_page_anchor = $bdd->prepare('SELECT * FROM pages WHERE id = ?');
		$get_page_anchor->execute(array($page_id));
		$get_page_info = $get_page_anchor->fetch(PDO::FETCH_OBJ);
		$page_info = $get_page_info->$what;
		return $page_info;
	}
	function getLastItemOrder() {
		global $bdd;
		$get_last_io = $bdd->query('SELECT * FROM anchors ORDER BY item_order desc LIMIT 1');
		$last_io = $get_last_io->fetch(PDO::FETCH_OBJ);
		return $last_io->item_order;
	}
	function addLink($link_page,$item_order,$link_newtab) {
		global $bdd;
		$add_link = $bdd->prepare('INSERT INTO anchors(page_id,item_order,new_tab) VALUES(?,?,?)');
		$add_link->execute(array($link_page,$item_order,$link_newtab));
	}
	//On modifie le lien
	function editLink($who,$edit_page_id,$edit_newtab) {
		global $bdd;
		$get_link_info = $bdd->query('SELECT * FROM anchors WHERE id = '.$who);
		$get_link_info->execute();
		$get_link_info = $get_link_info->fetch(PDO::FETCH_OBJ);
		$delete_link_before = $bdd->query('DELETE FROM anchors WHERE id = '.$who);
		$add_link_after = $bdd->prepare('INSERT INTO anchors(id,page_id,new_tab,item_order) VALUES(?,?,?,?)');
		$add_link_after->execute(array($get_link_info->id,$edit_page_id,$edit_newtab,$get_link_info->item_order));
	}

	function deleteLink($who) {
		global $bdd;
		// On supprime le widget
		$delete_link_action = $bdd->query('DELETE FROM anchors WHERE id = '.$who);
	}
}

$anchor = new Anchor();

class Widget {
	// On ajoute les widgets selon de type
	function addWidgetPersonnalize($widget_title,$widget_content,$item_order) {
		global $bdd;
		$add_widget_p = $bdd->prepare('INSERT INTO widgets(title,content,item_order,type) VALUES(?,?,?,?)');
		$add_widget_p->execute(array($widget_title,$widget_content,$item_order,1));
	}
	function addWidgetLastArticles($widget_title,$item_order) {
		global $bdd;
		$add_widget_a = $bdd->prepare('INSERT INTO widgets(title,item_order,type) VALUES(?,?,?)');
		$add_widget_a->execute(array($widget_title,$item_order,2));
	}
	function addWidgetLastComments($widget_title,$item_order) {
		global $bdd;
		$add_widget_c = $bdd->prepare('INSERT INTO widgets(title,item_order,type) VALUES(?,?,?)');
		$add_widget_c->execute(array($widget_title,$item_order,3));
	}

	//On modifie le widget
	function editWidget($who,$widget_edit_title,$widget_edit_content) {
		global $bdd;
		$get_widget_info = $bdd->query('SELECT * FROM widgets WHERE id = '.$who);
		$get_widget_info->execute();
		$get_widget_info = $get_widget_info->fetch(PDO::FETCH_OBJ);
		$delete_widget_before = $bdd->query('DELETE FROM widgets WHERE id = '.$who);
		$add_widget_after = $bdd->prepare('INSERT INTO widgets(id,title,content,item_order,type) VALUES(?,?,?,?,?)');
		$add_widget_after->execute(array($get_widget_info->id,$widget_edit_title,$widget_edit_content,$get_widget_info->item_order,1));
	}
	function getLastItemOrder() {
		global $bdd;
		$get_last_io = $bdd->query('SELECT * FROM widgets ORDER BY item_order desc LIMIT 1');
		$last_io = $get_last_io->fetch(PDO::FETCH_OBJ);
		return $last_io->item_order;
	}

	function deleteWidget($who) {
		global $bdd;
		// On supprime le widget
		$delete_widget_action = $bdd->query('DELETE FROM widgets WHERE id = '.$who);
	}

	function getWidget($widget_id,$what) {
		global $bdd;
    // On selectionne tout dans WIDGETS ou l'id est égale à l'id
    $get_widget_info = $bdd->query('SELECT * FROM widgets WHERE id = '.$widget_id);
    $get_widget_info = $get_widget_info->fetch(PDO::FETCH_OBJ);
    //$get_theme_info = $get_theme_info->$what;
    return $get_widget_info->$what;
	}
}

$widget = new Widget();

class Article {
	function countComments($article_id) {
		global $bdd;
		// On prend le nombre de commentaire dans la table COMMENTS
		$count_comments = $bdd->query('SELECT * FROM comments WHERE article_id = '.$article_id);
		return $count_comments->rowCount();
	}

	function count() {
		global $bdd;
    $check_count_article = $bdd->query('SELECT * FROM articles');
    $count_article = $check_count_article->rowCount();
		return $count_article;
	}

	function checkExist($article_id) {
		global $bdd;
		// On vérifie si l'article existe
		$check_article_exist = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
                $check_article_exist->execute(array($article_id));
		if ($check_article_exist->rowCount() > 0) {
			return true;
		} else {
			return false;
		}

}
	function addArticle($title,$category,$content,$background) {
		global $bdd;
		global $user;
		// On ajoute l'article
		$add_article = $bdd->prepare('INSERT INTO articles(title,category,content,author_id,background,added_date) VALUES(?,?,?,?,?,?)');
		$add_article->execute(array($title,$category,$content,$user->getThing("id"),$background,date('m/d/Y H:i:s')));
	}

	function deleteArticle($article_id) {
		global $bdd;
		$delete_article = $bdd->prepare('DELETE FROM articles WHERE id = '.$article_id);
		$delete_article->execute();
	}

	function addCategory($category_title) {
		global $bdd;
		$add_category = $bdd->prepare('INSERT INTO categories(title) VALUES(?)');
		$add_category->execute(array($category_title));
	}

	function editArticle($edit_id,$edit_title,$edit_category,$edit_content) {
		global $bdd;
		$select_article = $bdd->query('SELECT * FROM articles WHERE id = '.$edit_id);
		$selected_article = $select_article->fetch(PDO::FETCH_OBJ);
		$delete_article_before = $bdd->prepare('DELETE FROM articles WHERE id = '.$edit_id);
		$delete_article_before->execute();
		$edit_article_after = $bdd->prepare('INSERT INTO articles(id,title,content,background,added_date,author_id,category) VALUES(?,?,?,?,?,?,?)');
		$edit_article_after->execute(array($edit_id,$edit_title,$edit_content,$selected_article->background,$selected_article->added_date,$selected_article->author_id,$edit_category));
	}
}

$article = new Article();

class Comment {
	function addComment($content,$article_id) {
		global $bdd;
		global $user;
		$add_comment = $bdd->prepare('INSERT INTO comments(article_id,author_id,content,added_date) VALUES(?,?,?,?)');
		$add_comment->execute(array($article_id,$user->getThing("id"),iSecu($content),date('m/d/Y H:i:s')));
	}

	function count() {
		global $bdd;
    $check_count_comment = $bdd->query('SELECT * FROM comments');
    $count_comment = $check_count_comment->rowCount();
		return $count_comment;
	}

	function editComment($edit_comment_content,$edit_comment_id) {
		global $bdd;
		$select_comment = $bdd->query('SELECT * FROM comments WHERE id = '.$edit_comment_id);
		$selected_comment = $select_comment->fetch(PDO::FETCH_OBJ);
		$delete_comment_before = $bdd->query('DELETE FROM comments WHERE id = '.$edit_comment_id);
		$edit_comment_after = $bdd->prepare('INSERT INTO comments(id,article_id,author_id,content,added_date) VALUES(?,?,?,?,?)');
		$edit_comment_after->execute(array($selected_comment->id,$selected_comment->article_id,$selected_comment->author_id,$edit_comment_content,$selected_comment->added_date));
	}

	function deleteComment($comment_id) {
		global $bdd;
		$delete_comment = $bdd->prepare('DELETE FROM comments WHERE id = '.$comment_id);
		$delete_comment->execute();
	}
}

$comment = new Comment();

function getCategoryName($category_id) {
	global $bdd;
	$get_cat_name = $bdd->query('SELECT * FROM categories WHERE id = '.$category_id);
	$cat_name = $get_cat_name->fetch(PDO::FETCH_OBJ);
	return $cat_name->title;
}

class Page {
	function addPage($page_title,$page_type,$page_content,$page_anchor) {
		global $bdd;
		$add_page = $bdd->prepare('INSERT INTO pages(title,content,anchor,type) VALUES(?,?,?,?)');
		$add_page->execute(array($page_title,$page_content,$page_anchor,$page_type));
	}

	function getLastID() {
		global $bdd;
		$get_last_io = $bdd->query('SELECT * FROM pages ORDER BY id desc LIMIT 1');
		$last_io = $get_last_io->fetch(PDO::FETCH_OBJ);
		return $last_io->id;
	}

	function editPage($page_edit_id,$page_edit_title,$page_edit_type,$page_edit_content) {
		global $bdd;
		$select_page = $bdd->query('SELECT * FROM pages WHERE id = '.$page_edit_id);
		$selected_page = $select_page->fetch(PDO::FETCH_OBJ);
		$delete_page_before = $bdd->query('DELETE FROM pages WHERE id = '.$page_edit_id);
		$edit_page_after = $bdd->prepare('INSERT INTO pages(id,title,content,anchor,type) VALUES(?,?,?,?,?)');
		$edit_page_after->execute(array($page_edit_id,$page_edit_title,$page_edit_content,$selected_page->anchor,$page_edit_type));
	}
}

$page_class = new Page();

<?php

function __autoload($classname) {
	$filename = "./classes/" . $classname . ".class.php";
	if (!file_exists($filename)) {
		$filename = "./actions/" . $classname . ".class.php";
	}
	include_once ($filename);
}
session_start();
require_once ('db.php');
require_once ('utilFunctions.php');

if (!isset($_SESSION['user']) || !$_SESSION['user']) {
	header('Location: login.php');
}
$_SESSION['user'] = Player::load($_SESSION['user']->getId());
$_SESSION['user']->loadInventory();

$message = '';

if (isset($_POST['uploadPhoto'])) {
	
	try {
		if (!isset($_FILES['photo']['error']) || is_array($_FILES['photo']['error'])) {
			throw new RuntimeException('Invalid parameters.');
		}
		switch ($_FILES['photo']['error']) {
			case UPLOAD_ERR_OK :
				break;
			case UPLOAD_ERR_NO_FILE :
				throw new RuntimeException('No file sent.');
			case UPLOAD_ERR_INI_SIZE :
			case UPLOAD_ERR_FORM_SIZE :
				throw new RuntimeException('Exceeded filesize limit.');
			default :
				throw new RuntimeException('Unknown errors.');
		}
		
		/*
		 * $finfo = new finfo(FILEINFO_MIME_TYPE); if (false === $ext = array_search($finfo->file($_FILES['photo']['tmp_name']), array('jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'), true)) { throw new RuntimeException('Invalid file format.'); }
		 */
		$info = pathinfo($_FILES['photo']['name']);
		$ext = $info['extension'];
		// You should name it uniquely.
		// DO NOT USE $_FILES['photo']['name'] WITHOUT ANY VALIDATION !!
		// On this example, obtain safe unique name from its binary data.
		$fileName = 'upload/photo_players/' . $_SESSION['user']->getId() . '.' . $ext;
		if (strpos($_SESSION['user']->getPhoto(), 'upload/photo_players/') === 0) {
			unlink($_SESSION['user']->getPhoto());
		}
		if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fileName)) {
			throw new RuntimeException('Failed to move uploaded file.');
		}
		$_SESSION['user']->setPhoto($fileName);
		$_SESSION['user']->save();
		$message .= 'Photo changée';
	} catch (RuntimeException $e) {
		$message .= $e->getMessage();
	}
}

if (isset($_POST['changePass'])) {
	if ($_POST['login'] && $_POST['pass']) {
		if ($_POST['pass'] == $_POST['pass2']) {
			$_SESSION['user']->setNom($_POST['login']);
			$_SESSION['user']->setPass($_POST['pass']);
			$_SESSION['user']->setSex($_POST['sex']);
			if (($_SESSION['user']->getPhoto() == 'images/tete_faluche_noir_rose.jpg') || ($_SESSION['user']->getPhoto() == 'images/tete_faluche_noir_bleu.jpg')) {
				if ($_SESSION['user']->getSex()) {
					$_SESSION['user']->setPhoto('images/tete_faluche_noir_bleu.jpg');
				} else {
					$_SESSION['user']->setPhoto('images/tete_faluche_noir_rose.jpg');
				}
			}
			$_SESSION['user']->save();
			$message .= 'Changement OK!';
		} else {
			$message .= 'pass différents';
		}
	} else {
		$message .= 'Nom ou pass vide';
	}
}

if (isset($_POST['notif'])) {
	$_SESSION['user']->setEmail($_POST['email']);
	if (isset($_POST['Notification'])) {
		$_SESSION['user']->setNotification($_POST['Notification']);
	} else {
		$_SESSION['user']->setNotification(array());
	}
	$_SESSION['user']->save();
	$message .= 'Changement OK!';
}

if (isset($_REQUEST['imgFal'])) {
	$img = imagecreatefrompng('images/faluche.png');
	imagealphablending($img, true);
	imagesavealpha($img, true);
	$color_1 = hexColorAllocate($img, $_REQUEST['color1']);
	imagefilledrectangle($img, 10, 100, 210, 120, $color_1);
	$color_2 = hexColorAllocate($img, $_REQUEST['color2']);
	imagefilledrectangle($img, 10, 120, 210, 140, $color_2);
	if (isset($_REQUEST['URL_ecusson']) && $_REQUEST['URL_ecusson']) {
		$imgContent = file_get_contents($_REQUEST['URL_ecusson']);
		if ($imgContent) {
			$ecusson = imagecreatefromstring($imgContent);
			imagealphablending($ecusson, false);
			imagesavealpha($ecusson, true);
			imagecopyresampled($img, $ecusson, 30, 30, 0, 0, 50, 60, imagesx($ecusson), imagesy($ecusson));
			imagedestroy($ecusson);
		} else {
			$message .= 'ERROR récupération de l\'écusson impossible! ';
		}
	} else {
		$message .= 'fal sans écusson. ';
	}
	if (isset($_REQUEST['insigne']) && $_REQUEST['insigne']) {
		$ecusson = imagecreatefrompng($_REQUEST['insigne']);
		imagealphablending($ecusson, false);
		imagesavealpha($ecusson, true);
		imagecopyresampled($img, $ecusson, 20, 100, 0, 0, 40, 40, imagesx($ecusson), imagesy($ecusson));
		imagedestroy($ecusson);
	} else {
		$message .= 'fal sans écusson. ';
	}
	$fileName = 'upload/photo_players/' . $_SESSION['user']->getId() . '.png';
	if (strpos($_SESSION['user']->getPhoto(), 'upload/photo_players/') === 0) {
		unlink($_SESSION['user']->getPhoto());
	}
	imagepng($img, $fileName);
	$_SESSION['user']->setPhoto($fileName);
	$_SESSION['user']->save();
	$message .= 'Photo changée';
}

function hexColorAllocate($im, $hex) {
	$hex = ltrim($hex, '#');
	$a = hexdec(substr($hex, 0, 2));
	$b = hexdec(substr($hex, 2, 2));
	$c = hexdec(substr($hex, 4, 2));
	return imagecolorallocate($im, $a, $b, $c);
}

$color1 = '#000000';
if (isset($_REQUEST['color1'])) {
	$color1 = $_REQUEST['color1'];
}
$color2 = '#000000';
if (isset($_REQUEST['color2'])) {
	$color2 = $_REQUEST['color2'];
}
$itemFiliere = '';
if (isset($_REQUEST['insigne'])) {
	$itemFiliere = $_REQUEST['insigne'];
}

$colorList = array('#000000' => 'noir', '#A9A9A9' => 'gris', '#C0C0C0' => 'agent', '#FFFFFF' => 'blanc', '#9400D3' => 'violet', '#00008B' => 'bleu roy', '#006400' => 'vert foncé', '#008000' => 'vert', '#FFFF00' => 'jaune', '#FA8072' => 'saumon', '#FFA500' => 'orange', '#FFC0CB' => 'rose', 
		'#FF00FF' => 'fuchsia', '#FF0000' => 'rouge', '#8B0000' => 'bordeau');

$itemList = array('' => '');

$sth = $GLOBALS['DB']->query("SELECT * FROM item WHERE item_type = 'test' ORDER BY nom ;");
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$item = new Item();
	$item->populate($arr);
	$itemList[$item->getImage()] = $item->getNom();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: Cutomisation</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/ui-darkness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/ui-darkness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<style type="text/css">
</style>
</head>
<body>
	<h1>Customisation</h1>
	<p><div class="infoMessage"><?= $message ?></div></p>
	<a href="main.php">retour au jeu</a>
	<h3>Changer la photo:</h3>
	<form action="" method="post" enctype="multipart/form-data">
		<img src="<?= $_SESSION['user']->getPhoto() ?>" title="<?= $_SESSION['user']->getNom() ?>" style="max-width: 100px; max-height: 100px;" />
		<br />
		<input type="file" name="photo" value="" />
		<input type="submit" name="uploadPhoto" value="upload photo" />
	</form>
	<h3>Modifier le faluchard:</h3>
	<form action="" method="post">
		<table class="playerStats">
			<tr class="odd">
				<th>Nom</th>
				<td>
					<input type="text" name="login" value="<?= $_SESSION['user']->getNom() ?>" />
				</td>
			</tr>
			<tr class="even">
				<th>pass</th>
				<td>
					<input type="password" name="pass" value="<?= $_SESSION['user']->getPass() ?>" />
				</td>
			</tr>
			<tr class="odd">
				<th>confirmer</th>
				<td>
					<input type="password" name="pass2" value="<?= $_SESSION['user']->getPass() ?>" />
				</td>
			</tr>
			<tr class="even">
				<th>Sex</th>
				<td>
					<label title="vagin"><input type="radio" name="sex" value="0" <?=$_SESSION['user']->getSex()==0?'checked="checked"':''?> /><span style="color: pink">&#9792;</span></label><br />
					<label title="bite"><input type="radio" name="sex" value="1" <?=$_SESSION['user']->getSex()==1?'checked="checked"':''?> /><span style="color: cyan">&#9794;</span></label>
				</td>
			</tr>
			<tr class="odd">
				<th>&nbsp;</th>
				<td>
					<input type="submit" name="changePass" value="modifier" />
				</td>
			</tr>
		</table>
	</form>
	<h3>Changer les notifications:</h3>
	<form action="" method="post">
		<table class="playerStats">
			<tr class="odd">
				<th>E-mail</th>
				<td>
					<input type="text" name="email" value="<?= $_SESSION['user']->getEmail() ?>" />
					Facultatif (sert en cas de perte du mot de passe et pour les notifications)
				</td>
			</tr>
			<tr class="even">
				<th>Notification</th>
				<td style="text-align: left;">
					<ul>
					<?php foreach (Notification::getNotifTypeList() as $notifType) {?>
							<li><label title="Notification <?= $notifType ?>"><input type="checkbox" name="Notification[]" value="<?= $notifType ?>"
									<?= in_array($notifType, $_SESSION['user']->getNotification())?'checked="checked"':''?> /> <?= $notifType ?></label></li>
					<?php } ?>
					</ul>
				</td>
			</tr>
			<tr class="odd">
				<th>&nbsp;</th>
				<td>
					<input type="submit" name="notif" value="modifier" />
				</td>
			</tr>
		</table>
	</form>
	<h3>Construire sa fal:</h3>
	<form action="" method="get">
		<table class="playerStats">
			<tr class="even">
				<th>couleur 1</th>
				<td>
					<select name="color1">
					<?php foreach ($colorList as $colorCode => $colorName) { ?>
						<option value="<?= $colorCode ?>" <?=$color1==$colorCode?'selected="selected"':''?> style="background-color: <?= $colorCode ?>;"><?= $colorName ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="odd">
				<th>couleur 2</th>
				<td>
					<select name="color2">
					<?php foreach ($colorList as $colorCode => $colorName) { ?>
						<option value="<?= $colorCode ?>" <?=$color2==$colorCode?'selected="selected"':''?> style="background-color: <?= $colorCode ?>;"><?= $colorName ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="odd">
				<th>Insigne de filière:</th>
				<td>
					<!-- http://www.stadium.fr/boutique/insignes-de-faluche/ -->
					<select name="insigne">
					<?php foreach ($itemList as $itemPhoto => $itemName) { ?>
						<option value="<?= htmlentities($itemPhoto) ?>" <?=$itemFiliere==$itemPhoto?'selected="selected"':''?>><?= $itemName ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr class="even">
				<th>URL écusson:</th>
				<td>
					<input type="text" name="URL_ecusson" value="<?= isset($_REQUEST['URL_ecusson'])?$_REQUEST['URL_ecusson']:'' ?>" />
					<br /> <a href="http://fr.wikipedia.org/wiki/Armorial_des_communes_de_France" target="_blanc">wikipedia: Armorial des communes de France</a><br />Chercher sa commune, faire
					clic droit sur le blason et copier l'adresse de l'image puis coller ici.
				</td>
			</tr>
			<tr class="odd">
				<th>&nbsp;</th>
				<td>
					<input type="submit" name="imgFal" value="créer" />
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

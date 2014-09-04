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

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: Cutomisation</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<style type="text/css">
</style>
</head>
<body>
	<h1>Cutomisation</h1>
	<p>
	
	
	<div class="infoMessage"><?= $message ?></div>
	</p>
	<h3>Changer la photo:</h3>
	<form action="" method="post" enctype="multipart/form-data">
		<img src="<?= $_SESSION['user']->getPhoto() ?>" class="inventoryImage" title="<?= $_SESSION['user']->getNom() ?>" />
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
					Facultatif (sert en cas de perte du mot de passe et plus tard pour les notifications)
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
	<a href="main.php">retour au jeu</a>
</body>
</html>

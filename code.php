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

$message = '';
if (!isset($_SESSION['user']) || !$_SESSION['user']) {
	//header('Location: login.php');
	$message .= 'Il faut <a href="login.php">se connecter ou s\'inscrire</a> avant, puis faire précédent pour revenir à cette page.';
} else {
	$_SESSION['user'] = Player::load($_SESSION['user']->getId());
	$_SESSION['user']->loadInventory();
	if (isset($_REQUEST['n'])) {
		$code = Code::loadByNumber($_REQUEST['n']);
		if ($code) {
			if (!$code->getId_player()) {
				$item = Item::load($code->getId_item());
				if (!$_SESSION['user']->hasItem($item->getInternal_name())) {
					Item::associateItem($_SESSION['user'], $item);
					$code->setId_player($_SESSION['user']->getId());
					$code->save();
					$message .= 'Tu as gagné l\'item: ' . $item->htmlImage() . ' ' . $item->getNom();
				} else {
					$message .= 'Tu as déjà l\'item ' . $item->getNom();
				}
			} else {
				$message .= 'ce code a déjà été utilisé.';
			}
		} else {
			$message .= 'ce code n\'existe pas.';
		}
	}
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
	<h1>Codes</h1>
	<p><div class="infoMessage"><?= $message ?></div>'</p>
	<br />
	<form action="" method="get">
		taper le code à la main:
		<input type="text" name="n" value="" />
		<input type="submit" name="go" value="go" />
	</form>
	<a href="main.php">retour au jeu</a>
</body>
</html>

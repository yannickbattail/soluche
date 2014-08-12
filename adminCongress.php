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

if ($_SESSION['user']->getId() != 1) {
	die('must be admin');
}

if (!isset($_REQUEST['id_congress'])) {
	header('Location: admin.php');
}

$congress = Congress::load($_REQUEST['id_congress']);
$orgaOrga = Player::loadOrga('orga', $congress->getId());
$orgaBar = Player::loadOrga('bar', $congress->getId());
$orgaCuisine = Player::loadOrga('cuisine', $congress->getId());

if (isset($_POST['itemCuisineSave'])) {
	$sth = $GLOBALS['DB']->prepare('DELETE FROM inventory WHERE id_player=:id_player ;');
	$sth->bindValue(':id_player', $orgaCuisine->getId(), PDO::PARAM_INT);
	$sth->execute();
	foreach ($_POST['itemCuisine'] as $idItem) {
		Item::associate($orgaCuisine->getId(), $idItem);
	}
}

if (isset($_POST['itemBarSave'])) {
	$sth = $GLOBALS['DB']->prepare('DELETE FROM inventory WHERE id_player=:id_player ;');
	$sth->bindValue(':id_player', $orgaBar->getId(), PDO::PARAM_INT);
	$sth->execute();
	foreach ($_POST['itemBar'] as $idItem) {
		Item::associate($orgaBar->getId(), $idItem);
	}
}

if (isset($_POST['itemOrgaSave'])) {
	$sth = $GLOBALS['DB']->prepare('DELETE FROM inventory WHERE id_player=:id_player ;');
	$sth->bindValue(':id_player', $orgaOrga->getId(), PDO::PARAM_INT);
	$sth->execute();
	foreach ($_POST['itemOrga'] as $idItem) {
		Item::associate($orgaOrga->getId(), $idItem);
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: admin</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<style type="text/css">
.int {
	width: 20px;
}
</style>
</head>
<body>
	<h1>admin congress: <?= $congress->getNom() ?></h1>

	<form action="adminCongress.php?id_congress=<?= $congress->getId() ?>" method="post">
		item dans la cuisine:
		<br />
		<select name="itemCuisine[]" multiple="multiple" size="10">
		<?php 
			$sth = $GLOBALS['DB']->query('SELECT * FROM item WHERE item_type = "food" OR item_type = "drink";');
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			while ($sth && ($arr = $sth->fetch())) {
				$item = new Item();
				$item->populate($arr);
				?>
				<option value="<?= $item->getId() ?>"><?= $item->getNom()?></option>
		<?php } ?>
		</select>
		<br />
		<input type="submit" name="itemCuisineSave" value="save" />
	</form>
	
	<form action="adminCongress.php?id_congress=<?= $congress->getId() ?>" method="post">
		item dans la bar:
		<br />
		<select name="itemBar[]" multiple="multiple" size="10">
		<?php 
			$sth = $GLOBALS['DB']->query('SELECT * FROM item WHERE item_type = "alcohol" OR item_type = "drink";');
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			while ($sth && ($arr = $sth->fetch())) {
				$item = new Item();
				$item->populate($arr);
				?>
				<option value="<?= $item->getId() ?>"><?= $item->getNom()?></option>
		<?php } ?>
		</select>
		<br />
		<input type="submit" name="itemBarSave" value="save" />
	</form>
		
	<form action="adminCongress.php?id_congress=<?= $congress->getId() ?>" method="post">
		item dans le coin des Orgas:
		<br />
		<select name="itemOrga[]" multiple="multiple" size="10">
		<?php 
			$sth = $GLOBALS['DB']->query('SELECT * FROM item WHERE item_type = "badge" OR item_type = "pins" OR item_type = "food" OR item_type = "alcohol" OR item_type = "drink";');
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			while ($sth && ($arr = $sth->fetch())) {
				$item = new Item();
				$item->populate($arr);
				?>
				<option value="<?= $item->getId() ?>"><?= $item->getNom()?></option>
		<?php } ?>
		</select>
		<br />
		<input type="submit" name="itemOrgaSave" value="save" />
	</form>
	
</body>
</html>

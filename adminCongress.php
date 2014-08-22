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
if ($_REQUEST['id_congress'] == -1) {
	$congress = new Congress();
	$congress->defaultValues();
	$congress->setNom('NEW CONGRESS');
	$congress->save();
} else {
	$congress = Congress::load($_REQUEST['id_congress']);
}

if (isset($_REQUEST['saveCongress'])) {
	foreach ($_POST as $key => $value) {
		if (($key != 'id') && ($key != 'saveCongress')) {
			if ($value == 'NULL') {
				$value = null;
			}
			$method = 'set' . ucfirst($key);
			echo $key . '=' . $value . ' ';
			$congress->$method($value);
		}
	}
	$congress->save();
}



function createOrga($lieu, $sex, $id_congress) {
	$orga = new Player();
	$orga->defaultValues();
	$orga->setNom($lieu);
	$orga->setLieu($lieu);
	$orga->setSex($sex);
	$orga->setPhoto($sex ? 'images/tete_faluche_bleu.jpg' : 'images/tete_faluche_rose.jpg');
	$orga->setPnj(2);
	$orga->setId_congress($id_congress);
	$orga->save();
	return $orga;
}

$orgaOrga = Player::loadOrga('orga', $congress->getId());
if (!$orgaOrga) {
	$orgaOrga = createOrga('orga', 1, $congress->getId());
}
$orgaBar = Player::loadOrga('bar', $congress->getId());
if (!$orgaBar) {
	$orgaBar = createOrga('bar', 1, $congress->getId());
}
$orgaCuisine = Player::loadOrga('cuisine', $congress->getId());
if (!$orgaCuisine) {
	$orgaCuisine = createOrga('cuisine', 0, $congress->getId());
}
$orgaCamping = Player::loadOrga('camping', $congress->getId());
if (!$orgaCamping) {
	$orgaCamping = createOrga('camping', 0, $congress->getId());
}

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

if (isset($_POST['itemCampingSave'])) {
	$sth = $GLOBALS['DB']->prepare('DELETE FROM inventory WHERE id_player=:id_player ;');
	$sth->bindValue(':id_player', $orgaCamping->getId(), PDO::PARAM_INT);
	$sth->execute();
	foreach ($_POST['itemCamping'] as $idItem) {
		Item::associate($orgaCamping->getId(), $idItem);
	}
}

$levelList = array("moldu" => "moldu", "impétrent" => "impétrent", "faluché" => "faluché", "ancien" => "ancien");

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
</head>
<body>
	<h1>admin congress: <?= $congress->getNom() ?></h1>
	<a href="admin.php">retour à la page admin.</a>
	<form action="adminCongress.php?id_congress=<?= $congress->getId() ?>" method="post">
		<table>
			<tr>
				<th>Nom</th>
				<td>
					<input type="text" name="nom" id="nom" value="<?= $congress->getNom() ?>" />
				</td>
			</tr>
			<tr>
				<th>Action number</th>
				<td>
					<input type="text" name="action_number" id="action_number" value="<?= $congress->getAction_number() ?>" />
				</td>
			</tr>
			<tr>
				<th>Bot number</th>
				<td>
					<input type="text" name="bot_number" id="bot_number" value="<?= $congress->getBot_number() ?>" />
				</td>
			</tr>
			<tr>
				<th>Bot coef</th>
				<td>
					<input type="text" name="bot_coef" id="bot_coef" value="<?= $congress->getBot_coef() ?>" />
				</td>
			</tr>
			<tr>
				<th>Level</th>
				<td>
					<select name="level">
					<?php foreach ($levelList as $levelValue => $levelText) { ?>
						<option value="<?= $levelValue ?>" <?= $congress->getLevel()==$levelValue?'selected="selected"':''?>><?= $levelText ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Budget</th>
				<td>
					<input type="text" name="budget" id="budget" value="<?= $congress->getBudget() ?>" />
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" name="saveCongress" id="saveCongress" value="save" />
				</td>
			</tr>
		</table>
	</form>

	<form action="adminCongress.php?id_congress=<?= $congress->getId() ?>" method="post">
		item dans la cuisine: <br />
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
		item dans la bar: <br />
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
		item dans le coin des Orgas: <br />
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

	<form action="adminCongress.php?id_congress=<?= $congress->getId() ?>" method="post">
		item dans le welcome pack: <br />
		<select name="itemCamping[]" multiple="multiple" size="10">
		<?php
		$sth = $GLOBALS['DB']->query('SELECT * FROM item WHERE item_type IN ("badge", "pins", "food", "alcohol", "drink");');
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		while ($sth && ($arr = $sth->fetch())) {
			$item = new Item();
			$item->populate($arr);
			?>
				<option value="<?= $item->getId() ?>"><?= $item->getNom()?></option>
		<?php } ?>
		</select>
		<br />
		<input type="submit" name="itemCampingSave" value="save" />
	</form>

</body>
</html>

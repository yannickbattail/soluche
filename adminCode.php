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

if (isset($_REQUEST['create'])) {
	for ($i = 0; $i < $_REQUEST['number']; $i++) {
		$random = rand(100000, 999999);
		while (Code::loadByNumber($random)) {
			$random = rand(100000, 999999);
		}
		$code = new Code();
		$code->defaultValues();
		$code->setNumber($random);
		$code->setId_item($_REQUEST['id_item']);
		$code->save();
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/ui-darkness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/ui-darkness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
	<h1>admin code</h1>
	<a href="admin.php">retour à la page admin.</a>
	<br />
	<a href="adminCodeShow.php?id_min=0&id_max=999999">list codes</a>
	<?php $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['CONTEXT_PREFIX'].'/code.php?n=0'; ?>
	<form action="" method="post">
		<table>
			<tr>
				<th>number</th>
				<td>
					<input type="text" name="number" id="number" value="" />
				</td>
			</tr>
			<tr>
				<th>item</th>
				<td>
					<select name="id_item">
					<?php
					$sth = $GLOBALS['DB']->query('SELECT * FROM item WHERE item_type != "test" ORDER BY nom;');
					$sth->setFetchMode(PDO::FETCH_ASSOC);
					while ($sth && ($arr = $sth->fetch())) {
						$item = new Item();
						$item->populate($arr);
						?>
						<option value="<?= $item->getId() ?>"><?= $item->getNom() ?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" name="create" id="create" value="create" />
				</td>
			</tr>
		</table>
	</form>
</body>
</html>

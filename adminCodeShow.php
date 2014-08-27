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

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: admin codes</title>

</head>
<body>
	<?php 
	$urlPrefix = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['CONTEXT_PREFIX'].'/code.php?n=';
	
	$n = 0;
	$sth = $GLOBALS['DB']->prepare('SELECT * FROM code LEFT JOIN item ON id_item = item.id WHERE id_player IS NULL AND code.id >= :min AND code.id < :max ORDER BY code.id;');
	$sth->bindValue(':min', $_GET['id_min'], PDO::PARAM_INT);
	$sth->bindValue(':max', $_GET['id_max'], PDO::PARAM_INT);
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	$sth->execute();
	while ($sth && ($arr = $sth->fetch())) {
		$code = new Code();
		$code->populate($arr);
		$item = new Item();
		$item->populate($arr);
		$url = $urlPrefix.$code->getNumber();
		?>
		<table style="border-style: dotted; border-width: 1px; margin: 10px; display: inline-block;">
			<tr>
				<td><?= $item->htmlImage() ?><br /><?= $item->getNom() ?></td>
				<td><img alt="rqcode" src="http://zxing.org/w/chart?cht=qr&chs=120x120&chld=L&choe=UTF-8&chl=<?= urlencode($url) ?>"></td>
			</tr>
			<tr>
				<td colspan="2" style="font-size: 10px;"><?= $url ?></td>
			</tr>
		</table>
	<?php } ?>
</body>
</html>

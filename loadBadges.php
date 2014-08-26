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

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>loadBadges</title>
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
	<h1>loadBadges</h1>

<?php
if (isset($_POST['go'])) {
	foreach (new DirectoryIterator('images/items/') as $key => $file) {
		if (!$file->isDot()) {
			$fileName = 'images/items/' . $file->getBasename();
			echo $fileName ;
			$sth = $GLOBALS['DB']->prepare('SELECT * FROM item WHERE image = :image;');
			$sth->bindValue(':image', $fileName, PDO::PARAM_STR);
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			if ($sth->execute() === false) {
				// var_dump($sth->errorInfo());
				return false;
			}
			if (!$sth->fetch()) {
				$item = new Item();
				$item->setInternal_name(str_replace(array(' ', "'"), '_', $file->getBasename()));
				$item->setNom($file->getBasename());
				$item->setDescription($file->getBasename());
				$item->setPermanent(1);
				$item->setImage($fileName);
				$item->setItem_type('test');
				//$item->save();
				echo '<img src="' . $fileName . '"  />';
			}
		}
	}
}

?>
				<form action="" method="post">
		<input type="submit" name="go" value="go" />
	</form>


</body>
</html>

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
	foreach (new DirectoryIterator('images/insignes/') as $key => $file) {
		if (!$file->isDot()) {
			$newName = strtolower($file->getBasename());
			copy('images/insignes/' . $file->getBasename(), 'images/badges/' . $newName);
			$item = new Item();
			$item->setNom($newName);
			$item->setPermanent(1);
			$item->setImage('images/badges/' . $newName);
			$item->setItem_type('test');
			$item->save();
			Item::associate(1, $item->getId());
			echo 'images/insignes/' . $file->getBasename() . ' =&gt; images/badges/' . $newName . '<br />';
		}
	}
}

?>
				<form action="" method="post">
		<input type="submit" name="go" value="go" />
	</form>


</body>
</html>

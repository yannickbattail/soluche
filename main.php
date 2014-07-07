<?php
require_once ('init.php');

$_SESSION['user']->lieu = 'camping';

$_SESSION['user']->save();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: camping</title>
<style type="text/css">
.stats th {
	color: silver;
	text-align: left;
	padding: 2px 6px;
}

.inventory th {
	color: silver;
	text-align: left;
	padding: 2px 6px;
}

.inventory td {
	color: silver;
	text-align: center;
	padding: 3px 6px;
}

tr.odd {
	background: #404040;
}

tr.even {
	background: #252525;
}
</style>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
</head>
<body>
	<h1>camping</h1>
	<?php echo logoutBar(); ?>
	</div>
	<div class="errorMessage"><?php echo $errorMessage; ?></div>
	Se deplacer:
	<ul>
		<li><a href="bar.php">au bar</a></li>
		<li><a href="pls.php?action=startPLS">se mettre en PLS</a></li>
		<li><a href="tente.php">à ta tente</a></li>
		<li><a href="cuisine.php">à la cuisine</a></li>
		<li><a href="danse.php">à la piste de danse</a></li>
	</ul>
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

<a href="?action=vt">faire un VT.</a>

</body>
</html>

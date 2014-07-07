<?php
require_once ('init.php');

$_SESSION['user']->lieu = 'pls';

$actionMessage = '';
if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'endPLS')) {
	$a = new Action($_SESSION['user']);
	$actionMessage = $a->endPLS();
	if ($actionMessage !== false) {
		$_SESSION['user']->save();
		header('Location: main.php');
		$actionMessage .= "Location: main.php";
	}
}

$_SESSION['user']->save();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: salle des cadavres</title>
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
	<h1>salle des cadavres</h1>
	Vous etes en salle des cadavres pour un bonne PLS. Il faut attendre que ca redescende 60s.
	<div class="errorMessage"><?php echo $errorMessage; ?></div>
	<?php if ($actionMessage) { ?><div class="actionMessage"><?php echo $actionMessage; ?></div><?php } ?>
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

<?php if (Action::isPlsFinished($_SESSION['user'])) { ?>
	<a href="?action=endPLS">finir sa PLS. retour au camping</a>
<?php } ?>

</body>
</html>

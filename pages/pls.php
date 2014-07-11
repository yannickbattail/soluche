<?php
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

?>

<h1>salle des cadavres</h1>
Vous etes en salle des cadavres pour un bonne PLS. Il faut attendre que ca redescende 60s.
<div class="errorMessage"><?php echo $errorMessage; ?></div>
<?php if ($actionMessage) { ?><div class="actionMessage"><?php echo $actionMessage; ?></div><?php } ?>
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

<?php if (Action::isPlsFinished($_SESSION['user'])) { ?>
<a href="main.php?page=pls?action=endPLS" class="action">finir sa PLS. retour au camping</a>
<?php } ?>


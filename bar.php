<?php
require_once ('init.php');

$_SESSION['user']->lieu = 'bar';

$actionMessage = '';

if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'duel')) {
	$opponent = Player::load($_REQUEST['playerId'])->loadInventory();
	$a = new Action($_SESSION['user']);
	$ret = $a->duel($opponent);
	$actionMessage = $ret['actionMessage'];
}

$_SESSION['user']->save();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: Bar</title>
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
	<h1>Bar</h1>
	<?php echo logoutBar(); ?>
	<div class="errorMessage"><?php echo $errorMessage; ?></div>
	<?php if ($actionMessage) { ?><div class="actionMessage"><?php echo $actionMessage; ?></div><?php } ?>

	<table class="inventory">
		<tr>
			<th>nom</th>
			<th>Points</th>
			<th>Notoriété</th>
			<th>Alcoolémie</th>
			<th>Fatigue</th>
			<!-- <th>sex_appeal</th> -->
			<th>Duel</th>
			<th>Pinser</th>
		</tr>
	<?php
	
	$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE lieu = "bar" AND id != ' . $_SESSION['user']->id . ' ;');
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Objet');
	$n = 0;
	while ($stmt && ($player = $stmt->fetch())) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
        <tr class="<?= $odd ?>">
			<td><?=$player->nom; ?></td>
			<td><?=$player->points; ?></td>
			<td><?=$player->notoriete; ?></td>
			<td><?= lifeBarMiddle($player->alcoolemie_max, $player->alcoolemie_optimum, $player->alcoolemie); ?>
			<?=$player->alcoolemie.'/'.$player->alcoolemie_max.' optimum à '.$player->alcoolemie_optimum; ?></td>
			<td><?=lifeBar($player->fatigue_max, $player->fatigue).$player->fatigue.'/'.$player->fatigue_max; ?></td>
			<!-- <td><?=$player->sex_appeal; ?></td> -->
			<td>
				<a href="?action=duel&playerId=<?=$player->id; ?>">duel</a>
			</td>
			<td>
				<a href="?action=pins&playerId=<?=$player->id; ?>">pin's</a>
			</td>
		</tr>
        <?php
	}
	?>
</table>
	<a href="main.php">retour au camping</a>
</body>
</html>

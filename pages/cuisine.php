

<h3>Repas, au menu:</h3>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Manger</th>
		<th>Fatigue</th>
	</tr>
<?php
$sth = $GLOBALS['DB']->query('SELECT O.* FROM objet O INNER JOIN inventory I ON I.idobject = O.id WHERE I.idplayer = -1 AND permanent = 0;');
$sth->setFetchMode(PDO::FETCH_CLASS, 'Objet');
$n = 0;
while ($sth && ($objet = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $objet->image; ?>" class="inventoryImage" title="<?= $objet->nom; ?>" />
		</td>
		<td><?= (new Eat($_SESSION['user']))->setParams(array(Eat::PARAM_NAME=>$objet))->link() ?></td>
		<td><?= plus($objet->fatigue, 0); ?></td>
	</tr>
        <?php
}
?>
</table>

<h3>personnes dans la cuisine</h3>
<table class="inventory">
	<tr>
		<th>Photo</th>
		<th>nom</th>
		<th>Points</th>
		<th>Notoriété</th>
		<th>Verre</th>
		<th>Fatigue</th>
		<!-- <th>sex_appeal</th> -->
		<th>Pinser</th>
	</tr>
	<?php
	$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE lieu = "cuisine" AND id != ' . $_SESSION['user']->id . ' ;');
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Objet');
	$n = 0;
	while ($stmt && ($player = $stmt->fetch())) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
        <tr class="<?= $odd ?>">
		<td>
			<img src="<?= $player->photo; ?>" class="playerImage" title="<?= $player->nom; ?>" />
		</td>
		<td><?=$player->nom; ?> <?php echo $player->sex?'<span style="color:blue">&#9794;</span>':'<span style="color:pink">&#9792;</span>'; ?></td>

		<td><?=$player->points; ?></td>
		<td><?=$player->notoriete; ?></td>
		<td><?= lifeBarMiddle($player->alcoolemie_max, $player->alcoolemie_optimum, $player->alcoolemie); ?>
			<?=$player->alcoolemie.'/'.$player->alcoolemie_max.' optimum à '.$player->alcoolemie_optimum; ?></td>
		<td><?=lifeBar($player->fatigue_max, $player->fatigue).$player->fatigue.'/'.$player->fatigue_max; ?></td>
		<!-- <td><?=$player->sex_appeal; ?></td> -->
		<td>
			<?=(new Pins($_SESSION['user']))->setParams(array(Pins::PARAM_NAME=>$player))->link('bar')?>
		</td>
	</tr>
        <?php
	}
	?>
</table>

<a href="main.php?page=camping">retour au camping</a>

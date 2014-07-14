
<table class="inventory">
	<tr>
		<th>nom</th>
		<th>Points</th>
		<th>Notoriété</th>
		<th>Alcoolémie</th>
		<th>Fatigue</th>
		<!-- <th>sex_appeal</th> -->
		<th>défis au bar</th>
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
			<?=linkAction('duel', array('playerId'=>$player->id), 'défis au bar', 'bar')?>
		</td>
		<td>
			<?=linkAction('pins', array('playerId'=>$player->id), 'pin\'s', 'bar')?>
		</td>
	</tr>
        <?php
	}
	?>
</table>
<a href="main.php?page=camping">retour au camping</a>


<table class="inventory">
	<tr>
		<th>Photo</th>
		<th>nom</th>
		<th>Points</th>
		<th>Notoriété</th>
		<th>Verre</th>
		<th>Fatigue</th>
		<!-- <th>sex_appeal</th> -->
		<th>Choper</th>
		<th>Pinser</th>
	</tr>
	<?php
	$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE lieu = "danse" AND id != ' . $_SESSION['user']->id . ' ;');
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
			<?=linkAction('choper', array('playerId'=>$player->id), 'essayer de choper', 'danse')?>
		</td>
		<td>
			<?=linkAction('pins', array('playerId'=>$player->id), 'pin\'s', 'danse')?>
		</td>
	</tr>
        <?php
	}
	?>
</table>
<a href="main.php?page=camping">retour au camping</a>

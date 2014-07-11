<?php

function logoutBar() {
	return '<div class="login">' . $_SESSION['user']->nom . ' <a href="login.php?logout=1"> quitter</a></div>';
}

function printUserStats(Player $player) {
	?>
<table class="stats">
	<tr class="even">
		<th>Nom</th>
		<td><?=$player->nom; ?></td>
		<td>Points: <?=$player->points; ?></td>
	</tr>
	<tr class="odd">
		<th></th>
		<th>Sans inventaire</th>
		<th>Avec inventaire</th>
	</tr>
	<tr class="even">
		<th>Notoriété</th>
		<td><?=$player->notoriete; ?></td>
		<td><?=$player->getCalculatedNotoriete(); ?></td>
	</tr>
	<tr class="odd">
		<th>Alcoolémie</th>
		<td><?= lifeBarMiddle($player->alcoolemie_max, $player->alcoolemie_optimum, $player->alcoolemie); ?>
		<?=$player->alcoolemie.'/'.$player->alcoolemie_max.' optimum à '.$player->alcoolemie_optimum; ?></td>
		<td><?= lifeBarMiddle($player->getCalculatedAlcoolemie_max(), $player->getCalculatedAlcoolemie_optimum(), $player->getCalculatedAlcoolemie())?>
		<?=$player->getCalculatedAlcoolemie().'/'.$player->getCalculatedAlcoolemie_max().' optimum à '.$player->getCalculatedAlcoolemie_optimum(); ?></td>
	</tr>
	<tr class="even">
		<th>Fatigue</th>
		<td><?=lifeBar($player->fatigue_max, $player->fatigue).$player->fatigue.'/'.$player->fatigue_max; ?></td>
		<td><?=lifeBar($player->getCalculatedFatigue_max(), $player->getCalculatedFatigue()).$player->getCalculatedFatigue().'/'.$player->getCalculatedFatigue_max(); ?></td>
	</tr>
	<tr class="odd">
		<th>sex_appeal</th>
		<td><?=$player->sex_appeal; ?></td>
		<td><?=$player->getCalculatedSex_appeal(); ?></td>
	</tr>
</table>
<?php
}

function lifeBarMiddle($max, $middle, $value) {
	$ret = '<table class="lifeBarMiddle"><tr>';
	$css = 'lifeBarMiddle_middle';
	for ($i = 1; $i <= $max; $i++) {
		if ($i < $middle) {
			$css = 'lifeBarMiddle_before';
		} else if ($i > $middle) {
			$css = 'lifeBarMiddle_after';
		} else if ($i == $middle) {
			$css = 'lifeBarMiddle_middle';
		}
		if ($i == $value) {
			$css .= ' lifeBarMiddle_value';
		}
		$ret .= '<td class="' . $css . '"></td>';
	}
	
	$ret .= '</tr></table>';
	return $ret;
}

function lifeBar($max, $value) {
	$ret = '<table class="lifeBar"><tr>';
	$css = 'lifeBar_after';
	for ($i = 1; $i <= $max; $i++) {
		if ($i <= $value) {
			$css = 'lifeBar_before';
		} else {
			$css = 'lifeBar_after';
		}
		$ret .= '<td class="' . $css . '"></td>';
	}
	
	$ret .= '</tr></table>';
	return $ret;
}

function printInventory(Player $player) {
	?>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Permanant</th>
		<th>Notoriété</th>
		<th>Alcoolémie</th>
		<th>Alcoolémie optimum</th>
		<th>Alcoolémie max</th>
		<th>Fatigue</th>
		<th>Fatigue max</th>
		<th>Sexe appeal</th>
	</tr>
<?php
	$n = 0;
	foreach ($player->inventory as $objet) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $objet->image; ?>" class="inventoryImage" />
			<br /><?= $objet->nom; ?></td>
		<td><?= $objet->permanent?'oui':'<a href="main.php?action=UseObjet&objetId='.$objet->id.'" class="action">utiliser</a>'; ?></td>
		<td><?= plus($objet->notoriete, 1); ?></td>
		<td><?= plus($objet->alcoolemie, 0); ?></td>
		<td><?= plus($objet->alcoolemie_optimum, 1); ?></td>
		<td><?= plus($objet->alcoolemie_max, 1); ?></td>
		<td><?= plus($objet->fatigue, 0); ?></td>
		<td><?= plus($objet->fatigue_max, 1); ?></td>
		<td><?= plus($objet->sex_appeal, 1); ?></td>
	</tr>
        <?php
	}
	?>
</table>
<?php
}

function plus($nb, $better) {
	if ($nb > 0 && $better) {
		$nb = '<span style="color: chartreuse;">+' . $nb . '</div>';
	} else if ($nb > 0 && !$better) {
		$nb = '<span style="color: red;">+' . $nb . '</div>';
	} else if ($nb < 0 && !$better) {
		$nb = '<span style="color: chartreuse;">' . $nb . '</div>';
	} else if ($nb < 0 && $better) {
		$nb = '<span style="color: red;">' . $nb . '</div>';
	} else {
		$nb = '<span style="">+' . $nb . '</div>';
	}
	return $nb;
}
<?php

function logoutBar() {
	return '<div class="login">' . $_SESSION['user']->nom . ' <a href="userCutomisation.php">edit</a> <a href="login.php?logout=1">quitter</a></div>';
}

/**
 *
 * @deprecated use ActionInterface::link()
 * @param string $action        	
 * @param array $actionParams        	
 * @param string $text        	
 * @param string|NULL $page        	
 * @param bool|NULL $forceEnable        	
 * @return string
 */
function linkAction($action, array $actionParams, $text, $page = null, $forceEnable = null) {
	trigger_error("linkAction() is deprecated use ActionInterface::link()", E_USER_DEPRECATED);
	$url = 'main.php?action=' . urldecode($action);
	if ($page) {
		$url .= '&page=' . urldecode($page);
	}
	foreach ($actionParams as $pKey => $pVal) {
		$url .= '&' . urldecode($pKey) . '=' . urldecode($pVal);
	}
	$enable = true;
	
	if ($forceEnable === true) {
		$enable = true;
	} else if ($forceEnable === true) {
		$enable = false;
	} else {
		$enable = !$_SESSION['user']->isFatigued();
	}
	if ($enable) {
		return '<a href="' . $url . '"  class="action" title="' . $action . '">' . $text . '</a>';
	} else {
		return '<span  class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
	}
}

function printUserStats(Player $player) {
	?>
<table class="stats">
	<tr class="even">
		<th>Nom</th>
		<td>
			<img src="<?= $player->photo; ?>" class="playerImage" title="<?= $player->nom; ?>" />
		</td>
		<td><?=$player->nom; ?> <?php echo $player->sex?'<span style="color:blue">&#9794;</span>':'<span style="color:pink">&#9792;</span>'; ?>
		<br />Points: <?=$player->points; ?></td>
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
		<th>Verre</th>
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
		<th>Sexe appeal</th>
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
		<th>Verre</th>
		<th>Verre optimum</th>
		<th>Verre max</th>
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
			<img src="<?= $objet->image; ?>" class="inventoryImage" title="<?= $objet->nom; ?>" />
		</td>
		<td><?= $objet->permanent?'oui':(new UseObjet($_SESSION['user']))->setParams(array(UseObjet::PARAM_NAME=>$objet))->link() ?></td>
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

function printInventory2(Player $player) {
	?>
	Inventaire:
<div class="inventoryBox">

<?php
	$num = 0;
	foreach ($player->inventory as $objet) {
		printObjet($objet, $num);
		$num++;
	}
	?>
</div>
<?php
}

function printObjet(Objet $objet, $num = 0) {
	?>
<div class="objetCard" id="objet_<?= $objet->id.'_'.$num; ?>">
	<img src="<?= $objet->image; ?>" class="inventoryImage" title="<?= $objet->nom; ?>" />

</div>
<div id="objet_<?= $objet->id.'_'.$num ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<th>Nom</th>
			<td><?= $objet->nom; ?></td>
		</tr>
		<tr class="even">
			<th>Permanant</th>
			<td><?= $objet->permanent?'oui':'non' ?></td>
		</tr>
		<tr class="odd">
			<th>Notoriété</th>
			<td><?= plus($objet->notoriete, 1); ?></td>
		</tr>
		<tr class="even">
			<th>Verre</th>
			<td><?= plus($objet->alcoolemie, 0); ?></td>
		</tr>
		<tr class="odd">
			<th>Verre optimum</th>
			<td><?= plus($objet->alcoolemie_optimum, 1); ?></td>
		</tr>
		<tr class="even">
			<th>Verre max</th>
			<td><?= plus($objet->alcoolemie_max, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>Fatigue</th>
			<td><?= plus($objet->fatigue, 0); ?></td>
		</tr>
		<tr class="even">
			<th>Fatigue max</th>
			<td><?= plus($objet->fatigue_max, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>Sexe appeal</th>
			<td><?= plus($objet->sex_appeal, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>Utiliser</th>
			<td><?= $objet->permanent?'oui':(new UseObjet($_SESSION['user']))->setParams(array(UseObjet::PARAM_NAME=>$objet))->link()?></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$("#objet_<?= $objet->id.'_'.$num; ?>").tooltip({
		"content": $("#objet_<?= $objet->id.'_'.$num; ?>_tooltip").html(), 
    	"hide": { "delay": 1000, "duration": 500 }
     });
</script>
<?php
}

function printPlayerBox(PDOStatement $stmt, array $actions) {
	?>
<div class="playerBox">

<?php
	$num = 0;
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
	while ($stmt && ($player = $stmt->fetch())) {
		printPlayer($player, $num, $actions);
		$num++;
	}
	?>
</div>
<?php
}

function printPlayer(Player $player, $num = 0, array $actions) {
	?>
<div class="playerCard" id="player_<?= $player->id.'_'.$num; ?>">
	<img src="<?= $player->getPhoto() ?>" class="inventoryImage" title="<?= $player->getNom() ?>" />
</div>
<table class="playerTooltip" id="player_<?= $player->getId().'_'.$num ?>_tooltip" style="display: none;">
	<tr class="odd">
		<th>Nom</th>
		<td><?= $player->getNom(); ?> <?php echo $player->getSex()?'<span style="color:blue">&#9794;</span>':'<span style="color:pink">&#9792;</span>'; ?></td>
	</tr>
	<tr class="even">
		<th>Points</th>
		<td><?=$player->getPoints(); ?></td>
	</tr>
	<tr class="odd">
		<th>Notoriété</th>
		<td><?=$player->getNotoriete(); ?></td>
	</tr>
	<tr class="even">
		<th>Verre</th>
		<td><?= lifeBarMiddle($player->getAlcoolemie_max(), $player->getAlcoolemie_optimum(), $player->getAlcoolemie()); ?> <?=$player->getAlcoolemie().'/'.$player->getAlcoolemie_max().' optimum à '.$player->getAlcoolemie_optimum(); ?></td>
	</tr>
	<tr class="odd">
		<th>Fatigue</th>
		<td><?=lifeBar($player->getFatigue_max(), $player->getFatigue()).$player->getFatigue().'/'.$player->getFatigue_max(); ?></td>
	</tr>
	<!--
	<tr class="odd">
		<th>sex_appeal</th>
		<td><?=$player->getSex_appeal(); ?></td>
	</tr>
	-->
	<?php
	
$n = 0;
	foreach ($actions as $actionText => $act) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?>">
		<th><?= $actionText ?></th>
		<td><?=$act->setParams(array(Pins::PARAM_NAME=>$player))->link()?></td>
	</tr>
	<?php } ?>
</table>
<script type="text/javascript">
	$("#player_<?= $player->getId().'_'.$num; ?>").tooltip({
		"content": $("#player_<?= $player->getId().'_'.$num; ?>_tooltip").html(), 
    	"hide": { "delay": 1000, "duration": 500 }
     });
</script>
<?php
}

function plus($nb, $better) {
	if ($nb > 0 && $better) {
		$nb = '<span style="color: chartreuse;">+' . $nb . '</span>';
	} else if ($nb > 0 && !$better) {
		$nb = '<span style="color: red;">+' . $nb . '</span>';
	} else if ($nb < 0 && !$better) {
		$nb = '<span style="color: chartreuse;">' . $nb . '</span>';
	} else if ($nb < 0 && $better) {
		$nb = '<span style="color: red;">' . $nb . '</span>';
	} else {
		$nb = '<span style="">+' . $nb . '</span>';
	}
	return $nb;
}
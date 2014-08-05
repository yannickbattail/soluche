<?php

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
			<img src="<?= $player->getPhoto(); ?>" class="playerImage" title="<?= $player->getNom(); ?>" />
		</td>
		<td><?=$player->getNom(); ?> <?php echo $player->getSex()?'<span style="color:cyan">&#9794;</span>':'<span style="color:pink">&#9792;</span>'; ?>
		<br />Rêves vendus: <?=$player->getPoints(); ?></td>
	</tr>
	<tr class="odd">
		<th></th>
		<th>Sans inventaire</th>
		<th>Avec inventaire</th>
	</tr>
	<tr class="even">
		<th>Crédibidulité</th>
		<td><?=$player->getNotoriete(); ?></td>
		<td><?=$player->getCalculatedNotoriete(); ?></td>
	</tr>
	<tr class="odd">
		<th>Verres</th>
		<td><?= lifeBarMiddle($player->getAlcoolemie_max(), $player->getAlcoolemie_optimum(), $player->getAlcoolemie()); ?>
		<?=$player->getAlcoolemie().'/'.$player->getAlcoolemie_max().' optimum à '.$player->getAlcoolemie_optimum(); ?></td>
		<td><?= lifeBarMiddle($player->getCalculatedAlcoolemie_max(), $player->getCalculatedAlcoolemie_optimum(), $player->getCalculatedAlcoolemie())?>
		<?=$player->getCalculatedAlcoolemie().'/'.$player->getCalculatedAlcoolemie_max().' optimum à '.$player->getCalculatedAlcoolemie_optimum(); ?></td>
	</tr>
	<tr class="even">
		<th>Fatigue</th>
		<td><?=lifeBar($player->getFatigue_max(), $player->getFatigue()).$player->getFatigue().'/'.$player->getFatigue_max(); ?></td>
		<td><?=lifeBar($player->getCalculatedFatigue_max(), $player->getCalculatedFatigue()).$player->getCalculatedFatigue().'/'.$player->getCalculatedFatigue_max(); ?></td>
	</tr>
	<tr class="odd">
		<th>Sexe appeal</th>
		<td><?=$player->getSex_appeal(); ?></td>
		<td><?=$player->getCalculatedSex_appeal(); ?></td>
	</tr>
	<tr class="even">
		<th>Dignichose</th>
		<td colspan="2"><?= moneyDisplay($player->getMoney()) ?><div style="font-size: 10px;">(<?= $player->getMoney() ?>)</div>
		</td>
	</tr>
</table>
<?php
}

function moneyDisplay($money) {
	$ret = '';
	for ($i = 0; $i < $money % 5; $i++) {
		$ret = '<img src="images/util/etoile argent petite.png" width="32" height="32" title="1" alt="1"> ' . $ret;
	}
	$money = floor($money / 5);
	for ($i = 0; $i < $money % 2; $i++) {
		$ret = '<img src="images/util/etoile or petite.png" width="32" height="32" title="5" alt="5"> ' . $ret;
	}
	$money = floor($money / 2);
	for ($i = 0; $i < $money % 5; $i++) {
		$ret = '<img src="images/util/etoile argent grande.png" width="32" height="32" title="10" alt="10"> ' . $ret;
	}
	$money = floor($money / 5);
	for ($i = 0; $i < $money % 2; $i++) {
		$ret = '<img src="images/util/etoile or grande.png" width="32" height="32" title="50" alt="50"> ' . $ret;
	}
	$money = floor($money / 2);
	for ($i = 0; $i < $money % 5; $i++) {
		$ret = '<img src="images/util/etoile argentee belge.png" width="32" height="32" title="100" alt="100"> ' . $ret;
	}
	$money = floor($money / 5);
	for ($i = 0; $i < $money % 2; $i++) {
		$ret = '<img src="images/util/etoile doree belge.png" width="32" height="32" title="500" alt="500"> ' . $ret;
	}
	return $ret;
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
	trigger_error("printInventory() is deprecated use ActionInterface::link()", E_USER_DEPRECATED);
	?>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Permanant</th>
		<th>Crédibidulité</th>
		<th>Verre</th>
		<th>Verre optimum</th>
		<th>Verre max</th>
		<th>Fatigue</th>
		<th>Fatigue max</th>
		<th>Sexe appeal</th>
	</tr>
<?php
	$n = 0;
	foreach ($player->inventory as $item) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->image; ?>" class="inventoryImage" title="<?= $item->nom; ?>" />
		</td>
		<td><?= $item->permanent?'oui':(new UseItem($_SESSION['user']))->setParams(array(UseItem::PARAM_NAME=>$item))->link() ?></td>
		<td><?= plus($item->notoriete, 1); ?></td>
		<td><?= plus($item->alcoolemie, 0); ?></td>
		<td><?= plus($item->alcoolemie_optimum, 1); ?></td>
		<td><?= plus($item->alcoolemie_max, 1); ?></td>
		<td><?= plus($item->fatigue, 0); ?></td>
		<td><?= plus($item->fatigue_max, 1); ?></td>
		<td><?= plus($item->sex_appeal, 1); ?></td>
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
	foreach ($player->inventory as $item) {
		printItem($item, $num);
		$num++;
	}
	?>
</div>
<?php
}

function printItem(Item $item, $num = 0) {
	?>
<div class="itemCard" id="item_<?= $item->id.'_'.$num; ?>">
	<img src="<?= $item->image; ?>" class="inventoryImage" title="<?= $item->nom; ?>" />

</div>
<div id="item_<?= $item->id.'_'.$num ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<th>Nom</th>
			<td><?= $item->getNom(); ?></td>
		</tr>
		<tr class="even">
			<th>Permanant</th>
			<td><?= $item->getPermanent()?'oui':'non' ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/emotes/face-raspberry.png" title="Crédibidulité" width="32" height="32">
				<br />Crédibidulité
			</th>
			<td><?= plus($item->getNotoriete(), 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope argent.png" title="Verres" width="32" height="32">
				<br />Verres
			</th>
			<td><?= plus($item->getAlcoolemie(), 0); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/chope or.png" title="Verres" width="32" height="32">
				<br />Verres optimum
			</th>
			<td><?= plus($item->getAlcoolemie_optimum(), 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope rouge.png" title="Verres" width="32" height="32">
				<br />Verres max
			</th>
			<td><?= plus($item->getAlcoolemie_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
				<br />Fatigue
			</th>
			<td><?= plus($item->getFatigue(), 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
				<br />Fatigue max
			</th>
			<td><?= plus($item->getFatigue_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sex appeal.png" title="Sexe appeal" width="32" height="32">
				<br />Sexe appeal
			</th>
			<td><?= plus($item->getSex_appeal(), 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
				<br />¼ H
			</th>
			<td><?= plus($item->getRemaining_time(), 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/items/pin-s-exigeons-la-dignité.png" alt="Coût en dignichose" width="32" height="32">
				<br /> Coût en dignichose
			</th>
			<td><?= plus($item->getPrice(), 1); ?> refiler pour <?= plus(floor(-$item->getPrice()*80/100), 1)?> -20% </td>
		</tr>
		<tr class="even">
			<th>Utiliser</th>
			<td><?= $item->getPermanent()?'oui':(new UseItem($_SESSION['user']))->setParams(array(UseItem::PARAM_NAME=>$item))->link()?></td>
		</tr>
		<tr class="odd">
			<th>Refilé</th>
			<td><?= (new Sell($_SESSION['user']))->setParams(array(Sell::PARAM_NAME=>$item))->link()?></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$("#item_<?= $item->id.'_'.$num; ?>").tooltip({
		"content": $("#item_<?= $item->id.'_'.$num; ?>_tooltip").html(), 
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
<!-- 
<div class="playerCard" id="player_<?= $player->id.'_'.$num; ?>">
	<img src="<?= $player->getPhoto() ?>" class="inventoryImage" title="<?= $player->getNom() ?>" />
</div>
 -->
<div id="player_<?= $player->getId().'_'.$num ?>_tooltip" style="display: inline-block;">
	<table class="playerCard">
		<tr class="odd">
			<th>
				<img src="<?= $player->getPhoto() ?>" class="inventoryImage" title="<?= $player->getNom() ?>" />
			</th>
			<td><?= $player->getNom(); ?> <?php echo $player->getSex()?'<span style="color:cyan">&#9794;</span>':'<span style="color:pink">&#9792;</span>'; ?></td>
		</tr>
		<tr class="even">
			<th>Rêves vendus</th>
			<td><?=$player->getPoints(); ?></td>
		</tr>
		<tr class="odd">
			<th>Crédibidulité</th>
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
</div>
<script type="text/javascript">
	/*
    $("#player_<?= $player->getId().'_'.$num; ?>").tooltip({
        "content": $("#player_<?= $player->getId().'_'.$num; ?>_tooltip").html(), 
        "hide": { "delay": 1000, "duration": 500 }
    });
    */
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
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
<h3>
	Caractéristiques: <a href="main.php?page=help#dicoItem"><img src="images/util/help.png" alt="aide" title="aide" style="width: 16px; height: 16px;"></a>
</h3>

<table class="playerStats">
	<tr class="odd">
		<th>
			<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
		</th>
		<td><?= $player->getPoints() ?> rêves
		<br />level: <?= $player->getLevel() ?></td>
	</tr>
	<tr class="even">
		<th>
			<img src="images/util/Dignichose.png" title="Dignichose (la monnaie)" alt="Dignichose">
		</th>
		<td><?= moneyDisplay($player->getMoney()) ?><div style="font-size: 10px;">(<?= $player->getMoney() ?>)</div>
		</td>
	</tr>
	<tr class="even">
		<th>
			<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
		</th>
		<td><?=$player->getCalculatedNotoriete(); ?></td>
	</tr>
	<tr class="odd">
		<th>
			<img src="images/util/chope or.png" title="Verres" alt="Verres">
		</th>
		<td><?= lifeBarMiddle($player->getCalculatedAlcoolemie_max(), $player->getCalculatedAlcoolemie_optimum(), $player->getCalculatedAlcoolemie())?>
		<?=$player->getCalculatedAlcoolemie().'/'.$player->getCalculatedAlcoolemie_max().' optimum à '.$player->getCalculatedAlcoolemie_optimum(); ?></td>
	</tr>
	<tr class="even">
		<th></th>
		<td>
			<?php if ($player->getCalculatedAlcoolemie() > $player->getAlcoolemie_optimum()) { ?>
				<img src="images/util/warning.png" alt="Attention" title="Attention" />
			Zone rouge, penser à faire un <a href="main.php?page=camping">VT</a>, une <a href="main.php?page=camping">PLS</a> ou <a href="main.php?page=tente">dodo</a>.
			<?php } ?>
			<?php if ($player->getCalculatedFatigue_max() == $player->getCalculatedFatigue()) { ?>
				<img src="images/util/warning.png" alt="Attention" title="Attention" />
			Crevé, penser à <a href="main.php?page=cuisine">manger</a> ou <a href="main.php?page=tente">dormir</a>.
			<?php } ?>
		</td>
	</tr>
	<tr class="even">
		<th>
			<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
		</th>
		<td><?=lifeBar($player->getCalculatedFatigue_max(), $player->getCalculatedFatigue()).$player->getCalculatedFatigue().'/'.$player->getCalculatedFatigue_max(); ?></td>
	</tr>
	<tr class="odd">
		<th>
			<img src="images/util/sex appeal.png" title="Sexe appeal" alt="Sexe appeal">
		</th>
		<td><?=$player->getCalculatedSex_appeal(); ?></td>
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
	$ret = '<div class="lifeBarMiddle2">';
	for ($i = 1; $i <= $max; $i++) {
		if ($i <= $value) {
			if ($i < $middle) {
				$ret .= '<img src="images/util/bier_green.png" title="ok" alt="ok" />';
			} else if ($i > $middle) {
				$ret .= '<img src="images/util/bier_red.png" title="Bourré" alt="Bourré" />';
			} else if ($i == $middle) {
				$ret .= '<img src="images/util/bier_orange.png" title="verre optimum" alt="verre optimum" />';
			}
		} else {
			$ret .= '<img src="images/util/bier_grey.png" title="verre vide" alt="verre vide" />';
		}
	}
	$ret .= '</div>';
	return $ret;
}

function lifeBarMiddle_old($max, $middle, $value) {
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

function printInventory_old(Player $player) {
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
	foreach ($player->getInventory() as $item) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" />
		</td>
		<td><?= $item->getPermanent()?'oui':(new UseItem($_SESSION['user']))->setParams(array(UseItem::PARAM_NAME=>$item))->link() ?></td>
		<td><?= plus($item->getNotoriete(), 1); ?></td>
		<td><?= plus($item->getAlcoolemie(), 0); ?></td>
		<td><?= plus($item->getAlcoolemie_optimum(), 1); ?></td>
		<td><?= plus($item->getAlcoolemie_max(), 1); ?></td>
		<td><?= plus($item->getFatigue(), 0); ?></td>
		<td><?= plus($item->getFatigue_max(), 1); ?></td>
		<td><?= plus($item->getSex_appeal(), 1); ?></td>
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
	foreach ($player->getInventory() as $item) {
		printItem($item, $num);
		$num++;
	}
	?>
</div>
<?php
}

function printItem(Item $item, $num = 0) {
	?>
<div class="itemCard" id="item_<?= $item->getId().'_'.$num; ?>">
	<img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" />

</div>
<div id="item_<?= $item->getId().'_'.$num ?>_tooltip" style="display: none;">
	<table class="inventory playerTooltip">
		<tr class="odd">
			<th>Item</th>
			<td><?= $item->getNom(); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/lock closed.png" title="Permanant" alt="Permanant">
			</th>
			<td><?= $item->getPermanent()?'oui':(new UseItem($_SESSION['user']))->setParams(array(UseItem::PARAM_NAME=>$item))->link()?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?= plus($item->getNotoriete(), 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope argent.png" title="Verres" alt="Verres">
			</th>
			<td><?= plus($item->getAlcoolemie(), 0); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/chope or.png" title="Verres optimum" alt="Verres optimum">
			</th>
			<td><?= plus($item->getAlcoolemie_optimum(), 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope rouge.png" title="Verres max" alt="Verres max">
			</th>
			<td><?= plus($item->getAlcoolemie_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus($item->getFatigue(), 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/fatigue max.png" title="Fatigue max" alt="Fatigue max">
			</th>
			<td><?= plus($item->getFatigue_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sex appeal.png" title="Sexe appeal" alt="Sexe appeal">
			</th>
			<td><?= plus($item->getSex_appeal(), 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus($item->getRemaining_time(), 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/Dignichose.png" title="Coût en dignichose" alt="Coût en dignichose">
			</th>
			<td><?= plus($item->getMoney(), 1); ?> refiler à <?= plus(floor(-$item->getMoney()*80/100), 1)?></td>
		</tr>
		<tr class="even">
			<td colspan="2"><?= (new Sell($_SESSION['user']))->setParams(array(Sell::PARAM_NAME=>$item))->link()?></td>
		</tr>
		<!-- 
		<tr class="even">
			<td colspan="2"><?= (new Sell($_SESSION['user']))->setParams(array(Sell::PARAM_NAME=>$item))->link()?></td>
		</tr>
		 -->
		<tr class="odd">
			<td colspan="2" style="max-width: 200px"><?= $item->getDescription(); ?></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$("#item_<?= $item->getId().'_'.$num; ?>").tooltip({
		"content": $("#item_<?= $item->getId().'_'.$num; ?>_tooltip").html(), 
    	"hide": { "delay": 1000, "duration": 500 }
     });
</script>
<?php
}

function printPlayerBox(PDOStatement $sth, array $actions) {
	?>
<div class="playerBox">

<?php
	$num = 0;
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	while ($sth && ($arr = $sth->fetch())) {
		$player = new Player();
		$player->populate($arr);
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
<div class="playerCard" id="player_<?= $player->getId().'_'.$num; ?>">
	<img src="<?= $player->getPhoto() ?>" class="inventoryImage" title="<?= $player->getNom() ?>" />
</div>
 -->
<div id="player_<?= $player->getId().'_'.$num ?>_tooltip" style="display: inline-block;">
	<table class="playerCard">
		<tr class="odd">
			<th></th>
			<td>
				<img src="<?= $player->getPhoto() ?>" class="playerImage" title="<?= $player->getNom() ?>" />
				<br /><?= $player->getNom(); ?> <?php echo $player->getSex()?'<span style="color:cyan" title="bite">&#9794;</span>':'<span style="color:pink" title="vagin">&#9792;</span>'; ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
			</th>
			<td><?=$player->getPoints(); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?=$player->getNotoriete(); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope rouge.png" title="Verres" alt="Verres">
			</th>
			<td><?= lifeBarMiddle($player->getAlcoolemie_max(), $player->getAlcoolemie_optimum(), $player->getAlcoolemie()); ?> <?=$player->getAlcoolemie().'/'.$player->getAlcoolemie_max().' optimum à '.$player->getAlcoolemie_optimum(); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?=lifeBar($player->getFatigue_max(), $player->getFatigue()).$player->getFatigue().'/'.$player->getFatigue_max(); ?></td>
		</tr>
		<!--
		<tr class="odd">
			<th>
				<img src="images/util/sex appeal.png" title="Sexe appeal" alt="Sexe appeal">
			</th>
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

function printChat(Player $player) {
	?>
<div id="contactsBox">
	<img src="images/loading.gif" alt="loading" title="loading" />
</div>
<div id="dialog" title="Chat box" style="display: none;">
	<div id="chatContent" style="overflow: scroll; height: 200px; width: 500px;">
		<img src="images/loading.gif" alt="loading" title="loading" />
	</div>
	<input type="text" name="chatMessage" id="chatMessage" value="" />
	<input type="hidden" name="id_player" id="id_player" value="" size="2" />
	<input type="button" name="SendMessage" value="envoyer" onclick="return sendMessage()" />
</div>
<script type="text/javascript">
	function showChat(id_player, player_name) {
	    $('#dialog').dialog({
		    'title': 'Chat avec ' + player_name,
	        'height':280,
	        'width':540,
	        'close': function( event, ui ) {$('#id_player').val('');}
	        });
	    $('#id_player').val(id_player);
	    $('#chatContent').html('<img src="images/loading.gif" alt="loading" title="loading" />');
	    $('#chatContent').load('chat.php?id_player='+id_player);
	}
	function refreshChat() {
		if ($('#id_player').val() != '') {
	    	$('#chatContent').load('chat.php?id_player='+$('#id_player').val());
		}
	}
	function sendMessage() {
		if ($('#chatMessage').val() != '') {
		    $('#chatContent').load('chat.php?id_player='+$('#id_player').val()+'&message='+encodeURIComponent($('#chatMessage').val()));
		    $('#chatMessage').val('');
		}
	}
	function refeshChatList() {
	    $('#contactsBox').load('chatList.php');
	}
	setTimeout(refeshChatList, 2*1000); // the 1st time;
	setInterval(refeshChatList, 10*1000);
	setInterval(refreshChat, 5*1000);
</script>
<?php
}

function printNotificationNumber() {
	?>
<div id="NotificationNumber" onclick="showNotification()" title="Notifications"></div>
<div id="NotificationDialog" title="Chat box" style="display: none;">
	<div id="NotificationContent" style="overflow: scroll; height: 200px; width: 500px;">
		<img src="images/loading.gif" alt="loading" title="loading" />
	</div>
</div>

<script type="text/javascript">
	function showNotification() {
	    $('#NotificationDialog').dialog({
		    'title': 'Notifications',
	        'height':280,
	        'width':540
	        });
	    $('#NotificationContent').html('<img src="images/loading.gif" alt="loading" title="loading" />');
	    $('#NotificationContent').load('notificationList.php');
	}
	
	function refreshNotificationNumber() {
    	$('#NotificationNumber').load('notificationNumber.php');
	}
	setTimeout(refreshNotificationNumber, 2*1000); // the 1st time;
	setInterval(refreshNotificationNumber, 5*1000);
</script>
<?php
}

function printChatGlobal() {
	?>
<div id="globalMessages">
	<img src="images/loading.gif" alt="loading" title="loading" />
</div>
<form action="main.php?action=SendGlobalMessage&prevent_reexecute=<?= $_SESSION['prevent_reexecute'] ?>" method="post"
	onsubmit="if (document.getElementById('message').value == ''){ return false;} else { return confirm('Envoyer un message global coute 1 en dignichose. Etes-vous sûr?');}">
	<input type="text" name="message" id="message" value="" />
	<input type="submit" name="SendGlobalMessage" value="message global" />
</form>
<script type="text/javascript">
	function refreshChatGlobal() {
    	$('#globalMessages').load('chatGlobal.php');
	}
	setTimeout(refreshChatGlobal, 2*1000); // the 1st time;
	setInterval(refreshChatGlobal, 5*1000);
</script>
<?php
}

function printNews() {
	?>
<div id="news">
	<img src="images/loading.gif" alt="loading" title="loading" />
</div>
<script type="text/javascript">
	function refreshNews() {
    	$('#news').load('news.php');
	}
	setTimeout(refreshNews, 2*1000); // the 1st time;
	setInterval(refreshNews, 20*1000);
</script>
<?php
}

function printTabsLieu() {
	if ($_SESSION['user']->getId_congress() != 0) {
		?>
<table class="tabBar">
	<tr>
		<td <?= (Dispatcher::getPage() == 'camping')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=camping">Camping</a>
		</td>
		<td <?= (Dispatcher::getPage() == 'orga')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=orga">Coin des orgas</a>
		</td>
		<td <?= (Dispatcher::getPage() == 'bar')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=bar">Bar</a>
		</td>
		<td <?= (Dispatcher::getPage() == 'tente')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=tente">Ta tente</a>
		</td>
		<td <?= (Dispatcher::getPage() == 'cuisine')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=cuisine">Cuisine</a>
		</td>
		<td <?= (Dispatcher::getPage() == 'danse')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=danse">Piste de danse</a>
		</td>
		<td <?= (Dispatcher::getPage() == 'help')?'class="tabBarSelected"':''  ?>>
			<a href="main.php?page=help"><img src="images/util/help.png" alt="aide" title="aide" style="width: 16px; height: 16px;"></a>
		</td>
	</tr>
</table>
<?php
	}
}



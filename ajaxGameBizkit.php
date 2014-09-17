<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */
$message = '';
if (!isset($_SESSION['game'])) {
	die('<script type="text/javascript">parent.location.replace("main.php");</script>');
}
$game = Game::load($_SESSION['game']);
if (!$game) {
	die('<script type="text/javascript">parent.location.replace("main.php");</script>');
}
$gameBizkit = new GameBizkit();
$gameBizkit->populate($game->getGame_data());
$gameBizkit->loadParticipants();
if (!in_array($_SESSION['user']->getId(), $gameBizkit->getParticipants())) {
	unset($_SESSION['game']);
	die('<script type="text/javascript">parent.location.replace("main.php");</script>');
}

if (isset($_REQUEST['quit'])) {
	$gameBizkit->quit($_SESSION['user']);
}
if (isset($_REQUEST['started'])) {
	$gameBizkit->started();
}
if (isset($_REQUEST['dice'])) {
	if (isset($_REQUEST['dice1']) && isset($_REQUEST['dice2'])) {
		// force dice value
		$gameBizkit->dice($_SESSION['user'], $_REQUEST['dice1'], $_REQUEST['dice2']);
	} else {
		$gameBizkit->dice($_SESSION['user']);
	}
}

$message .= $gameBizkit->getLastMessage();

if ($gameBizkit->getStarted() && (count($gameBizkit->getParticipants()) <= 1)) {
	if (isset(GameBizkit::$players[0])) {
		$gameBizkit->quit(GameBizkit::$players[0]);
	}
	$game->delete();
	die('<script type="text/javascript">parent.location.reload();</script>');
} else {
	$game->setGame_data($gameBizkit->export());
	$game->save();
}
$_SESSION['user']->save();

/* ------ html ------- */
//http://hotdog.metawiki.com/biskit
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: admin</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/ui-darkness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/ui-darkness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
	<div class="infoMessage"><?= $message ?></div>
	<br />
	<?php if (!$gameBizkit->getStarted()) { ?>
		La partie n'est pas encore lancée. Tu peux tracnarder des gents en cliquant sur <img title="traquenarder" alt="traquenarder" style="width: 24px; height: 24px;"
		src="images/items/panda.png">
	le panda dans la liste des faluchards à gauche.
	<br /> Quand il y aura au moins 2 participants, tu pourras
	<?php if (count(GameBizkit::$players) >= 2) { ?>
		<a href="?started=1" class="action">Lancer la partie</a>.
	<?php } else { ?>
		<span class="actionDisabled" title="Il n'y pas assez de participants">Lancer la partie</span>
	<?php } ?>
		
	<br />D'autre personnes pourront s'inscruster en cours de partie.
	<?php } else { ?>
		<?php if ($gameBizkit->getTour() == $_SESSION['user']->getId()) { ?>
			À mon tour de <a href="?dice=1" class="action">Lancer le dé</a>
		<?php } else { ?>
			Au tour de <?= GameBizkit::$players[GameBizkit::$tourIndex]->getNom(); ?> de lancer le dé.
		<?php } ?>
	<?php } ?>
	<table class="inventory inventoryPage">
		<tr>
			<th>Tour</th>
			<th>Bizkit</th>
			<th>Participants</th>
		</tr>
<?php
$n = 0;
foreach (GameBizkit::$players as $key => $player) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
		<tr class="<?= $odd ?>">
			<td><?= $gameBizkit->getTour()==$player->getId()?'&gt;':'' ?></td>
			<td><?= $gameBizkit->getBizkit()==$player->getId()?'#':'' ?></td>
			<td <?= $player->getId()==$_SESSION['user']->getId()?'style="color: gold;"':'' ?>><?= $player->htmlPhoto(32).' '.$player->getNom() ?></td>
		</tr>
<?php } ?>
	</table>
	<a href="?quit=1" class="action">Quitter la partie</a>


	<div>Caractéristiques du faluchard:</div>
	<?php $player = $_SESSION['user']; ?>
	<table class="playerStats">
		<tr class="odd">
			<th>
				<img src="images/util/chope or.png" title="Verres" alt="Verres">
			</th>
			<td><?= lifeBarMiddle($player->getCalculatedAlcoolemie_max(), $player->getCalculatedAlcoolemie_optimum(), $player->getCalculatedAlcoolemie())?>
		<?=$player->getCalculatedAlcoolemie().'/'.$player->getCalculatedAlcoolemie_max().' optimum à '.$player->getCalculatedAlcoolemie_optimum(); ?></td>
		</tr>
	</table>
	<script type="text/javascript">
	function refreshGame() {
	    location.replace('ajaxGameBizkit.php');
	}
	setTimeout(refreshGame, 4*1000);
</script>

</body>
</html>
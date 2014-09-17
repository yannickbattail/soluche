<?php

function noGame() {
	?>
<h3>Jeux</h3>
Bizkit version Beta
<?php echo (new CreateGame($_SESSION['user']))->setParams(array())->link() ;?>
<h3>Parties en cours</h3>
<table class="inventory inventoryPage">
	<tr>
		<th>Type</th>
		<th>Nom de la partie</th>
		<th>Début</th>
		<th>Paticipants</th>
		<th>Démarrée</th>
		<th>Paticipants</th>
	</tr>
	<?php
	$n = 0;
	$sth = $GLOBALS['DB']->query('SELECT * FROM game ORDER BY game_type,nom;');
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	while ($sth && ($arr = $sth->fetch())) {
		$game = new Game();
		$game->populate($arr);
		$gameBizkit = new GameBizkit();
		$gameBizkit->populate($game->getGame_data());
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?>">
		<td><?= $game->getGame_type(); ?></td>
		<td><?= $game->getNom(); ?></td>
		<td><?= date('Y/m/d H:i:s', $game->getDate_start())  ?></td>
		<td><?= (new Participate($_SESSION['user']))->setParams(array(Participate::PARAM_NAME=>$game))->link() ?></td>
		<td><?= $gameBizkit->getStarted()?'en cours':'en attente' ?></td>
		<td><?= join(',', $gameBizkit->getParticipantsNames()) ?></td>
	</tr>
	<?php }	?>
	</table>

<?php
}

if (!isset($_SESSION['game']) || !$_SESSION['game']) {
	noGame();
} else {
	$game = Game::load($_SESSION['game']);
	if (!$game) {
		noGame();
	} else {
		?>
<h3>Jeux: <?= $game->getGame_type() ?>, partie: <?= $game->getNom() ?></h3>
Bizkit version Beta
<iframe src="ajaxGameBizkit.php" style="width: 100%; height: 500px;"></iframe>
<!-- 
<div id="gameContent"><img src="images/loading.gif" alt="loading" title="loading" /></div>
<script type="text/javascript">
	function refreshGame() {
    	$('#gameContent').load('ajaxGameBizkit.php');
	}
	setInterval(refreshGame, 2*1000);
</script>
 -->
<?php
	}
}

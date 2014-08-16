<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */


/* ------ html ------- */
?>
<table style="width: 200px;">

<?php
$uid = $_SESSION['user']->getId();
$sql = '
SELECT history.*, action_doer.nom AS action_doer_nom, opponent.nom AS opponent_nom, congress.nom AS congress_nom
FROM `history`
LEFT JOIN player AS action_doer ON history.id_player = action_doer.id
LEFT JOIN player AS opponent ON history.id_opponent = opponent.id
LEFT JOIN congress ON history.id_congress = congress.id
WHERE action_name IN ("Chopper", "Duel", "StartCongress", "StartPLS", "Vt")
ORDER BY `date_action` DESC
LIMIT 20';
$n = 0;
$sth = $GLOBALS['DB']->query($sql);
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$history = new History();
	$history->populate($arr);
	$odd = ($n++ % 2) ? 'odd' : 'even';
	$css = 'infoMessage';
	if ($history->getSuccess() == ActionResult::SUCCESS) {
		$css = 'successMessage';
	} else if ($history->getSuccess() == ActionResult::FAIL) {
		$css = 'errorMessage';
	}
	
	$txt = '';
	if ($history->getAction_Name() == 'Chopper') {
		if ($history->getSuccess() == ActionResult::SUCCESS) {
			$txt .= $arr['action_doer_nom'] . ' a choppé ' . $arr['opponent_nom'];
		} else if ($history->getSuccess() == ActionResult::FAIL) {
			$txt .= $arr['action_doer_nom'] . ' n\'a pas réussi a choppé ' . $arr['opponent_nom'];
		}
	} else if ($history->getAction_Name() == 'Duel') {
		$txt .= $arr['action_doer_nom'] . ' a défié ' . $arr['opponent_nom'] . ' au bar et ';
		if ($history->getSuccess() == ActionResult::SUCCESS) {
			$txt .= ' l\'a plié il repose maintenant en PLS, paix à son foie.';
		} else if ($history->getSuccess() == ActionResult::FAIL) {
			$txt .= ' s\'est fait plié (en 4).';
		}
	} else if ($history->getAction_Name() == 'StartCongress') {
		$txt .= $arr['action_doer_nom'] . ' participe au congrès ' . $arr['congress_nom'];
	} else if ($history->getAction_Name() == 'StartPLS') {
		$txt .= $arr['action_doer_nom'] . ' a fini en PLS au congrès ' . $arr['congress_nom'];
	} else if ($history->getAction_Name() == 'Vt') {
		$txt .= $arr['action_doer_nom'] . ' est parti faire un VT';
	}
	?>
<tr class="<?= $odd ?>">
		<td><?= $txt?>
			</td>
	</tr>
<?php } ?>
</table>

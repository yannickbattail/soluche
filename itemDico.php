<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */

if (isset($_REQUEST['message'])) {
	Chat::sendGlobalMessage($_REQUEST['message']);
}

/* ------ html ------- */

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche</title>
<link rel="icon" type="image/png" href="images/items/cle de fa.png">
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
note: ceux qui n'ont pas de description ne sont pas encore utilisé.
<table class="inventory inventoryPage">
	<tr>
		<th>Item</th>
		<th>Type</th>
		<th><img src="images/util/Dignichose.png" title="Coût en dignichose" alt="Coût en dignichose"></th>
		<th><img src="images/util/lock closed.png" title="Permanant" alt="Permanant"></th>
		<th><img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité"></th>
		<th><img src="images/util/chope argent.png" title="Verres" alt="Verres"></th>
		<th><img src="images/util/chope or.png" title="Verres optimum" alt="Verres optimum"></th>
		<th><img src="images/util/chope rouge.png" title="Verres max" alt="Verres max"></th>
		<th><img src="images/util/sleep.png" title="Fatigue" alt="Fatigue"></th>
		<th><img src="images/util/fatigue max.png" title="Fatigue max" alt="Fatigue max"></th>
		<th><img src="images/util/sex appeal.png" title="Sexe appeal" alt="Sexe appeal"></th>
		<th><img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure"></th>
		<th>Description</th>
	</tr>
<?php
$orga = Player::loadOrga('orga', $_SESSION['user']->getId_congress());
$n = 0;
$sth = $GLOBALS['DB']->query('SELECT * FROM item ORDER BY item_type, nom;');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$item = new Item();
	$item->populate($arr);
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td><img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" /><br /><?= $item->getNom(); ?></td>
		<td><?= $item->getItem_type() ?></td>
		<td><?= plus($item->getPrice(), 0) ?></td>
		<td><?= $item->getPermanent() ?></td>
		<td><?= plus($item->getNotoriete(), 1); ?></td>
		<td><?= plus($item->getAlcoolemie(), 0); ?></td>
		<td><?= plus($item->getAlcoolemie_optimum(), 1); ?></td>
		<td><?= plus($item->getAlcoolemie_max(), 1); ?></td>
		<td><?= plus($item->getFatigue(), 0); ?></td>
		<td><?= plus($item->getFatigue_max(), 1); ?></td>
		<td><?= plus($item->getSex_appeal(), 1); ?></td>
		<td><?= plus($item->getRemaining_time(), 1); ?></td>
		<td><?= $item->getDescription() ?></td>
	</tr>
	<?php
}
?>
</table>

</body>
</html>

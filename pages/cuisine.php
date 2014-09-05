
<h3>Repas, au menu:</h3>
<table class="inventory inventoryPage">
	<tr>
		<th>Bouffe</th>
		<th></th>
		<th><img src="images/util/sleep.png" title="Fatigue" alt="Fatigue"></th>
	</tr>
<?php
$orga = Player::loadOrga('cuisine', $_SESSION['user']->getId_congress());
$n = 0;
$sth = $GLOBALS['DB']->query('SELECT O.* FROM item O INNER JOIN inventory I ON I.id_item = O.id WHERE I.id_player = '.$orga->getId().';');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$item = new Item();
	$item->populate($arr);
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" />
		</td>
		<td><?= (new Eat($_SESSION['user']))->setParams(array(Eat::PARAM_NAME=>$item))->link() ?></td>
		<td><?= plus($item->getFatigue(), 0); ?></td>
	</tr>
        <?php
}
?>
</table>

<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>
<br />

<h3>personnes dans la cuisine</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND lieu = "cuisine" AND pnj < 2 ORDER BY pnj,nom;');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user'])));
?>


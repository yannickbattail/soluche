
<h3>Boisson au bar:</h3>
<table class="inventory inventoryPage">
	<tr>
		<th>Boisson</th>
		<th></th>
		<th><img src="images/util/chope rouge.png" title="Verres" alt="Verres"></th>
	</tr>
<?php
$orga = Player::loadOrga('bar', $_SESSION['user']->getId_congress());
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
		<td><?= (new Drink($_SESSION['user']))->setParams(array(Drink::PARAM_NAME=>$item))->link() ?></td>
		<td><?= plus($item->getAlcoolemie(), 0); ?></td>
	</tr>
        <?php
}
?>
</table>

<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>

<h3>Personnes au bar:</h3>
<?php
$sql = 'SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND lieu = "bar" AND pnj < 2 ORDER BY pnj,nom;';
$stmt = $GLOBALS['DB']->query($sql);
printPlayerBox($stmt, array('Défier' => new Duel($_SESSION['user']), 'Pinser' => new Pins($_SESSION['user'])));
?>

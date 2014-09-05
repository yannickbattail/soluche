

<?php echo (new StartPLS($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Vt($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>
<br />
<h3>Item mis en vente par les autres participants</h3>
Pensez au chat pour la negociation des prix
<table class="inventory">
	<tr>
		<th>Item</th>
		<th>Prix de vente</th>
		<th>Acheter</th>
		<th>Vendu par</th>
	</tr>
<?php
$n = 0;
$sth = $GLOBALS['DB']->query('
SELECT item.*, inventory.id AS id_inventory, transaction.id AS id_transaction, transaction.money AS transaction_money, player.nom AS player_nom, player.photo AS player_photo
FROM transaction 
LEFT JOIN inventory ON inventory.id = transaction.id_inventory
LEFT JOIN item ON inventory.id_item = item.id
LEFT JOIN player ON inventory.id_player = player.id
WHERE inventory.id_player != ' . $_SESSION['user']->getId() . '
ORDER BY item.id, transaction_money DESC;');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$item = new Item();
	$item->populate($arr);
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" /><br /><?= $item->getDescription(); ?>
		</td>
		<td><?= plus(-1 * $arr['transaction_money'], 1) ?></td>
		<td>
			<?= $arr['id_transaction']?(new Purchase($_SESSION['user']))->setParams(array(Purchase::PARAM_NAME=>$arr['id_transaction']))->link():'' ?></td>
		<td>
			<img src="<?= $arr['player_photo'] ?>" class="inventoryImage" title="<?= $arr['player_nom'] ?>" /><?= $arr['player_nom'] ?>
		</td>
	</tr>
	<?php
}
?>
</table>

<h3>Personnes au camping:</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND (lieu = "camping" OR lieu = "help" OR lieu = "orga") AND pnj < 2 ORDER BY pnj,nom;');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user'])));
?>



<img src="images/util/tent-sleep-icon.png" title="Tente" alt="Tente" />

<?php echo (new Sleep($_SESSION['user']))->setParams(array())->link() ;?>

Mon inventaire, et la vente de mes items.

<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Description</th>
		<th>
			Permament<br />Prix original
		</th>
		<th>Mettre en vente</th>
	</tr>
<?php
$n = 0;
$sth = $GLOBALS['DB']->query('
SELECT item.*, inventory.id AS id_inventory, transaction.id AS id_transaction, transaction.price AS transaction_price
FROM  inventory
LEFT JOIN item ON inventory.id_item = item.id
LEFT JOIN transaction ON inventory.id = transaction.id_inventory
WHERE inventory.id_player = ' . $_SESSION['user']->getId() . '
ORDER BY item.id;');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	if ($arr['id']) {
		$item = new Item();
		$item->populate($arr);
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" />
		</td>
		<td><?= $item->getDescription() ?></td>
		<td><?= $item->getPermanent()?'oui':'non' ?><br /><?= plus($item->getPrice(), 1); ?></td>
		<td>
			<form action="main.php" method="post">
				<!-- onsubmit="if ($('price').val() == ''){ return false;} else { return confirm('Mettre en vente pour '+$('price').val()+' en dignichoses. Etes-vous sûr?');}" -->
				<input type="hidden" name="action" value="PutOnSale" />
				<input type="hidden" name="prevent_reexecute" value="<?= $_SESSION['prevent_reexecute'] ?>" />
				<input type="hidden" name="id_inventory" value="<?= $arr['id_inventory'] ?>" />
				<input type="hidden" name="id_transaction" value="<?= $arr['id_transaction'] ?>" />
				<label title="Prix en dignichose">Prix:<input type="text" name="price" id="price" value="<?= $arr['transaction_price'] ?>" class="int" /></label>
				<input type="submit" name="PutOnSale" <?= $arr['id_transaction']?'value="Changer le prix"':'value="mettre en vente"' ?> class="action" />
			</form>
			<?= $arr['id_transaction']?'En attente d\'achat.':''?>
			<?= $arr['id_transaction']?(new AbortSale($_SESSION['user']))->setParams(array(AbortSale::PARAM_NAME=>$arr['id_transaction']))->link():'' ?></td>
	</tr>
	<?php
	}
}
?>
</table>

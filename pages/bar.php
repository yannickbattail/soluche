
<h3>Boisson au bar:</h3>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>glouglou</th>
		<th>Verre</th>
	</tr>
<?php
$sth = $GLOBALS['DB']->query('SELECT O.* FROM item O INNER JOIN inventory I ON I.id_item = O.id WHERE I.id_player = -2 AND permanent = 0;');
$sth->setFetchMode(PDO::FETCH_CLASS, 'Item');
$n = 0;
while ($sth && ($item = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->image; ?>" class="inventoryImage" title="<?= $item->nom; ?>" />
		</td>
		<td><?= (new Eat($_SESSION['user']))->setParams(array(Eat::PARAM_NAME=>$item))->link() ?></td>
		<td><?= plus($item->alcoolemie, 0); ?></td>
	</tr>
        <?php
}
?>
</table>
Personnes au bar:
<?php
$sql = 'SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['congress']->getId() . ' AND lieu = "bar" AND pnj < 2;';
$stmt = $GLOBALS['DB']->query($sql);
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
printPlayerBox($stmt, array('Défier' => new Duel($_SESSION['user']), 'Pinser' => new Pins($_SESSION['user'])));
?>
<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>
<br />
<a href="main.php?page=camping">retour au camping</a>


<a href="main.php?page=camping">retour au camping</a>

<h3>Repas, au menu:</h3>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Manger</th>
		<th>Fatigue</th>
	</tr>
<?php
$sth = $GLOBALS['DB']->query('SELECT O.* FROM item O INNER JOIN inventory I ON I.id_item = O.id WHERE I.id_player = -1 AND permanent = 0;');
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
		<td><?= plus($item->fatigue, 0); ?></td>
	</tr>
        <?php
}
?>
</table>

<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>
<br />

<h3>personnes dans la cuisine</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND lieu = "cuisine" AND pnj < 2;');
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user'])));
?>


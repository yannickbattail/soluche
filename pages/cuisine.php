

<h3>Repas, au menu:</h3>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Manger</th>
		<th>Fatigue</th>
	</tr>
<?php
$sth = $GLOBALS['DB']->query('SELECT O.* FROM objet O INNER JOIN inventory I ON I.idobject = O.id WHERE I.idplayer = -1 AND permanent = 0;');
$sth->setFetchMode(PDO::FETCH_CLASS, 'Objet');
$n = 0;
while ($sth && ($objet = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $objet->image; ?>" class="inventoryImage" title="<?= $objet->nom; ?>" />
		</td>
		<td><?= (new Eat($_SESSION['user']))->setParams(array(Eat::PARAM_NAME=>$objet))->link() ?></td>
		<td><?= plus($objet->fatigue, 0); ?></td>
	</tr>
        <?php
}
?>
</table>

<h3>personnes dans la cuisine</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['congress']->getId() . ' AND lieu = "cuisine" AND pnj < 2;');
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user'])
));
?>

<a href="main.php?page=camping">retour au camping</a>

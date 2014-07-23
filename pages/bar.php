
<h3>Boisson au bar:</h3>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>glouglou</th>
		<th>Verre</th>
	</tr>
<?php
$sth = $GLOBALS['DB']->query('SELECT O.* FROM objet O INNER JOIN inventory I ON I.idobject = O.id WHERE I.idplayer = -2 AND permanent = 0;');
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
		<td><?= plus($objet->alcoolemie, 0); ?></td>
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
printPlayerBox($stmt, array('Défier' => new Duel($_SESSION['user']),'Pinser' => new Pins($_SESSION['user'])
));
?>

<a href="main.php?page=camping">retour au camping</a>

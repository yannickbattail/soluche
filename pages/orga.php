
<a href="main.php?page=camping">retour au camping</a>

<h3>Vends ta dignichose pour avoir des items:</h3>
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>
			<img src="images/items/pin-s-exigeons-la-dignité.png" alt="Coût en dignichose" width="32" height="32">
			<br />Dignichose
		</th>
		<th>Want!</th>
		<th>Permanant</th>
		<th>
			<img src="images/emotes/face-raspberry.png" title="Crédibidulité" width="32" height="32">
			<br />Crédibidulité
		</th>
		<th>
			<img src="images/util/chope argent.png" title="Verres" width="32" height="32">
			<br />Verres
		</th>
		<th>
			<img src="images/util/chope or.png" title="Verres" width="32" height="32">
			<br />Verres optimum
		</th>
		<th>
			<img src="images/util/chope rouge.png" title="Verres" width="32" height="32">
			<br />Verres max
		</th>
		<th>
			<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
			<br />Fatigue
		</th>
		<th>
			<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
			<br />Fatigue max
		</th>
		<th>
			<img src="images/util/sex appeal.png" title="Sexe appeal" width="32" height="32">
			<br />Sexe appeal
		</th>
		<th>
			<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
			<br />¼ H
		</th>
	</tr>
<?php
$sth = $GLOBALS['DB']->query('SELECT O.* FROM item O INNER JOIN inventory I ON I.id_item = O.id WHERE I.id_player = -3 AND permanent = 0;');
$sth->setFetchMode(PDO::FETCH_CLASS, 'Item');
$n = 0;
while ($sth && ($item = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $item->getImage(); ?>" class="inventoryImage" title="<?= $item->getNom(); ?>" />
		</td>
		<td><?= plus($item->getPrice(), 1); ?></td>
		<td><?= (new Buy($_SESSION['user']))->setParams(array(Buy::PARAM_NAME=>$item))->link() ?></td>
		<td><?= $item->permanent?'oui':'non' ?></td>
		<td><?= plus($item->getNotoriete(), 1); ?></td>
		<td><?= plus($item->getAlcoolemie(), 0); ?></td>
		<td><?= plus($item->getAlcoolemie_optimum(), 1); ?></td>
		<td><?= plus($item->getAlcoolemie_max(), 1); ?></td>
		<td><?= plus($item->getFatigue(), 0); ?></td>
		<td><?= plus($item->getFatigue_max(), 1); ?></td>
		<td><?= plus($item->getSex_appeal(), 1); ?></td>
		<td><?= plus($item->getRemaining_time(), 1); ?></td>

	</tr>
	<?php
}
?>
</table>

<h3>Stats</h3>
<?php printUserStats($_SESSION['user']); ?>
<br />
<h3>Inventaire</h3>
<?php printInventory2($_SESSION['user']); ?>

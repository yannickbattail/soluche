
<h3>Vends ta dignichose pour avoir des items:</h3><img src="images/items/pin-s-exigeons-la-dignité.png" alt="Dignichose" />

<table class="inventory inventoryPage">
	<tr>
		<th>Item</th>
		<th>
			<img src="images/util/Dignichose.png" title="Coût en dignichose" alt="Coût en dignichose">
		</th>
		<th>Want!</th>
		<th>
			<img src="images/util/lock closed.png" title="Permanant" alt="Permanant">
		</th>
		<th>
			<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
		</th>
		<th>
			<img src="images/util/chope argent.png" title="Verres" alt="Verres">
		</th>
		<th>
			<img src="images/util/chope or.png" title="Verres optimum" alt="Verres optimum">
		</th>
		<th>
			<img src="images/util/chope rouge.png" title="Verres max" alt="Verres max">
		</th>
		<th>
			<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
		</th>
		<th>
			<img src="images/util/fatigue max.png" title="Fatigue max" alt="Fatigue max">
		</th>
		<th>
			<img src="images/util/sex appeal.png" title="Sexe appeal" alt="Sexe appeal">
		</th>
		<th>
			<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
		</th>
		<th>
			Description
		</th>
	</tr>
<?php
$orga = Player::loadOrga('orga', $_SESSION['user']->getId_congress());
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
		<td><?= plus($item->getPrice(), 1); ?></td>
		<td><?= (new Buy($_SESSION['user']))->setParams(array(Buy::PARAM_NAME=>$item))->link() ?></td>
		<td><?= $item->getPermanent()?'oui':'non' ?></td>
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


<h3>Vends ta dignichose pour avoir des items:</h3><img src="images/items/pin-s-exigeons-la-dignité.png" alt="Dignichose" />
<a href="itemDico.php"><img src="images/util/help.png" alt="dico des insignes" title="dico des insignes" style="width: 16px; height: 16px;"></a>
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
		<td><?= plus($item->getMoney(), 1); ?></td>
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

<h3 id="levelItemList">Insignes de niveau:</h3>
Vous ne pouvez avoir que 2 insignes pour chaque niveau.
<table class="inventory inventoryPage">
	<tr>
		<th>Item</th>
		<th>
			level requis
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
$n = 0;
$sth = $GLOBALS['DB']->query('SELECT * FROM item WHERE item_type = "level" ORDER BY money, nom;');
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
		<td><?= $item->getMoney() ?></td>
		<td><?= ($item->getMoney() <= $_SESSION['user']->getLevel())?(new Obtain($_SESSION['user']))->setParams(array(Obtain::PARAM_NAME=>$item))->link():'' ?></td>
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

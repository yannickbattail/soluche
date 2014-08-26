
<img src="images/util/tent-sleep-icon.png" title="Tente" alt="Tente" />

<?php echo (new Sleep($_SESSION['user']))->setParams(array())->link() ;?>

<h3>Mon inventaire, et la vente de mes items.</h3>
<a href="main.php?page=help#dicoItem"><img src="images/util/help.png" alt="dico des insignes" title="dico des insignes" style="width: 16px; height: 16px;"></a>
<table class="inventory">
	<tr>
		<th>Item</th>
		<th>Type</th>
		<th>
			<img src="images/util/Dignichose.png" title="Coût en dignichose" alt="Coût en dignichose">
		</th>
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
		<th>Description</th>
		<th>Utiliser</th>
		<th>Vendre</th>
		<th>Mettre en vente</th>
	</tr>
<?php
$n = 0;
$sum = array('money' => 0, 'notoriete' => 0, 'alcoolemie' => 0, 'alcoolemie_optimum' => 0, 'alcoolemie_max' => 0, 'fatigue' => 0, 'fatigue_max' => 0, 'sex_appeal' => 0, 'remaining_time' => 0);
$sth = $GLOBALS['DB']->query('
SELECT item.*, inventory.id AS id_inventory, transaction.id AS id_transaction, transaction.money AS transaction_money
FROM  inventory
LEFT JOIN item ON inventory.id_item = item.id
LEFT JOIN transaction ON inventory.id = transaction.id_inventory
WHERE inventory.id_player = ' . $_SESSION['user']->getId() . '
ORDER BY item.permanent, item.item_type, item.nom;');
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
			<br /><?= $item->getNom(); ?></td>
		<td><?= $item->getItem_type() ?></td>
		<td><?= plus($item->getMoney(), 1) ?></td>
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
		<td><?= array_search($item->getItem_type(), array('alcohol','drink','food','object'))?'':(new UseItem($_SESSION['user']))->setParams(array(UseItem::PARAM_NAME=>$item))->link()?></td>
		<td><?= (new Sell($_SESSION['user']))->setParams(array(Sell::PARAM_NAME=>$item))->link()?></td>
		<td>
			<form action="main.php" method="post">
				<!-- onsubmit="if ($('money').val() == ''){ return false;} else { return confirm('Mettre en vente pour '+$('money').val()+' en dignichoses. Etes-vous sûr?');}" -->
				<input type="hidden" name="action" value="PutOnSale" />
				<input type="hidden" name="prevent_reexecute" value="<?= $_SESSION['prevent_reexecute'] ?>" />
				<input type="hidden" name="id_inventory" value="<?= $arr['id_inventory'] ?>" />
				<input type="hidden" name="id_transaction" value="<?= $arr['id_transaction'] ?>" />
				<label title="Prix en dignichose">Prix:<input type="text" name="money" id="money" value="<?= $arr['transaction_money'] ?>" class="int" /></label>
				<input type="submit" name="PutOnSale" <?= $arr['id_transaction']?'value="Changer le prix"':'value="mettre en vente"' ?> class="action" />
			</form>
			<?= $arr['id_transaction']?'En attente d\'achat.':''?>
			<?= $arr['id_transaction']?(new AbortSale($_SESSION['user']))->setParams(array(AbortSale::PARAM_NAME=>$arr['id_transaction']))->link():'' ?></td>
	</tr>
	<?php
		if ($item->getPermanent()) {
			$sum['money'] += $item->getMoney();
			$sum['notoriete'] += $item->getNotoriete();
			$sum['alcoolemie'] += $item->getAlcoolemie();
			$sum['alcoolemie_optimum'] += $item->getAlcoolemie_optimum();
			$sum['alcoolemie_max'] += $item->getAlcoolemie_max();
			$sum['fatigue'] += $item->getFatigue();
			$sum['fatigue_max'] += $item->getFatigue_max();
			$sum['sex_appeal'] += $item->getSex_appeal();
			$sum['remaining_time'] += $item->getRemaining_time();
		}
	}
}
?>
	</tr>
	<tr>
	</tr>
	<?php $odd = ($n++ % 2) ? 'odd' : 'even'; ?>
	<tr class="<?= $odd ?>">
		<td>Total</td>
		<td></td>
		<td><?= plus($sum['money'], 1) ?></td>
		<td>oui</td>
		<td><?= plus($sum['notoriete'], 1); ?></td>
		<td><?= plus($sum['alcoolemie'], 0); ?></td>
		<td><?= plus($sum['alcoolemie_optimum'], 1); ?></td>
		<td><?= plus($sum['alcoolemie_max'], 1); ?></td>
		<td><?= plus($sum['fatigue'], 0); ?></td>
		<td><?= plus($sum['fatigue_max'], 1); ?></td>
		<td><?= plus($sum['sex_appeal'], 1); ?></td>
		<td><?= plus($sum['remaining_time'], 1); ?></td>
		<td>Total des insignes permanents</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php $odd = ($n++ % 2) ? 'odd' : 'even'; ?>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $_SESSION['user']->getPhoto() ?>" class="inventoryImage" title="<?= $_SESSION['user']->getNom() ?>" />
			<br /><?= $_SESSION['user']->getNom() ?></td>
		<td>Faluchard</td>
		<td><?= plus($_SESSION['user']->getMoney(), 1) ?></td>
		<td></td>
		<td><?= plus($_SESSION['user']->getNotoriete(), 1); ?></td>
		<td><?= plus($_SESSION['user']->getAlcoolemie(), 0); ?></td>
		<td><?= plus($_SESSION['user']->getAlcoolemie_optimum(), 1); ?></td>
		<td><?= plus($_SESSION['user']->getAlcoolemie_max(), 1); ?></td>
		<td><?= plus($_SESSION['user']->getFatigue(), 0); ?></td>
		<td><?= plus($_SESSION['user']->getFatigue_max(), 1); ?></td>
		<td><?= plus($_SESSION['user']->getSex_appeal(), 1); ?></td>
		<td><?= plus($_SESSION['user']->getRemaining_time(), 1); ?></td>
		<td>Le faluchard sans ses insignes</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php $odd = ($n++ % 2) ? 'odd' : 'even'; ?>
	<tr>
	</tr>
	<tr class="<?= $odd ?>">
		<td>
			<img src="<?= $_SESSION['user']->getPhoto() ?>" class="inventoryImage" title="<?= $_SESSION['user']->getNom() ?>" />
			<br /><?= $_SESSION['user']->getNom() ?></td>
		<td>FALUCHARD</td>
		<td>-</td>
		<td></td>
		<td><?= plus($_SESSION['user']->getNotoriete() + $sum['notoriete'], 1); ?></td>
		<td><?= plus($_SESSION['user']->getAlcoolemie() + $sum['alcoolemie'], 0); ?></td>
		<td><?= plus($_SESSION['user']->getAlcoolemie_optimum() + $sum['alcoolemie_optimum'], 1); ?></td>
		<td><?= plus($_SESSION['user']->getAlcoolemie_max() + $sum['alcoolemie_max'], 1); ?></td>
		<td><?= plus($_SESSION['user']->getFatigue() + $sum['fatigue'], 0); ?></td>
		<td><?= plus($_SESSION['user']->getFatigue_max() + $sum['fatigue_max'], 1); ?></td>
		<td><?= plus($_SESSION['user']->getSex_appeal() + $sum['sex_appeal'], 1); ?></td>
		<td><?= plus($_SESSION['user']->getRemaining_time() + $sum['remaining_time'], 1); ?></td>
		<td>Le faluchard avec ses insignes</td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>

<h3>Les congrès du moment:</h3>

<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Heures</th>
		<th>Participer</th>
	</tr>
	<?php
	$stmt = $GLOBALS['DB']->query('SELECT * FROM congress ;');
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'Congress');
	$n = 0;
	while ($stmt && ($congress = $stmt->fetch())) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
        <tr class="<?= $odd ?>">
		<td>
			<?= $congress->getNom(); ?>
		</td>
		<td>
			<?= $congress->getAction_number(); ?>
		</td>
		<td><?= ((new StartCongress($_SESSION['user']))->setParams(array(StartCongress::PARAM_NAME => $congress))->link('bar')) ?></td>
	</tr>
        <?php
	}
	?>
</table>

<?php
if (!$_SESSION['user']->getId_congress()) {
	?>
Congrès pas fini ... et ben si :-(

<h3>Résumé</h3>
<table class="inventory">
	<tr>
		<th>Action</th>
		<th>Compte</th>
	</tr>
	
	
<?php
	$uid = $_SESSION['user']->getId();
	$sql = 'SELECT count(id) AS nb, `action_name`, `success` FROM `history`';
	$sql .= ' WHERE `id_player`=' . $uid . ' AND ';
	$sql .= ' `date_action` >=';
	$sql .= ' (';
	$sql .= '    SELECT `date_action` FROM `history`';
	$sql .= '    WHERE `id_player`=' . $uid . ' AND `action_name`="StartCongress"';
	$sql .= '    ORDER BY `date_action` DESC LIMIT 1';
	$sql .= ' )';
	$sql .= ' GROUP BY `action_name`,`success`';
	$sql .= ' ORDER BY `date_action`';
	
	$stmt = $GLOBALS['DB']->query($sql);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$n = 0;
	while ($stmt && ($stat = $stmt->fetch())) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		$css = 'infoMessage';
		if ($stat['success'] == ActionResult::SUCCESS) {
			$css = 'successMessage';
		} else if ($stat['success'] == ActionResult::FAIL) {
			$css = 'errorMessage';
		}
		?>
	<tr class="<?= $odd ?>">
		<td>
			<div class="<?= $css ?>">
			<?= $stat['action_name']?>
			</div>
		</td>
		<td>
			<?= $stat['nb']?>
		</td>
	</tr>
<?php } ?>
</table>


<h3>Historique</h3>
<table class="inventory">
	<tr>
		<th>Action</th>
		<th>Message</th>
		<th>Lieu</th>
	</tr>


<?php
	$uid = $_SESSION['user']->getId();
	$sql = 'SELECT * FROM `history` ';
	$sql .= ' WHERE `id_player`=' . $uid . ' AND `date_action` >= ( ';
	$sql .= '    SELECT `date_action` FROM `history` WHERE `id_player`=' . $uid . ' AND `action_name`="StartCongress" ORDER BY `date_action` DESC LIMIT 1 ';
	$sql .= ' ) ORDER BY `date_action`';
	$stmt = $GLOBALS['DB']->query($sql);
	$stmt->setFetchMode(PDO::FETCH_CLASS, 'History');
	$n = 0;
	while ($stmt && ($history = $stmt->fetch())) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		$css = 'infoMessage';
		if ($history->getSuccess() == ActionResult::SUCCESS) {
			$css = 'successMessage';
		} else if ($history->getSuccess() == ActionResult::FAIL) {
			$css = 'errorMessage';
		}
		?>
	<tr class="<?= $odd ?>">
		<td>
			<?= $history->getAction_Name()?>
		</td>
		<td>
			<div class="<?= $css ?>">
				<?= $history->getMessage()?>
			</div>
		</td>
		<td>
			<?= $history->getLieu()?>
		</td>
	</tr>
<?php } ?>
	
</table>
<?php } ?>







<hr />
<?php printUserStats($_SESSION['user']); ?>
<?php //printInventory2($_SESSION['user']); ?>

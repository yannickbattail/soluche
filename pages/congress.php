<h3>Les congrès du moment:</h3>
S'inscire à un congrès pour commencer à jouer.
<table class="inventory">
	<tr>
		<th>Nom</th>
		<th>Durée</th>
		<th>Mon budget</th>
		<th>Difficulté</th>
		<th>Participer</th>
	</tr>
	<?php
	$n = 0;
	$sth = $GLOBALS['DB']->query('SELECT * FROM congress ;');
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	while ($sth && ($arr = $sth->fetch())) {
		$congress = new Congress();
		$congress->populate($arr);
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
        <tr class="<?= $odd ?>">
			<td>
				<?= $congress->getNom(); ?>
			</td>
			<td>
				<?= $congress->getAction_number(); ?>
			</td>
			<td>
				<?= $congress->getBudget() ?>
			</td>
			<td>
				<?= $congress->getLevel(); ?>
			</td>
			<td><?= ((new StartCongress($_SESSION['user']))->setParams(array(StartCongress::PARAM_NAME => $congress))->link('orga')) ?></td>
		</tr>
    <?php } ?>
</table>

<?php
if (!$_SESSION['user']->getId_congress()) {
	?>
	<br />
Congrès pas fini ... et ben si :-(

<h3>Résumé du congrès précédent</h3>
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
	$sql .= ' ORDER BY `action_name`,`success`';
	
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


<h3>Historique des actions du congrès</h3>
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
	$sql .= '    SELECT `date_action` FROM `history` ';
	$sql .= '    WHERE `id_player`=' . $uid . ' AND `action_name`="StartCongress" ';
	$sql .= '    ORDER BY `date_action` DESC LIMIT 1 ';
	$sql .= ' ) ORDER BY `date_action`';
	$n = 0;
	$sth = $GLOBALS['DB']->query($sql);
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	while ($sth && ($arr = $sth->fetch())) {
		$history = new History();
		$history->populate($arr);
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

Les congrès du moment:

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

<table class="inventory">
	<tr>
		<th>Résumé</th>
	</tr>
<?php
	if (isset($_SESSION['history'])) {
		foreach ($_SESSION['history'] as $actionResult) {
			?>
	<tr class="<?php echo $actionResult->succes?'successMessage':'errorMessage'; ?>">
		<td><?= $actionResult->message ?></td>
	</tr>
<?php }} ?>
	
</table>
<?php } ?>

<hr />
<?php printUserStats($_SESSION['user']); ?>
<?php //printInventory2($_SESSION['user']); ?>

Se deplacer:
<ul>
	<li><?=linkAction('StartCongres', array('congres' => 0), 'début de congrès', null)?></li>
</ul>

<?php
if (isset($_SESSION['congres']) && ($_SESSION['congres']->getFatigue() == 0)) {
	?>
Congrès pas fini ... et ben si :-(

<table class="inventory">
	<tr>
		<th>Résumé</th>
	</tr>
<?php
	$n = 0;
	foreach ($_SESSION['congres']->getHistory() as $actionResult) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<tr class="<?= $odd ?> <?php echo $actionResult->succes?'successMessage':'errorMessage'; ?>">
		<td><?= $actionResult->message ?></td>
	</tr>
<?php } ?>
	
</table>
<?php } ?>

<hr />
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

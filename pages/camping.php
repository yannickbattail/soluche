Se deplacer:
<ul>
	<li><a href="main.php?page=bar">au bar</a></li>
	<li><?=linkAction('startPLS', array(), 'se mettre en PLS', null)?></li>
	<li><a href="main.php?page=tente">à ta tente</a></li>
	<li><a href="main.php?page=cuisine">à la cuisine</a></li>
	<li><a href="main.php?page=danse">à la piste de danse</a></li>
</ul>


<hr />
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

<?=linkAction('vt', array(), 'faire un VT', 'camping')?>

 Se deplacer:
<ul>
	<li><a href="main.php?page=bar">au bar</a></li>
	<li><a href="main.php?page=pls&action=startPLS">se mettre en PLS</a></li>
	<li><a href="main.php?page=tente">à ta tente</a></li>
	<li><a href="main.php?page=cuisine">à la cuisine</a></li>
	<li><a href="main.php?page=danse">à la piste de danse</a></li>
</ul>
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

<?=linkAction('vt', array(), 'faire un VT', 'camping')?>

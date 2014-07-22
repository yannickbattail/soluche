Se deplacer:
<ul>
	<li><a href="main.php?page=bar">au bar</a></li>
	<li><a href="main.php?page=tente">à ta tente</a></li>
	<li><a href="main.php?page=cuisine">à la cuisine</a></li>
	<li><a href="main.php?page=danse">à la piste de danse</a></li>
</ul>


<hr />
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>


<?php echo (new StartPLS($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Vt($_SESSION['user']))->setParams(array())->link() ;?>

Se deplacer:
<ul>
	<li><a href="main.php?page=bar">au bar</a></li>
	<li><a href="main.php?page=tente">à ta tente</a></li>
	<li><a href="main.php?page=cuisine">à la cuisine</a></li>
	<li><a href="main.php?page=danse">à la piste de danse</a></li>
</ul>


<hr />
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory2($_SESSION['user']); ?>

<h3>Personnes au camping:</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['congress']->getId() . ' AND lieu = "camping" AND pnj < 2;');
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user'])
));
?>

<?php echo (new StartPLS($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Vt($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>

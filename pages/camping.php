
<h3>Camping</h3>

<?php echo (new StartPLS($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Vt($_SESSION['user']))->setParams(array())->link() ;?>
<?php echo (new Sing($_SESSION['user']))->setParams(array())->link() ;?>
<br />


<h3>Personnes au camping:</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND lieu = "camping" AND pnj < 2;');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user'])));
?>


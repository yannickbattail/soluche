
<a href="main.php?page=camping">retour au camping</a>

<h3>Personnes sur le piste de danse:</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['congress']->getId() . ' AND lieu = "danse" AND pnj < 2;');
$stmt->setFetchMode(PDO::FETCH_CLASS, 'Player');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user']),'Essayer de chopper' => new Chopper($_SESSION['user'])
));
?>


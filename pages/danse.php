
<h3>Personnes sur le piste de danse:</h3>
<?php
$stmt = $GLOBALS['DB']->query('SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND lieu = "danse" AND pnj < 2 ORDER BY pnj,nom;');
printPlayerBox($stmt, array('Pinser' => new Pins($_SESSION['user']),'Essayer de chopper' => new Chopper($_SESSION['user'])
));
?>

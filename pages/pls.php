
<h3>Vous êtes en PLS.</h3>
Toutes les 60 secondes vous perdez 1 verre.
<?php printUserStats($_SESSION['user']); ?>

<?php
echo (new EndPLS($_SESSION['user']))->setParams(array())->link('camping');
if (!Pls::isPlsFinished($_SESSION['user'])) {
	echo 'Encore trop d\'verres, impossible de finir sa PLS. Wait for it.';
}
?>


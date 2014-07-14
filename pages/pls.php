
<h3>Vous êtes en PLS.</h3>
Toutes les 60 secondes vous perdez 1 verre d'acoolémie.
<?php printUserStats($_SESSION['user']); ?>
<?php printInventory($_SESSION['user']); ?>

<?php
if (Pls::isPlsFinished($_SESSION['user'])) {
	echo linkAction('EndPls', array(), 'Finir sa pls', 'camping', true);
} else {
	echo linkAction('EndPls', array(), 'Finir sa pls', 'camping', false);
	echo 'Encore trop d\'alcoolémie, impossible de finir sa PLS. Wait for it.';
}
?>


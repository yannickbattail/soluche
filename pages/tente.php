
<a href="main.php?page=camping">retour au camping</a>

<?php printUserStats($_SESSION['user']); ?>

<?php echo (new Sleep($_SESSION['user']))->setParams(array())->link() ;?>

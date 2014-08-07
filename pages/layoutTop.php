<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: <?php echo Dispatcher::$pageTitle; ?></title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
	<h1><?php echo Dispatcher::$pageTitle; ?></h1>
	<div class="login">
		<img src="<?=$_SESSION['user']->getPhoto() ?>" class="playerImage" title="<?= $_SESSION['user']->getNom() ?>" />
		<a href="userCutomisation.php" title="Editer"><?=$_SESSION['user']->getNom() ?></a> <a href="login.php?logout=1"><img alt="Quitter" title="Quitter"
				src="images/util/system-shutdown.png" style="width: 16px; height: 16px;"></a>
		<?php if ($_SESSION['user']->getId_congress() != 0) { ?>
		<div class="congress" title="Congrès en cours">Au congrès <?=$_SESSION['user']->getCongress()->getNom()?>. Temps restant: <?=$_SESSION['user']->getRemaining_time()?> ¼ d'heure <img src="images/util/time-used.png" alt="¼ d'heure" width="16" height="16"></div>
		<?php } ?>
	</div>


	<?php
	foreach (Dispatcher::getMessages() as $em) {
		echo '<div class="' . $em['level'] . '">' . htmlentities($em['message']) . '</div>';
	}
	?>

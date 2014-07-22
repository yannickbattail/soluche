<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: <?php echo Dispatcher::$pageTitle; ?></title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
</head>
<body>
	<h1><?php echo Dispatcher::$pageTitle; ?></h1>
	<?php echo logoutBar(); ?>
	<?php
	if (isset($_SESSION['congress'])) {
		echo '<div class="congress" title="Congrès en cours">Au congrès ' . $_SESSION['congress']->getNom() . '. Heures restantes: ' . $_SESSION['congress']->getFatigue() . '</div>';
	}
	?>
	<?php
	foreach (Dispatcher::getMessages() as $em) {
		echo '<div class="' . $em['level'] . '">' . htmlentities($em['message']) . '</div>';
	}
	?>

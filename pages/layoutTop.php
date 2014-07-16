<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: <?php echo Dispatcher::$pageTitle; ?></title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
</head>
<body>
	<h1><?php echo Dispatcher::$pageTitle; ?></h1>
	<?php echo logoutBar(); ?>
	
	<?php
	foreach (Dispatcher::getMessages() as $em) {
		echo '<div class="' . $em['level'] . '">' . htmlentities($em['message']) . '</div>';
	}
	?>


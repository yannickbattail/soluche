<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
	<div id="header">Soluche</div>


	<?php
	foreach (Dispatcher::getMessages() as $em) {
		echo '<div class="' . $em['level'] . '">' . htmlentities($em['message']) . '</div>';
	}
	?>
	</div>
	<div id="menu">
		<div class="login">
			<img src="<?=$_SESSION['user']->getPhoto() ?>" title="<?= $_SESSION['user']->getNom() ?>" style="max-width: 200px; max-height: 200px;"/>
			<br />
			<?=$_SESSION['user']->getNom(); ?> <?php echo $_SESSION['user']->getSex()?'<span style="color:cyan" title="bite">&#9794;</span>':'<span style="color:pink" title="vagin">&#9792;</span>'; ?>
			<a href="userCutomisation.php"><img src="images/util/edit_user.png" alt="Editer" title="Editer" style="width: 16px; height: 16px;"></a> <a href="login.php?logout=1"><img
					src="images/util/system-shutdown.png" alt="Quitter" title="Quitter" style="width: 16px; height: 16px;"></a>
		</div>
		<?php if ($_SESSION['user']->getId_congress() != 0) { ?>
		<div class="congress" title="Congrès en cours">
			Au congrès <?=$_SESSION['user']->getCongress()->getNom()?>.
			<br />Temps restant: <?=$_SESSION['user']->getRemaining_time()?> <img src="images/util/time-used.png" alt="¼ d'heure" width="16" height="16">
		</div>
		<?php } ?>
		<?php printUserStats($_SESSION['user']); ?>
		<?php printInventory2($_SESSION['user']); ?>
	</div>
	<div id="content">
		<table class="tabBar">
			<tr>
				<td>
					<a href="main.php?page=camping">Camping</a>
				</td>
				<td>
					<a href="main.php?page=orga">Coin des orgas</a>
				</td>
				<td>
					<a href="main.php?page=bar">Bar</a>
				</td>
				<td>
					<a href="main.php?page=tente">Ta tente</a>
				</td>
				<td>
					<a href="main.php?page=cuisine">Cuisine</a>
				</td>
				<td>
					<a href="main.php?page=danse">Piste de danse</a>
				</td>
			</tr>
		</table>

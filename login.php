<?php

function __autoload($classname) {
	$filename = "./classes/" . $classname . ".class.php";
	if (!file_exists($filename)) {
		$filename = "./actions/" . $classname . ".class.php";
	}
	include_once ($filename);
}

session_start();
require_once ('db.php');

$errorMessage = '';
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['user']);
	unset($_SESSION['history']);
}

if (isset($_POST['ok']) && isset($_POST['login']) && isset($_POST['pass'])) {
	try {
		$res = Player::login($_POST['login'], $_POST['pass']);
		if ($res === null) {
			$errorMessage = 'Mot de passe ou login incorrect.';
		} else {
			$_SESSION['user'] = $res;
			header('Location: main.php');
		}
	} catch (Exception $e) {
		echo $e;
		$errorMessage = 'Soucis de connection a la BDD: ' . $e;
	}
}

if (isset($_POST['new']) && isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['robot'])) {
	if ((strcasecmp($_POST['robot'], 'lourd') == 0) || (strcasecmp($_POST['robot'], 'personne lourde') == 0) || (strcasecmp($_POST['robot'], 'gros lourd') == 0)) {
		try {
			if (!Player::loginExists($_POST['login'])) {
				$player = new Player();
				$player->defaultValues();
				$player->setNom($_POST['login']);
				$player->setPass($_POST['pass']);
				$player->setSex($_POST['sex']);
				$player->setPhoto($_POST['sex'] ? 'images/tete_faluche_noir_bleu.jpg' : 'images/tete_faluche_noir_rose.jpg');
				$player->create();
				Item::associate($player->getId(), 12);
				Item::associate($player->getId(), 13);
				Item::associate($player->getId(), 13);
				echo 'Inscription ok';
			} else {
				$errorMessage = 'Ce surnom existe déja.';
			}
		} catch (Exception $e) {
			echo $e;
			$errorMessage = 'Probleme avec la BDD: ' . $e;
		}
	} else {
		$errorMessage = 'Vous êtes un robot.';
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="icon" type="image/png" href="images/items/cle de fa.png">
<style type="text/css">
th {
	text-align: right;
	width: 100px;
}

td {
	text-align: left;
	width: 300px;
}

.intro {
	font-size: 18px;
	margin: 10px;
}
</style>
</head>
<body>
	<div id="header">Soluche</div>
	<div class="intro">Un RPG sans elf ni orc, sans point de vie ou de mana. Où ton inventaire n'est pas une épée runique et une armure enchantée.</div>
	<div class="intro">Combat tes rivaux à coup de secs, chante, partage des valeurs, essaye de chopper et prends garde à ne pas finir en PLS.</div>
	<br />
	<?php if ($errorMessage) {?>
	<div class="errorMessage"><?php echo $errorMessage; ?></div>
	<?php } ?>
	<br />
	<form action="" method="post">
		<table>
			<tr>
				<th>Surnom</th>
				<td>
					<input type="text" id="login" name="login" value="">
				</td>
			</tr>
			<tr>
				<th>Pass</th>
				<td>
					<input type="password" id="pass" name="pass" value="">
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" id="ok" name="ok" value="Ok">
				</td>
			</tr>
		</table>
	</form>
	<br />
	<a onclick="javascript:document.getElementById('FormNew').style.display='block';return false;">s'inscrire</a>
	<br />
	<form action="" method="post" id="FormNew" style="display: none;">
		<table>
			<tr>
				<th>Surnom</th>
				<td>
					<input type="text" id="login" name="login" value="">
				</td>
			</tr>
			<tr>
				<th>Pass</th>
				<td>
					<input type="password" id="pass" name="pass" value="">
				</td>
			</tr>
			<tr>
				<th>Sex</th>
				<td>
					<label title="vagin"><input type="radio" name="sex" value="0" checked="checked" /><span style="color: pink">&#9792;</span></label><br /> <label title="bite"><input
							type="radio" name="sex" value="1" /><span style="color: cyan">&#9794;</span></label>
				</td>
			</tr>
			<tr>
				<th>je ne suis pas un robot:</th>
				<td>
					Que signifie cet insigne?
					<img src="images/badges/pachyderme.jpg" width="50" height="50" title="pachy">
					<br />
					<input type="text" id="robot" name="robot" value="">
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" id="new" name="new" value="Ok">
				</td>
			</tr>
		</table>
	</form>
	<div style="font-size: 10px; color: silver;" title="tu as perdu au jeu! ;-)">v 1.9</div>
	<a href="https://github.com/yannickbattail/soluche"><img style="position: absolute; top: 0; right: 0; border: 0;" src="images/Fork me on GitHub.png" alt="Fork me on GitHub"></a>
</body>
</html>

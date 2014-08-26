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
$successMessage = '';
if (isset($_REQUEST['logout'])) {
	unset($_SESSION['user']);
	unset($_SESSION['history']);
}

if (isset($_SESSION['user']) && ($_SESSION['user'] instanceof Player)) {
	header('Location: main.php');
}

if (isset($_POST['ok']) && isset($_POST['login']) && isset($_POST['pass'])) {
	try {
		$res = Player::login($_POST['login'], $_POST['pass']);
		if ($res === null) {
			$errorMessage = 'Mot de passe ou surnom incorrect.';
		} else {
			$_SESSION['user'] = $res;
			header('Location: main.php');
		}
	} catch (Exception $e) {
		echo $e;
		$errorMessage = 'Soucis de connection a la BDD: ' . $e;
	}
}

/**
 *
 * @return boolean Item
 */
function randItem() {
	$sth = $GLOBALS['DB']->prepare('SELECT * FROM item ORDER BY RAND() LIMIT 1');
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	if ($sth->execute() === false) {
		// var_dump($sth->errorInfo());
		return false;
	}
	$arr = $sth->fetch();
	if (!$arr) {
		return false;
	} else {
		$obj = new Item();
		$obj->populate($arr);
		return $obj;
	}
}

if (isset($_POST['Forgotten']) && isset($_POST['login']) && isset($_POST['email'])) {
	try {
		$user = Player::loginExists($_POST['login']);
		if ($user === false) {
			$errorMessage = 'Ce surnom n\'existe pas.';
		} else {
			if ($user->getEmail() != $_POST['email']) {
				$errorMessage = 'e-mail invalide.';
			} else {
				$item = randItem();
				$user->setPass($item->getInternal_name());
				$user->save();
				$successMessage = 'Le mot de passe a été changé pour: <b>' . $item->getInternal_name() . '</b>' . '<br />aller ici <img style="width: 16px; height: 16px;" title="Editer" alt="Editer" src="images/util/edit_user.png"> pour le changer.';
			}
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
				$player->setEmail($_POST['email']);
				$player->setSex($_POST['sex']);
				$player->setPhoto($_POST['sex'] ? 'images/tete_faluche_noir_bleu.jpg' : 'images/tete_faluche_noir_rose.jpg');
				$player->create();
				$_SESSION['user'] = $player;
				Item::associateItem($player, Item::loadByName('eco_cup'));
				$his = new History();
				$his->defaultValues();
				$his->setId_player($player->getId());
				$his->setSuccess(ActionResult::SUCCESS);
				$his->setMessage('Inscriction à Soluche. Bienvenue!');
				$his->setAction_name('inscription');
				$his->save();
				$successMessage = 'Inscription ok';
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
<link rel="icon" type="image/png" href="images/soluche_icon.png">
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
	<?php if ($successMessage) {?>
	<div class="successMessage"><?php echo $successMessage; ?></div>
	<?php } ?>
	<br />
	<form action="" method="post">
		<table class="playerStats">
			<tr class="odd">
				<th>Surnom</th>
				<td>
					<input type="text" id="login" name="login" value="">
				</td>
			</tr>
			<tr class="even">
				<th>Pass</th>
				<td>
					<input type="password" id="pass" name="pass" value="">
				</td>
			</tr>
			<tr class="odd">
				<th></th>
				<td>
					<input type="submit" id="ok" name="ok" value="Ok">
				</td>
			</tr>
		</table>
	</form>
	<br />
	<a onclick="javascript:document.getElementById('FormNew').style.display='block';return false;">s'inscrire.</a>
	<br />
	<a onclick="javascript:document.getElementById('FormForgotten').style.display='block';return false;">Mot de passe oublié.</a>
	<br />
	<form action="" method="post" id="FormNew" style="display: none;">
		<table class="playerStats">
			<tr class="odd">
				<th>Surnom</th>
				<td>
					<input type="text" id="login" name="login" value="" />
				</td>
			</tr>
			<tr class="even">
				<th>Pass</th>
				<td>
					<input type="password" id="pass" name="pass" value="" />
				</td>
			</tr>
			<tr class="odd">
				<th>E-mail</th>
				<td>
					<input type="text" id="email" name="email" value="" />
					Facultatif (sert en cas de perte du mot de passe et plus tard pour les notifications)
				</td>
			</tr>
			<tr class="even">
				<th>Sex</th>
				<td>
					<label title="vagin"><input type="radio" name="sex" value="0" checked="checked" /><span style="color: pink">&#9792;</span></label><br /> <label title="bite"><input
							type="radio" name="sex" value="1" /><span style="color: cyan">&#9794;</span></label>
				</td>
			</tr>
			<tr class="odd">
				<th>je ne suis pas un robot:</th>
				<td>
					Que signifie cet insigne? <br />
					<input type="text" id="robot" name="robot" value="" />
					<img src="images/badges/pachyderme.jpg" width="50" height="50" title="pachy">
				</td>
			</tr>
			<tr class="even">
				<th></th>
				<td>
					<input type="submit" id="new" name="new" value="Ok" />
				</td>
			</tr>
		</table>
	</form>
	<form action="" method="post" id="FormForgotten" style="display: none;">
		<table class="playerStats">
			<tr class="odd">
				<th>Surnom</th>
				<td>
					<input type="text" id="login" name="login" value="">
				</td>
			</tr>
			<tr class="even">
				<th>E-mail</th>
				<td>
					<input type="text" id="email" name="email" value="">
				</td>
			</tr>
			<tr class="odd">
				<th></th>
				<td>
					<input type="submit" id="Forgotten" name="Forgotten" value="reset du mot de passe">
				</td>
			</tr>
		</table>
	</form>
	<div style="font-size: 10px; color: silver;" title="tu as perdu au jeu! ;-)">v 1.12</div>
</body>
</html>

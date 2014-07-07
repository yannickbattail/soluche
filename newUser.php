<?php
session_start();
require_once ('db.php');
require_once ('classes/Player.class.php');

$errorMessage = '';
if (isset($_REQUEST['logout'])) {
	$_SESSION['user'] = array();
}

if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['robot'])) {
	if ($_POST['robot'] == '42') {
		try {
			if (!Player::loginExists($_POST['login'])) {
				$player = new Player();
				$player->defaultValues();
				$player->nom = $_POST['login'];
				$player->pass = $_POST['pass'];
				$player->create();
				echo 'Inscription ok';
				header('Location: login.php');
			} else {
				$errorMessage = 'Ce surnom existe d�j�.';
			}
		} catch (Exception $e) {
			echo $e;
			$errorMessage = 'Probleme avec la BDD: ' . $e;
		}
	} else {
		$errorMessage = 'Vous �tes un robot.';
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Inscription</title>
<style type="text/css">
.errorMessage {
	color: red;
}
</style>
</head>
<body>
	<h1>Inscription</h1>
	<div class="errorMessage"><?php echo $errorMessage; ?></div>

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
				<th>je ne suis pas un robot:</th>
				<td>
					Quelle est La réponse la Grande Question sur la Vie, l'Univers et le Reste?<br />
					<input type="text" id="robot" name="robot" value="">
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
</body>
</html>

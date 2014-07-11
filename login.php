<?php
session_start();
require_once ('db.php');
require_once ('classes/player.class.php');

$errorMessage = '';
if (isset($_REQUEST['logout'])) {
	$_SESSION['user'] = array();
}

if (isset($_POST['login']) && isset($_POST['pass'])) {
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

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche</title>
<style type="text/css">
.errorMessage {
	color: red;
}
</style>
</head>
<body>
	<h1>Soluche</h1>
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
				<th></th>
				<td>
					<input type="submit" id="ok" name="ok" value="Ok">
				</td>
			</tr>
		</table>
	</form>
	<a href="newUser.php">s'inscrire</a>
</body>
</html>

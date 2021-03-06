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
require_once ('utilFunctions.php');

if (!isset($_SESSION['user']) || !$_SESSION['user']) {
	header('Location: login.php');
}
$_SESSION['user'] = Player::load($_SESSION['user']->getId());
$_SESSION['user']->loadInventory();

if ($_SESSION['user']->getId() != 1) {
	die('must be admin');
}

if (isset($_POST['addBots'])) {
	echo 'add ' . Bot::createMultiples(10000) . ' Bots';
}

if (isset($_POST['reorganiseBots'])) {
	echo 'reorganise ' . Bot::reorganiseBots() . ' bots.';
}

if (isset($_POST['savePlayer'])) {
	$player = Player::load($_POST['id'])->loadInventory();
	foreach ($_POST as $key => $value) {
		if (($key != 'id') && ($key != 'savePlayer')) {
			if ($value == 'NULL') {
				$value = null;
			}
			$method = 'set' . ucfirst($key);
			echo $key . '=' . $value . ' ';
			$player->$method($value);
		}
	}
	$player->save();
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche: admin</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/ui-darkness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/ui-darkness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
	<h1>admin</h1>

	<a href="adminCode.php">admin codes</a>
	<h3>congress list:</h3>

	<table class="inventory">
		<tr>
			<th>Nom</th>
			<th>1/4 Heures</th>
			<th>Bot number</th>
			<th>Bot coef</th>
			<th>level</th>
			<th>edit</th>
		</tr>
			<?php
			$congressList = array('NULL' => 'NULL');
			$n = 0;
			$sth = $GLOBALS['DB']->query('SELECT * FROM congress ;');
			$sth->setFetchMode(PDO::FETCH_ASSOC);
			while ($sth && ($arr = $sth->fetch())) {
				$congress = new Congress();
				$congress->populate($arr);
				$congressList[$congress->getId()] = $congress->getNom();
				$odd = ($n++ % 2) ? 'odd' : 'even';
				?>
	        <tr class="<?= $odd ?>">
			<td><?= $congress->getNom(); ?></td>
			<td><?= $congress->getAction_number(); ?></td>
			<td><?= $congress->getBot_number(); ?></td>
			<td><?= $congress->getBot_coef(); ?></td>
			<td><?= $congress->getLevel(); ?></td>
			<td>
				<a href="adminCongress.php?id_congress=<?= $congress->getId(); ?>"><img src="images/util/edit_user.png" alt="Editer" title="Editer" style="width: 16px; height: 16px;"></a>
			</td>
		</tr>
        <?php } ?>
	</table>
	<form action="" method="post">
		<input type="submit" name="addBots" value="create bots" />
		<input type="submit" name="reorganiseBots" value="reorganise bots" />
		<a href="adminCongress.php?id_congress=-1">new congress</a>
	</form>
	
	<h3>players list:</h3>
	<table class="inventory">
		<tr>
			<th>Nom</th>
			<th>pass</th>
			<th>lieu</th>
			<th>pts</th>
			<th>notoriete</th>
			<th>Alc</th>
			<th>Alc opt</th>
			<th>Alc max</th>
			<th>Fatigue</th>
			<th>Fatigue max</th>
			<th>x appeal</th>
			<th>pls</th>
			<th>debut de pls</th>
			<th>sex</th>
			<th>photo</th>
			<th>pnj</th>
			<th>congres</th>
			<th>save</th>
		</tr>
<?php
$num = 0;
$sth = $GLOBALS['DB']->query('SELECT * FROM player ;');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$player = new Player();
	$player->populate($arr);
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
		<form action="" method="post">
			<tr class="<?= $odd ?>">
				<td>
					<input type="text" name="nom" title="nom" value="<?=$player->getNom()?>" />
				</td>
				<td>
					<input type="text" name="pass" title="pass" value="<?=$player->getPass()?>" />
				</td>
				<td>
					<input type="text" name="lieu" title="lieu" value="<?=$player->getLieu()?>" style="width: 50px;" />
				</td>
				<td>
					<input type="text" name="points" title="points" value="<?=$player->getPoints()?>" class="int" />
				</td>
				<td>
					<input type="text" name="notoriete" title="notoriete" value="<?=$player->getNotoriete()?>" class="int" />
				</td>
				<td>
					<input type="text" name="alcoolemie" title="alcoolemie" value="<?=$player->getAlcoolemie()?>" class="int" />
				</td>
				<td>
					<input type="text" name="alcoolemie_optimum" title="alcoolemie_optimum" value="<?=$player->getAlcoolemie_optimum()?>" class="int" />
				</td>
				<td>
					<input type="text" name="alcoolemie_max" title="alcoolemie_max" value="<?=$player->getAlcoolemie_max()?>" class="int" />
				</td>
				<td>
					<input type="text" name="fatigue" title="fatigue" value="<?=$player->getFatigue()?>" class="int" />
				</td>
				<td>
					<input type="text" name="fatigue_max" title="fatigue_max" value="<?=$player->getFatigue_max()?>" class="int" />
				</td>
				<td>
					<input type="text" name="sex_appeal" title="sex_appeal" value="<?=$player->getSex_appeal()?>" class="int" />
				</td>
				<td style="width: 40px; text-align: left;">
					<label><input type="radio" name="en_pls" value="0" <?=$player->getEn_pls()==0?'checked="checked"':''?> />non</label><br /> <label><input type="radio" name="en_pls" value="1"
							<?=$player->getEn_pls()==1?'checked="checked"':''?> />oui</label>
				</td>
				<td>
					<input type="text" name="debut_de_pls" title="debut_de_pls" value="<?=$player->getDebut_de_pls()?>" />
				</td>
				<td style="width: 40px;">
					<label><input type="radio" name="sex" value="0" <?=$player->getSex()==0?'checked="checked"':''?> /><span style="color: pink">&#9792;</span></label><br /> <label><input
							type="radio" name="sex" value="1" <?=$player->getSex()==1?'checked="checked"':''?> /><span style="color: blue">&#9794;</span></label>
				</td>
				<td>
					<input type="text" name="photo" title="photo" value="<?=$player->getPhoto()?>" />
					<br />
					<img src="<?= $player->getPhoto() ?>" class="inventoryImage" title="<?= $player->getNom() ?>" />
				</td>
				<td style="width: 60px; text-align: left;">
					<label><input type="radio" name="pnj" value="0" <?=$player->getPnj()==0?'checked="checked"':''?> />player</label><br /> <label><input type="radio" name="pnj" value="1"
							<?=$player->getPnj()==1?'checked="checked"':''?> />bot</label><br /> <label><input type="radio" name="pnj" value="2" <?=$player->getPnj()==2?'checked="checked"':''?> />orga</label>
				</td>
				<td>
					<select name="id_congress">
					<?php foreach ($congressList as $id_congress => $nom_congress) { ?>
						<option value="<?= $id_congress ?>" <?=$player->getId_congress()==$id_congress?'selected="selected"':''?>><?= $nom_congress ?></option>
					<?php } ?>
					</select>
				</td>
				<td>
					<input type="text" name="remaining_time" title="remaining_time" value="<?=$player->getRemaining_time()?>" class="int" />
				</td>
				<td>
					<input type="text" name="money" title="money" value="<?=$player->getMoney()?>" class="int" />
				</td>
				<td>
					<input type="hidden" name="id" value="<?=$player->getId()?>" />
					<input type="submit" name="savePlayer" value="save" />
				</td>
			</tr>
		</form>
	<?php } ?>
	
</table>

</body>
</html>

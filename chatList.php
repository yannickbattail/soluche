<?php
error_reporting(E_ALL | E_STRICT | E_NOTICE);
ini_set('error_reporting', E_ALL | E_STRICT | E_NOTICE);
ini_set('display_errors', 1);

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

if (!isset($_SESSION['user']) || !($_SESSION['user'] instanceof Player)) {
	die('pas loggé');
}

$_SESSION['user'] = Player::load($_SESSION['user']->getId());
// $_SESSION['user']->loadInventory();

/* ------ html ------- */

$sql = 'SELECT player.*, ( ';
$sql .= '    SELECT count(*) AS count_1';
$sql .= '    FROM chat WHERE recipient=:id AND sender=player.id AND is_new=1 ';
$sql .= ') AS new_messages ';
$sql .= 'FROM player WHERE pnj=0 AND id != :id ORDER BY new_messages DESC;';
$sth = $GLOBALS['DB']->prepare($sql);
$sth->bindValue(':id', $_SESSION['user']->getId(), PDO::PARAM_INT);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$contact = new Player();
	$contact->populate($arr);
	?>
<div style="border-style: outset; margin: 5px; border-radius: 3px; display: block; width: 250px; height: 64px; vertical-align: middle;"
	onclick="showChat(<?= $contact->getId()?>, '<?= str_replace("'", "\'", htmlentities($contact->getNom())) ?>');">
	<img src="<?= $contact->getPhoto()?>" class="playerImage" style="vertical-align: middle;" alt="<?= $contact->getNom()?>" title="<?= $contact->getNom()?>">
			<?= $contact->getNom()?> <span style="color: red; vertical-align: middle;">(<?= $arr['new_messages'] ?>)</span>
</div>
<?php
}

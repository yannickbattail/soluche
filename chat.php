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
//$_SESSION['user']->loadInventory();

$opponent = Player::load($_REQUEST['id_player']);


/* ------ treatment ------- */

if (!isset($_REQUEST['id_player'])) {
	die('pas de joueur specifié (param: id_player)');
}

if (isset($_REQUEST['message'])) {
	Chat::sendMessage($opponent, $_REQUEST['message']);
}

/* ------ html ------- */

$GLOBALS['DB']->query('UPDATE chat SET is_new = 0 WHERE recipient='.$_SESSION['user']->getId().' AND chat.sender='.$opponent->getId().' ;');
$n = 0;
//$sth = $GLOBALS['DB']->query('SELECT * FROM ( SELECT * FROM chat '
$sth = $GLOBALS['DB']->query('SELECT time_sent, sender.nom AS sender_nom, sender.id AS sender_id, message FROM chat '
		.'INNER JOIN player AS sender ON chat.sender = sender.id '
		.'INNER JOIN player AS recipient ON chat.recipient = recipient.id '
		.'WHERE ( chat.recipient='.$opponent->getId().' AND chat.sender='.$_SESSION['user']->getId().' ) '
		.'   OR ( chat.recipient='.$_SESSION['user']->getId().' AND chat.sender='.$opponent->getId().' ) '
		.'ORDER BY time_sent DESC LIMIT 20 ;');
		//.'ORDER BY time_sent DESC LIMIT 20 ) AS c ORDER BY time_sent ASC ;');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
	<div>
		<span class="chatDate"><?= date('Y/m/d H:i:s', $arr['time_sent']) ?></span>
		<span class="chatPlayerName" <?= ($arr['sender_id']==$_SESSION['user']->getId())?'style="color: #ffcc11;"':'' ?>><?= $arr['sender_nom'] ?>:</span>
		<span class="chatMessage"><?= htmlentities($arr['message']) ?></span>
	</div>
    <?php
}
	
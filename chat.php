<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */

if (!isset($_REQUEST['id_player'])) {
	die('pas de joueur specifié (param: id_player)');
}

$opponent = Player::load($_REQUEST['id_player']);

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
	
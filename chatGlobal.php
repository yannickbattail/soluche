<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */

if (isset($_REQUEST['message'])) {
	Chat::sendGlobalMessage($_REQUEST['message']);
}

/* ------ html ------- */

$n = 0;
$sth = $GLOBALS['DB']->query('SELECT * FROM chat INNER JOIN player ON chat.sender = player.id WHERE recipient IS NULL ORDER BY time_sent DESC LIMIT 20;');
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	?>
<div>
	<span class="chatDate"><?= date('Y/m/d H:i:s', $arr['time_sent']) ?></span> <span class="chatPlayerName"><?= $arr['nom'] ?>:</span> <span class="chatMessage"><?= $arr['message'] ?></span>
</div>
<?php
}
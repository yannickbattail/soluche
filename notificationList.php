<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */

if (isset($_REQUEST['message'])) {
	Chat::sendGlobalMessage($_REQUEST['message']);
}

/* ------ html ------- */

$n = 0;
$sth = $GLOBALS['DB']->prepare('SELECT * FROM notification WHERE id_player = :id_player ORDER BY time_sent DESC LIMIT 20;');
$sth->bindValue(':id_player', $_SESSION['user']->getId(), PDO::PARAM_STR);
$sth->setFetchMode(PDO::FETCH_ASSOC);
$sth->execute();
while ($sth && ($arr = $sth->fetch())) {
	$odd = ($n++ % 2) ? 'odd' : 'even';
	$obj = new Notification();
	$obj->populate($arr);
	?>
<div class="<?= $obj->getIs_new()?'odd':'even' ?>">
	<span class="chatDate"><?= date('Y/m/d H:i:s', $obj->getTime_sent()) ?></span> <span class="chatMessage"><?= $obj->getMessage() ?></span>
</div>
<?php
}
$sth = $GLOBALS['DB']->prepare('UPDATE notification SET is_new = 0 WHERE id_player = :id_player AND is_new = 1;');
$sth->bindValue(':id_player', $_SESSION['user']->getId(), PDO::PARAM_STR);
$sth->execute();

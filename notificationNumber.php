<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */

if (isset($_REQUEST['message'])) {
	Chat::sendGlobalMessage($_REQUEST['message']);
}

/* ------ html ------- */

$n = 0;
$sth = $GLOBALS['DB']->prepare('SELECT count(id) AS notification_nb FROM notification WHERE id_player = :id_player  AND is_new = 1;');
$sth->bindValue(':id_player', $_SESSION['user']->getId(), PDO::PARAM_STR);
$sth->setFetchMode(PDO::FETCH_ASSOC);
$sth->execute();
$arr = $sth->fetch();
?>
<div style="background-image : url(images/util/<?= $arr['notification_nb']?'icon_notification_animation.gif':'icon_notification.gif' ?>);"><?= $arr['notification_nb'] ?></div>

<?php
require_once ('ajaxInit.php');

/* ------ html ------- */

$sql = 'SELECT player.*, ( ';
$sql .= '    SELECT count(*) AS count_1';
$sql .= '    FROM chat WHERE recipient=:id AND sender=player.id AND is_new=1 ';
$sql .= ') AS new_messages ';
$sql .= 'FROM player WHERE pnj=0 AND id != :id ORDER BY new_messages DESC, player.nom ASC;';
$sth = $GLOBALS['DB']->prepare($sql);
$sth->bindValue(':id', $_SESSION['user']->getId(), PDO::PARAM_INT);
$sth->execute();
$sth->setFetchMode(PDO::FETCH_ASSOC);
while ($sth && ($arr = $sth->fetch())) {
	$contact = new Player();
	$contact->populate($arr);
	?>
<div style="border-style: outset; margin: 5px; border-radius: 3px; display: block; width: 250px; height: 64px; vertical-align: middle;">
	<img src="<?= $contact->getPhoto()?>" class="playerImage" style="vertical-align: middle;" alt="<?= $contact->getNom()?>" title="<?= $contact->getNom()?>" onclick="showChat(<?= $contact->getId()?>, '<?= str_replace("'", "\'", htmlentities($contact->getNom())) ?>');">
	<span onclick="showChat(<?= $contact->getId()?>, '<?= str_replace("'", "\'", htmlentities($contact->getNom())) ?>');"><?= $contact->getNom()?></span>
	<span style="color: red; vertical-align: middle;">(<?= $arr['new_messages'] ?>)</span>
	<span class="action" style="vertical-align: middle; text-align: right;" onclick="showinvite(<?= $contact->getId()?>, '<?= str_replace("'", "\'", htmlentities($contact->getNom())) ?>')"><img src="images/items/panda.png" class="" style="vertical-align: middle; width: 24px; height: 24px;" alt="traquenarder" title="traquenarder"></span>	
</div>
<?php
}

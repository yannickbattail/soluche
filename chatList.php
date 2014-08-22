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
<div style="border-style: outset; margin: 5px; border-radius: 3px; display: block; width: 250px; height: 64px; vertical-align: middle;"
	onclick="showChat(<?= $contact->getId()?>, '<?= str_replace("'", "\'", htmlentities($contact->getNom())) ?>');">
	<img src="<?= $contact->getPhoto()?>" class="playerImage" style="vertical-align: middle;" alt="<?= $contact->getNom()?>" title="<?= $contact->getNom()?>">
			<?= $contact->getNom()?> <span style="color: red; vertical-align: middle;">(<?= $arr['new_messages'] ?>)</span>
</div>
<?php
}

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche</title>
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>
	<div id="header">Soluche</div>

	<div>
	<?php
	foreach (Dispatcher::getMessages() as $em) {
		echo '<div class="' . $em['level'] . '">' . htmlentities($em['message']) . '</div>';
	}
	?>
	</div>
	<table id="skeleton">
		<tr>
			<td>
				<div id="menu">
					<div class="login">
						<img src="<?=$_SESSION['user']->getPhoto() ?>" title="<?= $_SESSION['user']->getNom() ?>" style="max-width: 200px; max-height: 200px;" />
						<br />
						<?=$_SESSION['user']->getNom(); ?> <?php echo $_SESSION['user']->getSex()?'<span style="color:cyan" title="bite">&#9794;</span>':'<span style="color:pink" title="vagin">&#9792;</span>'; ?>
						<a href="userCutomisation.php"><img src="images/util/edit_user.png" alt="Editer" title="Editer" style="width: 16px; height: 16px;"></a> <a href="login.php?logout=1"><img
								src="images/util/system-shutdown.png" alt="Quitter" title="Quitter" style="width: 16px; height: 16px;"></a>
					</div>
					<?php if ($_SESSION['user']->getId_congress() != 0) { ?>
					<div class="congress" title="Congrès en cours">
						Au congrès <?=$_SESSION['user']->getCongress()->getNom()?>.
						<br />Temps restant: <?=$_SESSION['user']->getRemaining_time()?> <img src="images/util/time-used.png" alt="¼ d'heure" width="16" height="16">
					</div>
					<?php } ?>
					<?php printUserStats($_SESSION['user']); ?>
					<?php printInventory2($_SESSION['user']); ?>
					Chat:
					<div class="playerBox" style="overflow-y: scroll; width: 290px; height: 500px;">
					<?php
					$sql = 'SELECT player.*, ( ';
					$sql .= '    SELECT count(*) AS count_1';
					$sql .= '    FROM chat WHERE recipient=' . $_SESSION['user']->getId() . ' AND sender=player.id AND is_new=1 ';
					$sql .= ') AS new_messages ';
					$sql .= 'FROM player WHERE pnj=0 AND id != ' . $_SESSION['user']->getId() . ' ORDER BY new_messages DESC;';
					$sth = $GLOBALS['DB']->query($sql);
					$sth->setFetchMode(PDO::FETCH_ASSOC);
					while ($sth && ($arr = $sth->fetch())) {
						$player = new Player();
						$player->populate($arr);
						?>
						<div style="border-style: outset; margin: 5px; border-radius: 3px; display: block; width: 250px; height: 64px; vertical-align: middle;"
							onclick="showChat(<?= $player->getId()?>, '<?= str_replace("'", "\'", htmlentities($player->getNom())) ?>')">
							<img src="<?= $player->getPhoto()?>" class="playerImage" style="vertical-align: middle;" alt="<?= $player->getNom()?>" title="<?= $player->getNom()?>">
							<?= $player->getNom()?> <span style="color: red;vertical-align: middle;">(<?= $arr['new_messages'] ?>)</span>
						</div>
					<?php } ?>
					</div>
					<div id="dialog" title="Chat box" style="display: none;">
						<div id="chatContent" style="overflow: scroll; height: 200px; width: 500px;"></div>
						<form action="main.php?action=SendMessage&prevent_reexecute=<?= $_SESSION['prevent_reexecute'] ?>" method="post"
							onsubmit="if (document.getElementById('message').value == ''){ return false;}">
							<input type="text" name="chatMessage" id="chatMessage" value="" />
							<input type="hidden" name="id_player" id="id_player" value="" size="2" />
							<input type="submit" name="SendMessage" value="message global" onclick="return sendMessage();" />
						</form>
					</div>
					<script type="text/javascript">
					function showChat(id_player, player_name) {
					    $("#dialog").dialog({
						    title: "Chat avec " + player_name,
					        height:280,
					        width:540
					        });
					    $("#id_player").val(id_player);
					    $("#chatContent").load("chat.php?id_player="+id_player);
					}
					function sendMessage() {
					    $("#chatContent").load("chat.php?id_player="+$("#id_player").val()+'&message='+encodeURIComponent($("#chatMessage").val()));
					    $("#chatMessage").val('');
					    return false;
					}
					</script>
				</div>
			</td>
			<td>
				<div id="content">
					<table class="tabBar">
						<tr>
							<td <?= (Dispatcher::getPage() == 'camping')?'class="tabBarSelected"':''  ?>>
								<a href="main.php?page=camping">Camping</a>
							</td>
							<td <?= (Dispatcher::getPage() == 'orga')?'class="tabBarSelected"':''  ?>>
								<a href="main.php?page=orga">Coin des orgas</a>
							</td>
							<td <?= (Dispatcher::getPage() == 'bar')?'class="tabBarSelected"':''  ?>>
								<a href="main.php?page=bar">Bar</a>
							</td>
							<td <?= (Dispatcher::getPage() == 'tente')?'class="tabBarSelected"':''  ?>>
								<a href="main.php?page=tente">Ta tente</a>
							</td>
							<td <?= (Dispatcher::getPage() == 'cuisine')?'class="tabBarSelected"':''  ?>>
								<a href="main.php?page=cuisine">Cuisine</a>
							</td>
							<td <?= (Dispatcher::getPage() == 'danse')?'class="tabBarSelected"':''  ?>>
								<a href="main.php?page=danse">Piste de danse</a>
							</td>
						</tr>
					</table>
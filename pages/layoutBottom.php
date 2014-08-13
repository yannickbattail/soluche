</td>
</tr>
</table>
</div>
<div id="footer">
	<div id="globalMessages">
	<?php
	$n = 0;
	$sth = $GLOBALS['DB']->query('SELECT * FROM chat INNER JOIN player ON chat.sender = player.id WHERE recipient IS NULL ORDER BY time_sent DESC LIMIT 20;');
	$sth->setFetchMode(PDO::FETCH_ASSOC);
	while ($sth && ($arr = $sth->fetch())) {
		$odd = ($n++ % 2) ? 'odd' : 'even';
		?>
	<div>
		<span class="chatDate"><?= date('Y/m/d H:i:s', $arr['time_sent']) ?></span>
		<span class="chatPlayerName"><?= $arr['nom'] ?>:</span>
		<span class="chatMessage"><?= htmlentities($arr['message']) ?></span>
	</div>
        <?php
	}
	?>
	
	</div>
	<form action="main.php?action=SendGlobalMessage&prevent_reexecute=<?= $_SESSION['prevent_reexecute'] ?>" method="post"
		onsubmit="if (document.getElementById('message').value == ''){ return false;} else { return confirm('Envoyer un message global coute 1 en dignichose. Etes-vous sûr?');}">
		<input type="text" name="message" id="message" value="" />
		<input type="submit" name="SendGlobalMessage" value="message global" />
	</form>
	<div style="font-size: 10px; color: silver;" title="tu as perdu au jeu! ;-)">v 1.9</div>
</div>
</body>
</html>

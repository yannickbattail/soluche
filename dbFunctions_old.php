<?php

function dbLogin($login, $pass) {
	$sth = $GLOBALS['DB']->prepare('SELECT * FROM players WHERE nom=:nom AND pass=:pass;');
	$sth->bindValue(':nom', $login, PDO::PARAM_STR);
	$sth->bindValue(':pass', $pass, PDO::PARAM_STR);
	if ($sth->execute() === false) {
		// var_dump($sth->errorInfo());
		return false;
	}
	return $sth->fetch(PDO::FETCH_ASSOC);
}

function dbGetInventory($playerId) {
	return $GLOBALS['DB']->query('SELECT O.* FROM objet O ' . 'INNER JOIN inventory I ON I.idobject = O.id ' . 'WHERE I.idplayer = ' . $playerId . ';');
}

function dbGetCalculatedUser($playerId) {
	$user = $GLOBALS['DB']->query('SELECT * FROM players WHERE id=' . $playerId . ';')->fetch(PDO::FETCH_ASSOC);
	$userCalc = array_merge($user);
	$inventory = array();
	
	$sth = $GLOBALS['DB']->query('SELECT O.* FROM objet O ' . 'INNER JOIN inventory I ON I.idobject = O.id ' . 'WHERE I.idplayer = ' . $playerId . ';');
	
	while ($sth && ($objet = $sth->fetch(PDO::FETCH_ASSOC))) {
		$inventory[] = $objet;
		if ($objet['permanent']) {
			$userCalc['notoriete'] += $objet['notoriete'];
			$userCalc['alcoolemie'] += $objet['alcoolemie'];
			$userCalc['alcoolemie_optimum'] += $objet['alcoolemie_optimum'];
			$userCalc['alcoolemie_max'] += $objet['alcoolemie_max'];
			$userCalc['fatigue'] += $objet['fatigue'];
			$userCalc['fatigue_max'] += $objet['fatigue_max']; // sex_appeal
			$userCalc['sex_appeal'] += $objet['sex_appeal'];
		}
	}
	$user['userCalc'] = $userCalc;
	$user['inventory'] = $inventory;
	return $user;
}

<?php
class Bot extends Player {

	private static $filieres = array('Ingé', 'rose', 'droit', 'sciences', 'sage-pouf', 'jaune', 'Pharma', 'Médecine', 'Dentaire', 'ostéo', 'Véto', 'prépa', 'Archi', 'Commerce', 'IUT', 'STAPS', 'Musico', 'Oenologie', 'Sc éco', 'Sc po');

	private static $villes = array('Annecy', 'Grenoble', 'Lyon', 'Monpeul', 'Valence', 'Aix', 'Marseille', 'Dijon', 'Toulouse', 'Nancy', 'Strasbourg', 'Paris');

	private static $location = array('camping', 'bar', 'cuisine', 'danse', 'orga', /*'tente'*/);

	public function defaultValues($factor = 1) {
		$this->setPass('');
		$this->setLieu(self::$location[rand(0, count(self::$location) - 1)]);
		$this->setPoints(0);
		$this->setNotoriete(floor(rand(4, 10) * $factor));
		$this->alcoolemie_optimum = floor(rand(5, 8) * $factor);
		$this->alcoolemie_max = floor(rand(9, 12) * $factor);
		$this->alcoolemie = floor(rand(2, 7) * $factor);
		$this->fatigue_max = floor(rand(7, 10) * $factor);
		$this->fatigue = floor(rand(1, 7) * $factor);
		$this->setSex_appeal(floor(rand(5, 10) * $factor));
		$this->setEn_pls(0);
		$this->setDebut_de_pls(0);
		$this->setSex(rand(0, 1));
		$this->setPhoto($this->getSex() ? 'images/tete_faluche_bleu.jpg' : 'images/tete_faluche_rose.jpg');
		$this->setRemaining_time(10);
		$this->setMoney(50);
		$this->setPnj(Player::PNJ_BOT);
	}

	public static function createMultiples($number, $factor = 1, $id_congress = null) {
		$nb = 0;
		foreach (self::$villes as $ville) {
			foreach (self::$filieres as $filiere) {
				$name = $filiere . ' ' . $ville;
				if (!Player::loginExists($name)) {
					$bot = new bot();
					$bot->setNom($name);
					$bot->defaultValues(1);
					$bot->setId_congress($id_congress);
					$bot->save();
					$nb++;
				}
				if ($number == $nb) {
					return $nb;
				}
			}
		}
		return $nb;
	}

	public static function resetBots($factor = 1, $id_congress = null) {
		$sql = 'SELECT * FROM player WHERE pnj = 1 ';
		if ($id_congress) {
			$sql .= ' AND id_congress = ' . $id_congress;
		}
		$sth = $GLOBALS['DB']->query($sql);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		while ($sth && ($arr = $sth->fetch())) {
			$bot = new self();
			$bot->populate($arr);
			$bot->defaultValues($factor);
			$bot->save();
		}
	}

	public static function reorganiseBots() {
		$nb = 0;
		$GLOBALS['DB']->query('UPDATE player SET id_congress = NULL WHERE pnj = 1 ;');
		$sth = $GLOBALS['DB']->query('SELECT * FROM congress ;');
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		while ($sth && ($arr = $sth->fetch())) {
			$congress = new Congress();
			$congress->populate($arr);
			$sql = 'SELECT * FROM player WHERE pnj = 1 AND id_congress IS NULL LIMIT ' . $congress->getBot_number() . ';';
			$sth2 = $GLOBALS['DB']->query($sql);
			$sth2->setFetchMode(PDO::FETCH_ASSOC);
			while ($sth2 && ($arr = $sth2->fetch())) {
				$bot = new self();
				$bot->populate($arr);
				$bot->defaultValues($congress->getBot_coef());
				$bot->setId_congress($congress->getId());
				$bot->save();
				$nb++;
			}
		}
		return $nb;
	}

	/**
	 * no PLS for a bot
	 *
	 * @see Player::setAlcoolemie()
	 */
	public function setAlcoolemie($alcoolemie) {
		if ($alcoolemie < 0) {
			$this->alcoolemie = 0;
		} else if ($alcoolemie >= $this->getCalculatedAlcoolemie_max()) {
			$this->alcoolemie = $this->getCalculatedAlcoolemie_max();
		} else {
			$this->alcoolemie = $alcoolemie;
		}
		// if (Pls::haveToGoToPls($this)) {
		// Pls::startToPls($this);
		// }
	}
}

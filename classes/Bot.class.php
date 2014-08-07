<?php
class Bot extends Player {

	private static $filieres = array('rose', 'ingé', 'droit', 'sciences', 'sage-pouf', 'jaune', 'Pharma', 'Médecine');

	private static $villes = array('Annecy', 'Grenoble', 'Lyon', 'Monpeul', 'Valence', 'Aix', 'Marseille', 'Dijon');

	private static $location = array('camping', 'bar', 'cuisine', 'danse');

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
		$this->setPnj(Player::PNJ_BOT);
	}

	public static function createMultiples($number, $factor = 1, $id_congress = null) {
		$i = 0;
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
				$i++;
				if ($number == $i) {
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

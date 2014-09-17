<?php
class GameBizkit {

	protected $started = false;

	public function getStarted() {
		return $this->started;
	}

	public function setStarted($started) {
		$this->started = $started;
	}

	protected $tour = 0;

	public function getTour() {
		return $this->tour;
	}

	public function setTour($tour) {
		$this->tour = $tour;
	}

	protected $bizkit = 0;

	public function getBizkit() {
		return $this->bizkit;
	}

	public function setBizkit($bizkit) {
		$this->bizkit = $bizkit;
	}

	protected $lastMessage = '';

	public function getLastMessage() {
		return $this->lastMessage;
	}

	public function setLastMessage($lastMessage) {
		$this->lastMessage = $lastMessage;
	}

	protected $participants = array();

	public function getParticipants() {
		return $this->participants;
	}

	public function setParticipants(array $participants) {
		$this->participants = $participants;
	}

	public function addParticipant(Player $player) {
		if (in_array($player->getId(), $this->participants)) {
			return;
		}
		$this->participants[] = $player->getId();
		$this->participantsNames[] = $player->getNom();
	}

	protected $participantsNames = array();

	public function getParticipantsNames() {
		return $this->participantsNames;
	}

	public function setParticipantsNames(array $participantsNames) {
		$this->participantsNames = $participantsNames;
	}

	/**
	 *
	 * @param array $assocArray        	
	 */
	public function populate(array $assocArray) {
		foreach ($assocArray as $field => $value) {
			if (!is_numeric($field) && property_exists($this, $field)) {
				// $setter = 'set' . ucfirst($field);
				// $this->$setter($value);
				$this->$field = $value;
			}
		}
	}

	public function export() {
		return get_object_vars($this);
	}

	public static $players = array();

	public static $tourIndex = array();

	/**
	 *
	 * @var Player
	 */
	public static $bizkitPlayer = null;

	public function loadParticipants() {
		foreach ($this->participants as $key => $player_id) {
			$player = Player::load($player_id);
			$player->loadInventory();
			self::$players[$key] = $player;
			if ($player->getId() == $this->bizkit) {
				self::$bizkitPlayer = $player;
			}
		}
		self::$tourIndex = array_search($this->tour, $this->participants);
	}

	protected function fullTour() {
		$this->lastMessage .= ' Fin du tour, tout le monde gagne 1 rêve.';
		foreach (self::$players as $player) {
			$player->addPoints(1);
			$player->addFatigue(1);
		}
	}

	protected function nextPlayer() {
		GameBizkit::$tourIndex++;
		if (GameBizkit::$tourIndex >= count($this->participants)) {
			if (count($this->participants) > 1) {
				$this->fullTour();
			}
			GameBizkit::$tourIndex = 0;
		}
		if (count(GameBizkit::$players)) {
			$this->tour = GameBizkit::$players[GameBizkit::$tourIndex]->getId();
		}
	}

	public function quit(Player $player) {
		$index = array_search($player->getId(), $this->participants);
		$this->lastMessage .= GameBizkit::$players[$index]->getNom() . ' a quitté la partie. ';
		// echo 'quit() INDEX:' . $index;
		unset($this->participants[$index]);
		$this->participants = array_values($this->participants); // reindex
		unset($this->participantsNames[$index]);
		$this->participantsNames = array_values($this->participantsNames); // reindex
		unset(self::$players[$index]);
		self::$players = array_values(self::$players); // reindex
		unset($_SESSION['game']);
		if ($this->tour == $player->getId()) {
			if (GameBizkit::$tourIndex >= count($this->participants)) {
				if (count($this->participants) > 1) {
					$this->fullTour();
				}
				GameBizkit::$tourIndex = 0;
			}
			if (count(GameBizkit::$players)) {
				$this->tour = GameBizkit::$players[GameBizkit::$tourIndex]->getId();
			}
		}
	}

	public function started() {
		$this->started = true;
		$this->tour = $this->participants[0];
	}

	public function dice(Player $player, $dice1 = 0, $dice2 = 0) {
		if (!$dice1) {
			$dice1 = rand(1, 6);
		}
		if (!$dice2) {
			$dice2 = rand(1, 6);
		}
		$this->lastMessage = GameBizkit::$players[GameBizkit::$tourIndex]->getNom() . ' à fait ' . $dice1 . ' et ' . $dice2 . '.<br />';
		$this->diceAction($player, $dice1, $dice2);
		foreach (self::$players as $player) {
			if ($player->isFatigued()) {
				$this->quit($player);
				$this->lastMessage .= $player->getNom() . ' est trop fatigué pour continuer.<br />';
			}
			if ($player->getEn_pls()) {
				$this->quit($player);
				$this->lastMessage .= $player->getNom() . ' a fini en PLS.<br />';
			}
			$player->save();
		}
		return $this->lastMessage;
	}

	protected function diceAction(Player $player, $dice1, $dice2) {
		$sum = $dice1 + $dice2;
		if ($sum == 7) { // si somme des de = 7
			$this->lastMessage .= 'Dire bizkit. (PAS ENCORE CODÉ)<br />';
		} else if ($sum == 9) { // si somme des de = 9
			$this->lastMessage .= 'Le joueur précédent boit 1 coup.<br />';
			$tourIdx = GameBizkit::$tourIndex - 1;
			if ($tourIdx < 0) {
				$tourIdx = count($this->participants) - 1;
			}
			GameBizkit::$players[$tourIdx]->addAlcoolemie(1);
		} else if ($sum == 10) { // si somme des de = 10
			$this->lastMessage .= 'Le lanceur boit 1 coup et laisse la main.<br />';
			$player->addAlcoolemie(1);
			$this->nextPlayer();
		} else if ($sum == 11) { // si somme des de = 11
			$this->lastMessage .= 'Le joueur suivant boit 1 coup.<br />';
			$tourIdx = GameBizkit::$tourIndex + 1;
			if ($tourIdx >= count($this->participants)) {
				$tourIdx = 0;
			}
			GameBizkit::$players[$tourIdx]->addAlcoolemie(1);
		}
		if ($dice1 == $dice2) { // si double
			$this->lastMessage .= 'Distibuer ' . $dice1 . ' coups. (VERSION ALTERNATIVE)<br />';
			$tourIdx = GameBizkit::$tourIndex + 1;
			for ($i = 0; $i < $dice1; $i++) {
				if ($tourIdx >= count($this->participants)) {
					$tourIdx = 0;
				}
				GameBizkit::$players[$tourIdx]->addAlcoolemie(1);
				$this->lastMessage .= GameBizkit::$players[$tourIdx]->getNom() . ' boit 1 coup.<br />';
			}
		}
		if ((($dice1 == 1) && ($dice2 == 2)) || (($dice1 == 2) && ($dice2 == 1))) { // si 2 et 1
			$this->lastMessage .= 'Tout le monde boit<br />';
			foreach (self::$players as $player) {
				$player->addAlcoolemie(1);
			}
		}
		if (($dice1 == 1) && ($dice2 == 1)) { // si double 1
			$this->lastMessage .= 'Le défi: (PAS ENCORE CODÉ)<br />';
			// Le défi. Le lanceur défi un joueur de son choix, qui lance un dé. Si il fait entre 2 et 6, il boit le nombre de coups indiqué. Si il fait 1, c'est au lanceur de se soumettre au défi, mais le nombre de coups est doublé. Si le lanceur fait également 1, le défié reprend le défi, et le nombre de coups est quadruplé, et ainsi de suite. Si le lanceur perd au défi, il laisse la main.
		}
		if ((($dice1 == 1) && ($dice2 == 4)) || (($dice1 == 4) && ($dice2 == 1))) { // si 4 et 1
			if (!$this->bizkit) {
				$this->lastMessage .= 'Bizkit liberé, boit et laisse la main.<br />';
				self::$bizkitPlayer->addAlcoolemie(1);
				$this->bizkit = 0;
				self::$bizkitPlayer = null;
				$this->nextPlayer();
			}
		}
		if (($dice1 == 3) || ($dice2 == 3)) { // si 3
			if ($this->bizkit) { // si il y a pas de bizkit
				if ($this->bizkit == $player->getId()) {
					$this->lastMessage .= 'Bizkit liberé, boit et laisse la main.<br />';
					self::$bizkitPlayer->addAlcoolemie(1);
					$this->bizkit = 0;
					self::$bizkitPlayer = null;
					$this->nextPlayer();
				} else { // si ce n'est pas le tour du bizkit
					$this->lastMessage .= 'Bizkit boit.<br />';
					self::$bizkitPlayer->addAlcoolemie(1);
				}
			} else { // si il n'y a pas de bizkit
				$this->lastMessage .= $player->getNom() . ' devient bizkit et boit.<br />';
				$player->addAlcoolemie(1);
				$this->bizkit = $player->getId();
				self::$bizkitPlayer = $player;
				$this->nextPlayer();
			}
		}
	}
}

<?php
class Action {

	public $player;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		$this->player = $player;
	}

	/**
	 *
	 * @param Player $opponent        	
	 * @return multitype:string unknown
	 */
	public function duel(Player $opponent) {
		$secUser = $this->player->calculated['alcoolemie_max'] - $this->player->calculated['alcoolemie'];
		$secOpponent = $opponent->calculated['alcoolemie_max'] - $opponent->calculated['alcoolemie'];
		$sec = 0;
		$actionMessage = ' Duel: ';
		if ($secUser > $secOpponent) {
			$sec = $secOpponent + 1;
			// $opponent->notoriete -= 1;
			$this->player->notoriete += 2;
			$this->player->points += 5;
			$actionMessage .= ' ' . $this->player->nom . ' a gagné après s\'être affligé ' . $sec . ' secs.';
		} else if ($secUser < $secOpponent) {
			$sec = $secUser + 1;
			$opponent->notoriete += 1;
			$opponent->points += 5;
			$this->player->notoriete -= 1;
			$actionMessage .= ' ' . $opponent->nom . ' a gagné après s\'être affligé ' . $sec . ' secs.';
		} else {
			// $opponent->notoriete -= 1;
			$this->player->notoriete -= 1;
			$sec = ($secOpponent - $secUser) + 1;
			$actionMessage .= ' Personne n\'a gagné après s\'être affligé ' . $sec . ' secs.';
		}
		$opponent->alcoolemie += $sec;
		$this->player->alcoolemie += $sec;
		$this->player->fatigue++;
		$pls = self::haveToGoToPls($this->player);
		self::haveToGoToPls($opponent);
		$opponent->save();
		$this->player->save();
		return array('actionMessage' => $actionMessage,'pls' => $pls
		);
	}

	public function endPLS() {
		if (!$this->player->en_pls) {
			return 'vous êtes déjà plus en PLS.';
		}
		if (self::isPlsFinished($this->player) === true) {
			$recup = floor((time() - $this->player->debut_de_pls) / 60);
			if (($this->player->alcoolemie - $recup) < 0) {
				$recup = $this->player->alcoolemie;
			}
			$this->player->alcoolemie -= $recup;
			$this->player->en_pls = 0;
			$this->player->debut_de_pls = 0;
			return 'vous avez recupéré ' . $recup . ' verres.';
		}
		return false;
	}

	/**
	 *
	 * @param Player $pl        	
	 * @return boolean
	 */
	public static function haveToGoToPls(Player $pl) {
		if ($pl->calculated['alcoolemie'] > $pl->calculated['alcoolemie_max']) {
			self::sendToPls($pl);
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param Player $pl        	
	 */
	public static function sendToPls(Player $pl) {
		$pl->en_pls = true;
		$pl->debut_de_pls = time();
		$pl->save();
	}

	/**
	 *
	 * @param Player $pl        	
	 * @return boolean number
	 */
	public static function isPlsFinished(Player $pl) {
		if (time() - $pl->debut_de_pls > 60) {
			return true;
		}
		return 60 - (time() - $pl->debut_de_pls);
	}
}

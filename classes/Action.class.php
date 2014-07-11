<?php
/**
 * 
 * @author ybl
 * @deprecated
 */
class Action {

	public $player;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		$this->player = $player;
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
		if ($pl->getCalculatedAlcoolemie() > $pl->getCalculatedAlcoolemie_max()) {
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

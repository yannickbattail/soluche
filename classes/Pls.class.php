<?php
/**
 * 
 * @author ybl
 * @deprecated
 */
class Pls {

	/**
	 *
	 * @param Player $player        	
	 * @return ActionResult
	 */
	public static function endPLS(Player $player) {
		$res = new ActionResult();
		if (!$player->en_pls) {
			$res->setMessage('vous êtes déjà plus en PLS.');
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			return $res;
		}
		if (self::isPlsFinished($player) === true) {
			$recup = floor((time() - $player->debut_de_pls) / 60);
			if (($player->alcoolemie - $recup) < 0) {
				$recup = $player->alcoolemie;
			}
			$player->addNotoriete(-1);
			$player->addAlcoolemie(-1 * $recup);
			$player->addFatigue(-1);
			$player->addRemaining_time(-1 * $recup);
			$player->setEn_pls(0);
			$player->setDebut_de_pls(0);
			$res->setMessage('vous avez recupéré ' . $recup . ' verres.');
			$res->setSuccess(ActionResult::SUCCESS);
			Dispatcher::setPage('camping');
			return $res;
		}
		$res->setMessage('Pls non terminée');
		$res->setSuccess(ActionResult::IMPOSSIBLE);
		return $res;
	}

	/**
	 *
	 * @param Player $pl        	
	 * @return boolean
	 */
	public static function haveToGoToPls(Player $player) {
		if ($player->en_pls == 1) {
			return false;
		}
		if ($player->getCalculatedAlcoolemie() > $player->getCalculatedAlcoolemie_max()) {
			self::startToPls($player);
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param Player $player        	
	 * @return boolean
	 */
	public static function redirectPLS(Player $player) {
		if ($player->en_pls == 1) {
			Dispatcher::setPage('pls');
			return true;
		}
		return false;
	}

	/**
	 *
	 * @param Player $pl        	
	 */
	public static function startToPls(Player $player) {
		$res = new ActionResult();
		$player->en_pls = true;
		$player->debut_de_pls = time();
		$res->setMessage('En PLS!');
		$res->setSuccess(ActionResult::SUCCESS);
		return $res;
	}

	/**
	 *
	 * @param Player $pl        	
	 * @return boolean number
	 */
	public static function isPlsFinished(Player $player) {
		if (time() - $player->debut_de_pls > 60) {
			return true;
		}
		return 60 - (time() - $player->debut_de_pls);
	}
}

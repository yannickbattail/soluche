<?php
class Choper implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Player
	 */
	private $opponent;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		$this->player = $player;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		$this->opponent = Player::load($params['playerId'])->loadInventory();
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if ($this->opponent->getSex() == $this->player->getSex()) {
			$res->message .= 'Pas de sex homo pour le momment. Ca viendra plus tard pour ajouter du piment au jeu ;-)';
			$res->succes = false;
			return $res;
		}
		/*
		 * $sex_appealDiff = 1 / abs($this->player->getCalculatedSex_appeal() - $this->opponent->getCalculatedSex_appeal()); $alcoolUser = 0.5 * $this->player->getCalculatedAlcoolemie() / $this->player->getCalculatedAlcoolemie_max(); $alcoolOpponent = 0.5 * $this->opponent->getCalculatedAlcoolemie() / $this->opponent->getCalculatedAlcoolemie_max(); $alcool = $alcoolUser + $alcoolOpponent; $notorieteDiff = $this->player->getCalculatedNotoriete() - $this->opponent->getCalculatedNotoriete();
		 */
		$coefPlayer = $this->player->getCalculatedSex_appeal() + $this->player->getCalculatedAlcoolemie() + $this->player->getCalculatedNotoriete();
		Dispatcher::addMessage("JOUEUR => sex appeal: " . $this->player->getCalculatedSex_appeal() . " + Verre: " . $this->player->getCalculatedAlcoolemie() . " + Notoriete: " . $this->player->getCalculatedNotoriete() . " = " . $coefPlayer, Dispatcher::MESSAGE_LEVEL_INFO);
		$coefOpponent = $this->opponent->getCalculatedSex_appeal() + $this->opponent->getCalculatedAlcoolemie() + $this->opponent->getCalculatedNotoriete();
		Dispatcher::addMessage("OPPOSANT => sex appeal: " . $this->opponent->getCalculatedSex_appeal() . " + Verre: " . $this->opponent->getCalculatedAlcoolemie() . " + Notoriete: " . $this->opponent->getCalculatedNotoriete() . " = " . $coefOpponent, Dispatcher::MESSAGE_LEVEL_INFO);
		if ($coefPlayer > $coefOpponent) {
			$this->player->addNotoriete(2);
			$this->player->addPoints(5);
			$this->opponent->addNotoriete(2);
			$this->opponent->addPoints(5);
			$res->message .= 'T\'as choppé ' . $this->opponent->getNom();
			$res->succes = true;
		} else {
			$res->message .= 'T\'as pas réussi à chopper ' . $this->opponent->getNom();
			$res->succes = false;
		}
		$this->opponent->save();
		// $this->player->save(); // this is done at the end of the action execution.
		return $res;
	}
}

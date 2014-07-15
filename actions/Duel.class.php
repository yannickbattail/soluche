<?php
class Duel implements ActionInterface {

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
		$secUser = $this->player->getCalculatedAlcoolemie_max() - $this->player->getCalculatedAlcoolemie();
		$secOpponent = $this->opponent->getCalculatedAlcoolemie_max() - $this->opponent->getCalculatedAlcoolemie();
		$sec = 0;
		$res->message = ' Duel: ';
		//$res->message .= ' $secUser: ' . $secUser . ' $secOpponent: ' . $secOpponent; // debug
		if ($secUser > $secOpponent) {
			$sec = $secOpponent + 1;
			// $this->opponent->notoriete -= 1;
			$this->player->addNotoriete(2);
			$this->player->addPoints(5);
			$res->message .= ' ' . $this->player->nom . ' a gagné après s\'être affligé ' . $sec . ' secs.';
		} else if ($secUser < $secOpponent) {
			$sec = $secUser + 1;
			$this->opponent->addNotoriete(1);
			$this->opponent->addPoints(5);
			$this->player->addNotoriete(1);
			$res->message .= ' ' . $this->opponent->nom . ' a gagné après s\'être affligé ' . $sec . ' secs.';
		} else { // $secUser == $secOpponent
			$this->player->addNotoriete(-1);
			// $this->opponent->notoriete -= 1;
			$sec = $secOpponent + 1;
			$res->message .= ' Personne n\'a gagné après s\'être affligé ' . $sec . ' secs.';
		}
		$this->opponent->addAlcoolemie($sec);
		$this->player->addAlcoolemie($sec);
		$this->player->addFatigue(1);
		$this->opponent->save();
		// $this->player->save(); // this is done at the end of the action execution.
		$res->succes = true;
		return $res;
	}
}

<?php
class Pins implements ActionInterface {

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
		$this->opponent->addAlcoolemie(1);
		$this->opponent->addPoints(2);
		$this->opponent->save();
		$this->player->addPoints(1);
		$this->player->addNotoriete(1);
		// $this->player->save(); // this is done at the end of the action execution.
		$res->message = 'Pin\'s';
		$res->succes = true;
		return $res;
	}
}

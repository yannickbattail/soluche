<?php
class Vt implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

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
	 */
	public function setParams(array $params) {}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if ($this->player->getAlcoolemie() >= 1) {
			$this->player->addAlcoolemie(-1);
			$this->player->addNotoriete(-1);
			$res->message = 'Dégueux!';
			$res->succes = true;
		} else {
			$res->message = 'alcoolemie déjà à 0.';
			$res->succes = false;
		}
		return $res;
	}
}

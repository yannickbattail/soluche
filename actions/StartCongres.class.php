<?php
class StartCongres implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Player
	 */
	private $congres;

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
		$this->congres = $params['congres'];
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		return Congres::start();
	}
}

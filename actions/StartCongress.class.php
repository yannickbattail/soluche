<?php
class StartCongress implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Congress
	 */
	private $congress;

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
		$this->congress = Congress::load($params['idCongress']);
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		return $this->congress->start($this->player);
	}
}

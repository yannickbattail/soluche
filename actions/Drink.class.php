<?php
class Drink extends Eat {

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Boire';
	}
}

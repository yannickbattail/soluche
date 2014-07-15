<?php
interface ActionInterface {

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player);

	/**
	 * 
	 * @param array $params
	 */
	public function setParams(array $params);

	/**
	 * @return ActionResult
	 */
	public function execute();
}

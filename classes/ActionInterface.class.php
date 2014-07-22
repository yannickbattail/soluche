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
	 * @return $this
	 */
	public function setParams(array $params);

	/**
	 *
	 * @return ActionResult
	 */
	public function execute();

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null);
}

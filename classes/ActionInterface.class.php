<?php
interface ActionInterface {

	/**
	 *
	 * @return Player
	 */
	public function getPlayer();

	/**
	 *
	 * @param Player $player        	
	 */
	public function setPlayer(Player $player);

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
	public function start();

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null);

	public function statsDisplay($page = null);
}

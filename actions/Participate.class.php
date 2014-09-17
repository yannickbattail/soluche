<?php
class Participate extends AbstractAction {

	const PARAM_NAME = 'id_game';

	/**
	 *
	 * @var Game
	 */
	protected $game;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Participer au jeu';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Game) {
			$this->game = $params[self::PARAM_NAME];
		} else {
			$this->game = Game::load($params[self::PARAM_NAME]);
		}
		if ($this->game) {
			$this->paramPrimaryKey = $this->game->getId();
		}
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		if (!$this->game) {
			$res = new ActionResult();
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$res->setMessage('Cette partie n\'existe plus.');
			return $res;
		}
		$res = new ActionResult();
		$this->game->participate($this->player);
		$res->setSuccess(ActionResult::NOTHING);
		$res->setMessage('Let\'s play.');
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		return '';
	}
}

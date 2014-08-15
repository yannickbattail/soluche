<?php
class StartCongress extends AbstractAction {

	const PARAM_NAME = 'id_congress';

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
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = AbstractAction::EXCEPT_OUT_CONGRESS | AbstractAction::EXCEPT_TIRED | AbstractAction::EXCEPT_PLS;
		$this->linkText = 'Aller à ce congrès';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Congress) {
			$this->congress = $params[$this->paramName];
		} else {
			$this->congress = Congress::load($params[$this->paramName]);
			if (!$this->congress) {
				throw new Exception('no such Congress: ' . $params[$this->paramName]);
			}
		}
		$this->paramPrimaryKey = $this->congress->getId();
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		$this->player->setFatigue(0);
		$this->player->setAlcoolemie(0);
		$this->player->setCongress($this->congress);
		$this->player->setRemaining_time($this->congress->getAction_number());
		$this->player->addMoney($this->congress->getBudget());
		$this->player->addRandomItem();
		Bot::resetBots(1, $this->congress->getId());
		Dispatcher::setPage('camping');
		$res->setMessage('Début du congrès "'.$this->congress->getNom().'" en ' . $this->congress->getAction_number() . ' heures.');
		$res->setSuccess(ActionResult::SUCCESS);
		return $res;
	}

	public function statsDisplay($page = null) {
		return '';
	}
}

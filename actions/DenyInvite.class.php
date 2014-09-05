<?php
class DenyInvite extends AcceptInvite {

	const PARAM_NAME = 'id_invitation';
	
	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->linkText = 'Refuser l\'invitation';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Player) {
			$this->invitation = $params[self::PARAM_NAME];
		} else {
			$this->invitation = Invitation::load($params[self::PARAM_NAME]);
			// if (!$this->invitation) {
			// throw new Exception('no such invitation: ' . $params[self::PARAM_NAME]);
			// }
		}
		if ($this->invitation) {
			$this->opponent = Player::load($this->invitation->getHost());
			$this->opponent->loadInventory();
			if ($this->invitation->getId_congress()) {
				$this->congress = Congress::load($this->invitation->getId_congress());
			}
			$this->location = $this->invitation->getLocation();
			if ($this->invitation->getId_game()) {
				$this->game = Game::load($this->invitation->getId_game());
			}
			$this->message = $this->invitation->getMessage();
			$this->paramPrimaryKey = $this->invitation->getId();
			$this->player->getHistory()->setId_opponent($this->opponent->getId());
		}
		return $this;
	}
	
	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if (!$this->invitation) {
			$res->setMessage('L\'invitation est trop vieille ou n\'existe plus.');
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			return $res;
		}
		$this->invitation->delete();
		$res->setMessage('Invitation refusée');
		$res->setSuccess(ActionResult::SUCCESS);
		return $res;
	}
}

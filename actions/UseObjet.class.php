<?php
class UseObjet implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Objet
	 */
	private $objet;

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
		$this->objet = Objet::load($params['objetId']);
		if (!$this->objet) {
			throw new Exception('no such objet: ' . $params['objetId']);
		}
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if ($this->objet->permanent) {
			$res->succes = false;
			$res->message = 'Cet objet est permanent et ne peut etre utilisé.';
			return $res;
		}
		// @TODO verifier si l objet est bien present dans inventaire du player
		$this->player->addNotoriete($this->objet->notoriete);
		$this->player->addAlcoolemie($this->objet->alcoolemie);
		$this->player->addAlcoolemie_optimum($this->objet->alcoolemie_optimum);
		$this->player->addAlcoolemie_max($this->objet->alcoolemie_max);
		$this->player->addFatigue($this->objet->fatigue);
		$this->player->addFatigue_max($this->objet->fatigue_max);
		$this->player->addSex_appeal($this->objet->sex_appeal);
		Objet::desassociate($this->player->getId(), $this->objet->id);
		$res->succes = true;
		$res->message = 'Object '.$this->objet->nom.' utilisé.';
		return $res;
	}
}

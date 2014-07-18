<?php
class Manger implements ActionInterface {

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
		if ($this->objet->permanent) { // useless
			$res->succes = false;
			$res->message = 'Cet objet est permanent et ne peut etre utilisé.';
			return $res;
		}
		$this->player->addNotoriete($this->objet->notoriete);
		$this->player->addAlcoolemie($this->objet->alcoolemie);
		$this->player->addAlcoolemie_optimum($this->objet->alcoolemie_optimum);
		$this->player->addAlcoolemie_max($this->objet->alcoolemie_max);
		$this->player->addFatigue($this->objet->fatigue);
		$this->player->addFatigue_max($this->objet->fatigue_max);
		$this->player->addSex_appeal($this->objet->sex_appeal);
		$res->succes = true;
		$res->message = 'j\'ai bien mangé, j\'ai bien bu un(e) '.$this->objet->nom.'.';
		return $res;
	}
}

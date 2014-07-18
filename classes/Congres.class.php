<?php
class Congres {

	public $nom = '';

	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	protected $actionNumber = 48;

	public function getActionNumber() {
		return $this->actionNumber;
	}

	public function setActionNumber($actionNumber) {
		$this->actionNumber = $actionNumber;
	}

	public function addActionNumber($actionNumber) {
		$this->setActionNumber($this->getActionNumber() + $actionNumber);
	}

	protected $bots = array();

	public function getBots() {
		return $this->bots;
	}

	public function setBots($bots) {
		$this->bots = $bots;
	}

	public $fatigue = 48;

	public function getCalculatedFatigue() {
		return $this->calculated['fatigue'];
	}

	public function getFatigue() {
		return $this->fatigue;
	}

	public function setFatigue($fatigue) {
		if ($fatigue < 0) {
			$this->fatigue = 0;
		} else {
			$this->fatigue = $fatigue;
		}
		if ($this->fatigue == 0) {
			Dispatcher::setPage('congres');
		}
	}

	public function addFatigue($fatigue) {
		$this->setFatigue($this->getFatigue() + $fatigue);
	}

	public $history = array();

	public function getHistory() {
		return $this->history;
	}

	public function setHistory(array $history) {
		$this->history = $history;
	}

	public function addHistory(ActionResult $actionReturn) {
		$this->history[] = $actionReturn;
	}

	public static function start() {
		$res = new ActionResult();
		$actionNb = 20;
		$_SESSION['congres'] = new Congres();
		$_SESSION['congres']->setActionNumber($actionNb);
		$_SESSION['congres']->setNom('Week-end luche');
		$_SESSION['congres']->setFatigue($actionNb);
		
		Dispatcher::setPage('camping');
		$res->message .= 'Début du congres en ' . $actionNb . ' heures.';
		$res->succes = true;
		return $res;
	}
}

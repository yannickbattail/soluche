<?php
class Congress extends AbstractDbObject {

	const TABLE_NAME = 'congress';

	public $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public $nom = '';

	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	protected $action_number = 48;

	public function getAction_number() {
		return $this->action_number;
	}

	public function setAction_number($action_number) {
		$this->action_number = $action_number;
	}

	public function addAction_number($action_number) {
		$this->setAction_number($this->getAction_number() + $action_number);
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
			Dispatcher::setPage('congress');
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

	public function start(Player $player) {
		$res = new ActionResult();
		$_SESSION['congress'] = $this;
		$_SESSION['congress']->setFatigue($this->getAction_number() + 1);
		$player->setCongress($this);
		$player->addRandomItem();
		
		Dispatcher::setPage('camping');
		$res->message .= 'Début du congrès en ' . $this->getAction_number() . ' heures.';
		$res->succes = true;
		return $res;
	}

	/**
	 *
	 * @param int $id        	
	 * @return Congress
	 */
	public static function load($id) {
		$sth = $GLOBALS['DB']->query('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=' . intval($id));
		$sth->setFetchMode(PDO::FETCH_CLASS, __CLASS__);
		return $sth->fetch();
	}

	public function save() {
		if (!$this->id) {
			$this->create();
		} else {
			$this->update();
		}
	}

	public function create() {
		$sth = $GLOBALS['DB']->prepare('INSERT INTO ' . self::TABLE_NAME . ' ' . '(nom, action_number)' . ' VALUES (:nom, :action_number);');
		$sth->bindValue(':nom', $this->nom, PDO::PARAM_STR);
		$sth->bindValue(':action_number', $this->action_number, PDO::PARAM_INT);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
		$this->setId($GLOBALS['DB']->lastInsertId());
	}

	public function defaultValues() {
		$this->nom = 'Week-end luche';
		$this->action_number = 10;
	}

	public function update() {
		$sth = $GLOBALS['DB']->prepare('UPDATE ' . self::TABLE_NAME . ' SET nom=:nom, action_number=:action_number WHERE id=:id;');
		$sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':nom', $this->nom, PDO::PARAM_STR);
		$sth->bindValue(':action_number', $this->action_number, PDO::PARAM_INT);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
	}

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $this->id . ';')->fetch(PDO::FETCH_ASSOC);
	}
}

<?php
class History extends AbstractDbObject {

	const TABLE_NAME = 'history';

	public $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	/**
	 *
	 * @var int
	 */
	public $id_player = NULL;

	public function getId_player() {
		return $this->id_player;
	}

	public function setId_player($id_player) {
		$this->id_player = $id_player;
	}

	/**
	 *
	 * @var int
	 */
	public $id_congress = NULL;

	public function getId_congress() {
		return $this->id_congress;
	}

	public function setId_congress($id_congress) {
		$this->id_congress = $id_congress;
	}

	public $action_name = '';

	public function getAction_name() {
		return $this->action_name;
	}

	public function setAction_name($action_name) {
		$this->action_name = $action_name;
	}

	public $lieu = '';

	public function getLieu() {
		return $this->lieu;
	}

	public function setLieu($lieu) {
		$this->lieu = $lieu;
	}

	public $points = 0;

	public function getPoints() {
		return $this->points;
	}

	public function setPoints($points) {
		$this->points = $points;
	}

	public $notoriete = 0;

	public function getNotoriete() {
		return $this->notoriete;
	}

	public function setNotoriete($notoriete) {
		$this->notoriete = $notoriete;
	}

	public $alcoolemie = 0;

	public function getAlcoolemie() {
		return $this->alcoolemie;
	}

	public function setAlcoolemie($alcoolemie) {
		$this->alcoolemie = $alcoolemie;
	}

	public $alcoolemie_optimum = 0;

	public function getAlcoolemie_optimum() {
		return $this->alcoolemie_optimum;
	}

	public function setAlcoolemie_optimum($alcoolemie_optimum) {
		$this->alcoolemie_optimum = $alcoolemie_optimum;
	}

	public $alcoolemie_max = 0;

	public function getAlcoolemie_max() {
		return $this->alcoolemie_max;
	}

	public function setAlcoolemie_max($alcoolemie_max) {
		$this->alcoolemie_max = $alcoolemie_max;
	}

	public $fatigue = 0;

	public function getFatigue() {
		return $this->fatigue;
	}

	public function setFatigue($fatigue) {
		$this->fatigue = $fatigue;
	}

	public $fatigue_max = 0;

	public function getFatigue_max() {
		return $this->fatigue_max;
	}

	public function setFatigue_max($fatigue_max) {
		$this->fatigue_max = $fatigue_max;
	}

	public $sex_appeal = 0;

	public function getSex_appeal() {
		return $this->sex_appeal;
	}

	public function setSex_appeal($sex_appeal) {
		$this->sex_appeal = $sex_appeal;
	}

	public $en_pls = 0;

	public function getEn_pls() {
		return $this->en_pls;
	}

	public function setEn_pls($en_pls) {
		if ($en_pls) {
			$this->en_pls = 1;
		} else {
			$this->en_pls = 0;
		}
	}

	public $debut_de_pls = 0;

	public function getDebut_de_pls() {
		return $this->debut_de_pls;
	}

	public function setDebut_de_pls($debut_de_pls) {
		$this->debut_de_pls = $debut_de_pls;
	}

	/**
	 * si quelqu'un me demande quelle valeur est homme/femme, bien qu'il regarde dans son slip
	 *
	 * @var int
	 */
	public $sex = 0;

	public function getSex() {
		return $this->sex;
	}

	public function setSex($sex) {
		$sex = (int) $sex;
		if (($sex === 0) || ($sex === 1)) {
			$this->sex = $sex;
		} else {
			throw new RuleException('sex doit etre 0 ou 1');
		}
	}

	public $remaining_time = 0;

	public function getRemaining_time() {
		return $this->remaining_time;
	}

	public function setRemaining_time($remaining_time) {
		$this->remaining_time = $remaining_time;
	}

	/**
	 *
	 * @var int
	 */
	public $date_action = 0;

	public function getDate_action() {
		return $this->date_action;
	}

	public function setDate_action($date_action) {
		$this->date_action = $date_action;
	}

	/**
	 *
	 * @var int
	 */
	public $success = 0;

	public function getSuccess() {
		return $this->success;
	}

	public function setSuccess($success) {
		$this->success = $success;
	}

	/**
	 *
	 * @var int
	 */
	public $message = 0;

	public function getMessage() {
		return $this->message;
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 *
	 * @var int
	 */
	public $id_opponent = NULL;

	public function getId_opponent() {
		return $this->id_opponent;
	}

	public function setId_opponent($id_opponent) {
		$this->id_opponent = $id_opponent;
	}

	/**
	 *
	 * @var int
	 */
	public $id_item = NULL;

	public function getId_item() {
		return $this->id_item;
	}

	public function setId_item($id_item) {
		$this->id_item = $id_item;
	}

	/**
	 *
	 * @param int $id        	
	 * @return Player
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
		$sth = $GLOBALS['DB']->prepare('INSERT INTO ' . self::TABLE_NAME . ' ' . '(id_player, id_congress, action_name, lieu, points, notoriete, alcoolemie, alcoolemie_optimum, alcoolemie_max, fatigue, fatigue_max, sex_appeal, en_pls, debut_de_pls, sex, remaining_time, date_action, success, message, id_opponent, id_item)' . ' VALUES (:id_player, :id_congress, :action_name, :lieu, :points, :notoriete, :alcoolemie, :alcoolemie_optimum, :alcoolemie_max, :fatigue, :fatigue_max, :sex_appeal, :en_pls, :debut_de_pls, :sex, :remaining_time, :date_action, :success, :message, :id_opponent, :id_item);');
		// $sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':id_player', $this->id_player, PDO::PARAM_INT);
		$sth->bindValue(':id_congress', $this->id_congress, PDO::PARAM_INT);
		$sth->bindValue(':action_name', $this->action_name, PDO::PARAM_STR);
		$sth->bindValue(':lieu', $this->lieu, PDO::PARAM_STR);
		$sth->bindValue(':points', $this->points, PDO::PARAM_INT);
		$sth->bindValue(':notoriete', $this->notoriete, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie', $this->alcoolemie, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_optimum', $this->alcoolemie_optimum, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_max', $this->alcoolemie_max, PDO::PARAM_INT);
		$sth->bindValue(':fatigue', $this->fatigue, PDO::PARAM_INT);
		$sth->bindValue(':fatigue_max', $this->fatigue_max, PDO::PARAM_INT);
		$sth->bindValue(':sex_appeal', $this->sex_appeal, PDO::PARAM_INT);
		$sth->bindValue(':en_pls', $this->en_pls, PDO::PARAM_INT);
		$sth->bindValue(':debut_de_pls', $this->debut_de_pls, PDO::PARAM_INT);
		$sth->bindValue(':sex', $this->sex, PDO::PARAM_INT);
		$sth->bindValue(':remaining_time', $this->remaining_time, PDO::PARAM_INT);
		$sth->bindValue(':date_action', $this->date_action, PDO::PARAM_INT);
		$sth->bindValue(':success', $this->success, PDO::PARAM_INT);
		$sth->bindValue(':message', $this->message, PDO::PARAM_STR);
		$sth->bindValue(':id_opponent', $this->id_opponent, PDO::PARAM_INT);
		$sth->bindValue(':id_item', $this->id_item, PDO::PARAM_INT);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
		$this->setId($GLOBALS['DB']->lastInsertId());
	}

	public function defaultValues() {
		$this->id_player = null;
		$this->id_congress = null;
		$this->action_name = '';
		$this->lieu = '';
		$this->points = 0;
		$this->notoriete = 0;
		$this->alcoolemie = 0;
		$this->alcoolemie_optimum = 0;
		$this->alcoolemie_max = 0;
		$this->fatigue = 0;
		$this->fatigue_max = 0;
		$this->sex_appeal = 0;
		$this->en_pls = 0;
		$this->debut_de_pls = 0;
		$this->sex = 0;
		$this->remaining_time = 0;
		$this->date_action = 0;
		$this->success = 0;
		$this->message = '';
		$this->id_opponent = null;
		$this->id_item = null;
	}

	public function update() {
		$sth = $GLOBALS['DB']->prepare('UPDATE ' . self::TABLE_NAME . ' SET id_player=:id_player, id_congress=:id_congress, action_name=:action_name, lieu=:lieu, points=:points, notoriete=:notoriete, alcoolemie=:alcoolemie, alcoolemie_optimum=:alcoolemie_optimum, alcoolemie_max=:alcoolemie_max, fatigue=:fatigue, fatigue_max=:fatigue_max, sex_appeal=:sex_appeal, en_pls=:en_pls, debut_de_pls=:debut_de_pls, sex=:sex, remaining_time=:remaining_time, date_action=:date_action, success=:success, message=:message, id_opponent=:id_opponent, id_item=:id_item WHERE id=:id;');
		$sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':id_player', $this->id_player, PDO::PARAM_INT);
		$sth->bindValue(':id_congress', $this->id_congress, PDO::PARAM_INT);
		$sth->bindValue(':action_name', $this->action_name, PDO::PARAM_STR);
		$sth->bindValue(':lieu', $this->lieu, PDO::PARAM_STR);
		$sth->bindValue(':points', $this->points, PDO::PARAM_INT);
		$sth->bindValue(':notoriete', $this->notoriete, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie', $this->alcoolemie, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_optimum', $this->alcoolemie_optimum, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_max', $this->alcoolemie_max, PDO::PARAM_INT);
		$sth->bindValue(':fatigue', $this->fatigue, PDO::PARAM_INT);
		$sth->bindValue(':fatigue_max', $this->fatigue_max, PDO::PARAM_INT);
		$sth->bindValue(':sex_appeal', $this->sex_appeal, PDO::PARAM_INT);
		$sth->bindValue(':en_pls', $this->en_pls, PDO::PARAM_INT);
		$sth->bindValue(':debut_de_pls', $this->debut_de_pls, PDO::PARAM_INT);
		$sth->bindValue(':sex', $this->sex, PDO::PARAM_INT);
		$sth->bindValue(':remaining_time', $this->remaining_time, PDO::PARAM_INT);
		$sth->bindValue(':date_action', $this->date_action, PDO::PARAM_INT);
		$sth->bindValue(':success', $this->success, PDO::PARAM_INT);
		$sth->bindValue(':message', $this->message, PDO::PARAM_STR);
		$sth->bindValue(':id_opponent', $this->id_opponent, PDO::PARAM_INT);
		$sth->bindValue(':id_item', $this->id_item, PDO::PARAM_INT);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
	}

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $this->id . ';')->fetch(PDO::FETCH_ASSOC);
	}
}
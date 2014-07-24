<?php
class Objet extends AbstractDbObject {

	const TABLE_NAME = 'objet';

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

	public $permanent = 0;

	public function getPermanent() {
		return $this->permanent;
	}

	public function setPermanent($permanent) {
		$this->permanent = $permanent;
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

	public $image = "";

	public function getImage() {
		return $this->image;
	}

	public function setImage($image) {
		$this->image = $image;
	}


	public $type = 'test';
	
	public function getType() {
		return $this->type;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function defaultValues() {
		$this->setNom('OBJET');
		$this->setPermanent(0);
		$this->setImage('images/objets/unknown.png');
		return $this;
	}
	
	/**
	 *
	 * @param String $id        	
	 * @return Objet
	 */
	public static function load($id) {
		$sth = $GLOBALS['DB']->query('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=' . $id . ';');
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

	public function create() {}

	public function update() {
		$sth = $GLOBALS['DB']->prepare('UPDATE FROM ' . self::TABLE_NAME . ' SET ' . ' nom=:nom' . ' permanent=:permanent' . ' notoriete=:notoriete' . ' alcoolemie=:alcoolemie' . ' alcoolemie_optimum=:alcoolemie_optimum' . ' alcoolemie_max=:alcoolemie_max' . ' fatigue=:fatigue' . ' fatigue_max=:fatigue_max' . ' sex_appeal=:sex_appeal' . ' WHERE id=:id;');
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->bindValue(':nom', $nom, PDO::PARAM_STR);
		$sth->bindValue(':permanent', $permanent, PDO::PARAM_INT);
		$sth->bindValue(':notoriete', $notoriete, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie', $alcoolemie, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_optimum', $alcoolemie_optimum, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_max', $alcoolemie_max, PDO::PARAM_INT);
		$sth->bindValue(':fatigue', $fatigue, PDO::PARAM_INT);
		$sth->bindValue(':fatigue_max', $fatigue_max, PDO::PARAM_INT);
		$sth->bindValue(':sex_appeal', $sex_appeal, PDO::PARAM_INT);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return false;
		}
	}

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $id . ';')->fetch(PDO::FETCH_ASSOC);
	}

	public function associatePlayer(Player $player) {
		self::associate($player->id, $this->id);
	}

	public static function associate($idPlayer, $idObjet) {
		$GLOBALS['DB']->query('INSERT INTO inventory (idplayer, idobject) VALUES (' . $idPlayer . ',' . $idObjet . ');');
	}

	public static function associateObject(Player $player, Objet $objet) {
		self::associate($player->id, $objet->id);
	}

	public static function desassociate($idPlayer, $idObjet) {
		$GLOBALS['DB']->query('DELETE FROM inventory WHERE idplayer=' . $idPlayer . ' AND idobject=' . $idObjet . ' LIMIT 1;');
	}
}
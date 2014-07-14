<?php
class Objet {

	public $id = 0;

	public $nom = '';

	public $permanent = '';

	public $notoriete = 0;

	public $alcoolemie = 0;

	public $alcoolemie_optimum = 0;

	public $alcoolemie_max = 0;

	public $fatigue = 0;

	public $fatigue_max = 0;

	public $sex_appeal = 0;

	public $image = "";

	/**
	 * 
	 * @param String $id
	 * @return Objet
	 */
	public static function load($id) {
		$sth = $GLOBALS['DB']->query('SELECT * FROM objet WHERE id=' . $id . ';');
		$sth->setFetchMode(PDO::FETCH_CLASS, 'Objet');
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
		$sth = $GLOBALS['DB']->prepare('UPDATE FROM objet SET ' . ' nom=:nom' . ' permanent=:permanent' . ' notoriete=:notoriete' . ' alcoolemie=:alcoolemie' . ' alcoolemie_optimum=:alcoolemie_optimum' . ' alcoolemie_max=:alcoolemie_max' . ' fatigue=:fatigue' . ' fatigue_max=:fatigue_max' . ' sex_appeal=:sex_appeal' . ' WHERE id=:id;');
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
		$GLOBALS['DB']->query('DELETE FROM objet WHERE id=' . $id . ';')->fetch(PDO::FETCH_ASSOC);
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
		$GLOBALS['DB']->query('DELETE FROM inventory WHERE idplayer=' . $idPlayer . ' AND idobject=' . $idObjet . ';');
	}
}
<?php
class Item extends AbstractDbObject {

	const TABLE_NAME = 'item';

	public static $ITEM_TYPES = array('badge', 'drink', 'test', 'food', 'alcohol', 'pins', 'cros');

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $nom = '';

	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	protected $permanent = 0;

	public function getPermanent() {
		return $this->permanent;
	}

	public function setPermanent($permanent) {
		$this->permanent = $permanent;
	}

	protected $notoriete = 0;

	public function getNotoriete() {
		return $this->notoriete;
	}

	public function setNotoriete($notoriete) {
		$this->notoriete = $notoriete;
	}

	protected $alcoolemie = 0;

	public function getAlcoolemie() {
		return $this->alcoolemie;
	}

	public function setAlcoolemie($alcoolemie) {
		$this->alcoolemie = $alcoolemie;
	}

	protected $alcoolemie_optimum = 0;

	public function getAlcoolemie_optimum() {
		return $this->alcoolemie_optimum;
	}

	public function setAlcoolemie_optimum($alcoolemie_optimum) {
		$this->alcoolemie_optimum = $alcoolemie_optimum;
	}

	protected $alcoolemie_max = 0;

	public function getAlcoolemie_max() {
		return $this->alcoolemie_max;
	}

	public function setAlcoolemie_max($alcoolemie_max) {
		$this->alcoolemie_max = $alcoolemie_max;
	}

	protected $fatigue = 0;

	public function getFatigue() {
		return $this->fatigue;
	}

	public function setFatigue($fatigue) {
		$this->fatigue = $fatigue;
	}

	protected $fatigue_max = 0;

	public function getFatigue_max() {
		return $this->fatigue_max;
	}

	public function setFatigue_max($fatigue_max) {
		$this->fatigue_max = $fatigue_max;
	}

	protected $sex_appeal = 0;

	public function getSex_appeal() {
		return $this->sex_appeal;
	}

	public function setSex_appeal($sex_appeal) {
		$this->sex_appeal = $sex_appeal;
	}

	protected $image = "";

	public function getImage() {
		return $this->image;
	}

	public function setImage($image) {
		$this->image = $image;
	}

	protected $item_type = 'test';

	public function getItem_type() {
		return $this->item_type;
	}

	public function setItem_type($item_type) {
		if (array_search($item_type, self::$ITEM_TYPES) === false) {
			throw new Exception('"item_type" must be one of ' . print_r(self::$ITEM_TYPES, true));
		}
		$this->item_type = $item_type;
	}

	protected $remaining_time = 0;

	public function getRemaining_time() {
		return $this->remaining_time;
	}

	public function setRemaining_time($remaining_time) {
		if ($remaining_time < 0) {
			$remaining_time = 0;
		}
		$this->remaining_time = $remaining_time;
	}

	protected $price = 0;

	public function getPrice() {
		return $this->price;
	}

	public function setPrice($price) {
		if ($price < 0) {
			$price = 0;
		}
		$this->price = $price;
	}

	public function defaultValues() {
		$this->setNom('ITEM');
		$this->setPermanent(0);
		$this->setImage('images/items/unknown.png');
		return $this;
	}

	/**
	 *
	 * @param String $id        	
	 * @return Item
	 */
	public static function load($id) {
			$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = :id;');
		$sth->bindValue(':id', $id, PDO::PARAM_STR);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return false;
		}
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$obj = new self();
			//if ($arr['pnj'] > 0) {
			//	$obj = new Bot();
			//}
			$obj->populate($arr);
			return $obj;
		}
	}

	/**
	 *
	 * @param String $itemName        	
	 * @return Item
	 */
	public static function loadByName($name) {
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE nom = :nom;');
		$sth->bindValue(':nom', $name, PDO::PARAM_STR);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return false;
		}
		$arr = $sth->fetch();
		if (!$arr) {
			return false;
		} else {
			$obj = new self();
			//if ($arr['pnj'] > 0) {
			//	$obj = new Bot();
			//}
			$obj->populate($arr);
			return $obj;
		}
	}

	public function save() {
		if (!$this->id) {
			$this->create();
		} else {
			$this->update();
		}
	}

	public function create() {
		$sth = $GLOBALS['DB']->prepare('INSERT INTO ' . self::TABLE_NAME . ' ' . '(nom, permanent, notoriete, alcoolemie, alcoolemie_optimum, alcoolemie_max, fatigue, fatigue_max, sex_appeal, image, item_type, remaining_time, price)' . ' VALUES ( :nom, :permanent, :notoriete, :alcoolemie, :alcoolemie_optimum, :alcoolemie_max, :fatigue, :fatigue_max, :sex_appeal, :image, :item_type, :remaining_time, :price);');
		// $sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':nom', $this->nom, PDO::PARAM_STR);
		$sth->bindValue(':permanent', $this->permanent, PDO::PARAM_INT);
		$sth->bindValue(':notoriete', $this->notoriete, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie', $this->alcoolemie, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_optimum', $this->alcoolemie_optimum, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_max', $this->alcoolemie_max, PDO::PARAM_INT);
		$sth->bindValue(':fatigue', $this->fatigue, PDO::PARAM_INT);
		$sth->bindValue(':fatigue_max', $this->fatigue_max, PDO::PARAM_INT);
		$sth->bindValue(':sex_appeal', $this->sex_appeal, PDO::PARAM_INT);
		$sth->bindValue(':image', $this->image, PDO::PARAM_STR);
		$sth->bindValue(':item_type', $this->item_type, PDO::PARAM_STR);
		$sth->bindValue(':remaining_time', $this->remaining_time, PDO::PARAM_INT);
		$sth->bindValue(':price', $this->price, PDO::PARAM_INT);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
		$this->setId($GLOBALS['DB']->lastInsertId());
	}

	public function update() {
		$sth = $GLOBALS['DB']->prepare('UPDATE FROM ' . self::TABLE_NAME . ' SET nom=:nom, permanent=:permanent, notoriete=:notoriete, alcoolemie=:alcoolemie, alcoolemie_optimum=:alcoolemie_optimum, alcoolemie_max=:alcoolemie_max, fatigue=:fatigue, fatigue_max=:fatigue_max, sex_appeal=:sex_appeal, image=:image, item_type=:item_type, remaining_time=:remaining_time, price=:price WHERE id=:id;');
		$sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':nom', $this->nom, PDO::PARAM_STR);
		$sth->bindValue(':permanent', $this->permanent, PDO::PARAM_INT);
		$sth->bindValue(':notoriete', $this->notoriete, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie', $this->alcoolemie, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_optimum', $this->alcoolemie_optimum, PDO::PARAM_INT);
		$sth->bindValue(':alcoolemie_max', $this->alcoolemie_max, PDO::PARAM_INT);
		$sth->bindValue(':fatigue', $this->fatigue, PDO::PARAM_INT);
		$sth->bindValue(':fatigue_max', $this->fatigue_max, PDO::PARAM_INT);
		$sth->bindValue(':sex_appeal', $this->sex_appeal, PDO::PARAM_INT);
		$sth->bindValue(':image', $this->image, PDO::PARAM_STR);
		$sth->bindValue(':item_type', $this->item_type, PDO::PARAM_STR);
		$sth->bindValue(':remaining_time', $this->remaining_time, PDO::PARAM_STR);
		$sth->bindValue(':price', $this->price, PDO::PARAM_STR);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return false;
		}
	}

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $this->id . ';')->fetch(PDO::FETCH_ASSOC);
	}

	public function associatePlayer(Player $player) {
		self::associate($player->getId(), $this->getId());
	}

	public static function associate($idPlayer, $idItem) {
		$GLOBALS['DB']->query('INSERT INTO inventory (id_player, id_item) VALUES (' . $idPlayer . ',' . $idItem . ');');
	}

	public static function associateItem(Player $player, Item $item) {
		self::associate($player->getId(), $item->getId());
	}

	public static function desassociate($idPlayer, $idItem) {
		$GLOBALS['DB']->query('DELETE FROM inventory WHERE id_player=' . $idPlayer . ' AND id_item=' . $idItem . ' LIMIT 1;');
	}

	/**
	 *
	 * @param int $idPlayer        	
	 * @param int $idItem        	
	 * @return Item
	 */
	public static function isAssociated($idPlayer, $idItem) {
		$sth = $GLOBALS['DB']->prepare('SELECT item.* FROM inventory INNER JOIN item ON item.id = inventory.id_item WHERE inventory.id_player = :id_player AND inventory.id_item = :id_item;');
		$sth->bindValue(':id_player', $idPlayer, PDO::PARAM_INT);
		$sth->bindValue(':id_item', $idItem, PDO::PARAM_INT);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return false;
		}
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$obj = new self();
			//if ($arr['pnj'] > 0) {
			//	$obj = new Bot();
			//}
			$obj->populate($arr);
			return $obj;
		}
	}
}
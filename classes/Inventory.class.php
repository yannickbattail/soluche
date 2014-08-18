<?php
class Inventory extends AbstractDbObject {

	const TABLE_NAME = 'inventory';

	public static $fieldList = array('id' => PDO::PARAM_INT, 'id_player' => PDO::PARAM_INT, 'id_item' => PDO::PARAM_INT);

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $id_player = 0;

	public function getId_player() {
		return $this->id_player;
	}

	public function setId_player($id_player) {
		$this->id_player = $id_player;
	}


	protected $id_item = 0;

	public function getId_item() {
		return $this->id_item;
	}

	public function setId_item($id_item) {
		$this->id_item = $id_item;
	}

	public function defaultValues() {}
	
	function loadInvetory() {
		$sth = $GLOBALS['DB']->query('SELECT * FROM inventory WHERE id=' . intval($this->id_inventory));
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$this->id_item = $arr['id_item'];
			$this->id_player = $arr['id_player'];
			return $obj;
		}
	}
	
	protected $item = null;
	
	/**
	 * 
	 * @return Item
	 */
	public function getItem() {
		if (!$this->item) {
			$this->item = Item::load($this->id_item);
		}
		return $this->item;
	}

	protected $player = null;
	
	/**
	 * 
	 * @return Player
	 */
	public function getPlayer() {
		if (!$this->player) {
			$this->player = Player::load($this->id_player);
		}
		return $this->player;
	}
}

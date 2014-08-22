<?php
class Transaction extends AbstractDbObject {

	const TABLE_NAME = 'transaction';

	public static $fieldList = array('id' => PDO::PARAM_INT, 'id_inventory' => PDO::PARAM_INT, 'money' => PDO::PARAM_INT, 'id_item_exchange' => PDO::PARAM_INT, 'done' => PDO::PARAM_INT);

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $id_inventory = 0;

	public function getId_inventory() {
		return $this->id_inventory;
	}

	public function setId_inventory($id_inventory) {
		$this->id_inventory = $id_inventory;
	}

	protected $money = 0;

	public function getMoney() {
		return $this->money;
	}

	public function setMoney($money) {
		$this->money = $money;
	}

	protected $id_item_exchange = null;

	public function getId_item_exchange() {
		return $this->id_item_exchange;
	}

	public function setId_item_exchange($id_item_exchange) {
		$this->id_item_exchange = $id_item_exchange;
	}

	protected $done = 0;

	public function getDone() {
		return $this->done;
	}

	public function setDone($done) {
		$this->done = $done;
	}

	public function defaultValues() {
		$this->money = 0;
		$this->done = 0;
	}
	
	/**
	 * 
	 * @var Inventory
	 */
	protected $inventory = null;
	
	/**
	 * 
	 * @return Inventory
	 */
	public function getInventory() {
		if (!$this->inventory) {
			$this->inventory = Inventory::load($this->id_inventory);
		}
		return $this->inventory;
	}
}

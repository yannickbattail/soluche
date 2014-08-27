<?php
class Code extends AbstractDbObject {

	const TABLE_NAME = 'code';

	public static $fieldList = array('id' => PDO::PARAM_INT, 'number' => PDO::PARAM_INT, 'id_item' => PDO::PARAM_INT, 'id_player' => PDO::PARAM_INT);

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $number = 0;

	public function getNumber() {
		return $this->number;
	}

	public function setNumber($number) {
		$this->number = $number;
	}

	protected $id_player = null;

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

	public function defaultValues() {
		$this->number = rand(100000, 999999);
		$this->id_item = null;
		$this->id_player = null;
	}
	
	/**
	 *
	 * @param String $number
	 * @return Code
	 */
	public static function loadByNumber($number) {
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE number = :number;');
		$sth->bindValue(':number', $number, PDO::PARAM_STR);
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
			$obj->populate($arr);
			return $obj;
		}
	}
	
	
}

<?php
abstract class AbstractDbObject {

	const TABLE_NAME = 'table';

	/**
	 *
	 * @param array $assocArray        	
	 */
	public function populate(array $assocArray) {
		foreach ($assocArray as $field => $value) {
			if (!is_numeric($field) && property_exists($this, $field)) {
				//$setter = 'set' . ucfirst($field);
				//$this->$setter($value);
				$this->$field = $value;
			}
		}
	}

	/**
	 *
	 * @param String $id        	
	 * @return AbstractDbObject
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

	public abstract function create();

	public abstract function defaultValues();

	public abstract function update();

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $this->id . ';')->fetch(PDO::FETCH_ASSOC);
	}
}
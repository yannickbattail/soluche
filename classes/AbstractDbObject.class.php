<?php
abstract class AbstractDbObject {

	const TABLE_NAME = 'table';

	protected static $fieldList = array('id' => PDO::PARAM_INT);

	public abstract function defaultValues();

	/**
	 *
	 * @param array $assocArray        	
	 */
	public function populate(array $assocArray) {
		foreach ($assocArray as $field => $value) {
			if (!is_numeric($field) && property_exists($this, $field)) {
				// $setter = 'set' . ucfirst($field);
				// $this->$setter($value);
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
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . static::TABLE_NAME . ' WHERE id = :id;');
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
			$obj = new static();
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
		$sql = 'INSERT INTO ' . static::TABLE_NAME . ' ' . '(';
		$coma = '';
		foreach (static::$fieldList as $fieldName => $fieldType) {
			if ($fieldName != 'id') {
				$sql .= $coma . $fieldName;
				$coma = ', ';
			}
		}
		$sql .= ') VALUES (';
		$coma = '';
		foreach (static::$fieldList as $fieldName => $fieldType) {
			if ($fieldName != 'id') {
				$sql .= $coma . ' :' . $fieldName;
				$coma = ',';
			}
		}
		$sql .= ');';
		//echo $sql;
		$sth = $GLOBALS['DB']->prepare($sql);
		foreach (static::$fieldList as $fieldName => $fieldType) {
			if ($fieldName != 'id') {
				$sth->bindValue(':' . $fieldName, $this->$fieldName, $fieldType);
				//echo $fieldName.'='.$this->$fieldName;
			}
		}
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
		$this->setId($GLOBALS['DB']->lastInsertId());
	}

	public function update() {
		$sql = 'UPDATE ' . static::TABLE_NAME . ' SET ';
		$coma = '';
		foreach (static::$fieldList as $fieldName => $fieldType) {
			if ($fieldName != 'id') {
				$sql .= $coma . $fieldName . '=:' . $fieldName;
				$coma = ', ';
			}
		}
		$sql .= ' WHERE id=:id;';
		//echo $sql;
		$sth = $GLOBALS['DB']->prepare($sql);
		foreach (static::$fieldList as $fieldName => $fieldType) {
			$sth->bindValue(':' . $fieldName, $this->$fieldName, $fieldType);
			//echo $fieldName.'='.$this->$fieldName.' ';
		}
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
	}

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . static::TABLE_NAME . ' WHERE id=' . $this->id . ';')->execute();
	}
	
	// auto getter and setter
	/*
	public function __call($name, $arguments) {
		if (strpos($name, 'get') === 0) {
			$member = lcfirst(str_replace('get', '', $name));
			if (in_array($member, self::$fieldList)) {
				return $this->$member;
			} else {
				throw new Exception('no such member ' . $member . ' in class ' . __CLASS__);
			}
		} else if (strpos($name, 'set') === 0) {
			$member = lcfirst(str_replace('set', '', $name));
			if (in_array($member, self::$fieldList)) {
				$this->$member = $arguments[0];
			} else {
				throw new Exception('no such member ' . $member . ' in class ' . __CLASS__);
			}
		} else {
			throw new Exception('invalid method ' . $name . ' for class ' . __CLASS__);
		}
	}
	*/
}
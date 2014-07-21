<?php
abstract class AbstractDbObject {

	const TABLE_NAME = 'table';
	
	/**
	 *
	 * @param int $id        	
	 * @return AbstractDbObject
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
	

	public abstract  function create();

	public abstract function defaultValues();

	public abstract  function update();

	public function delete() {
	$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $this->id . ';')->fetch(PDO::FETCH_ASSOC);
}
	
}
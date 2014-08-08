<?php
class Soluche {

	public static $rules = array();

	public static function init() {
		self::$rules = json_decode(file_get_contents('rules.json'), true);
	}
}

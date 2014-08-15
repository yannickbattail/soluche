<?php
error_reporting(E_ALL | E_STRICT | E_NOTICE);
ini_set('error_reporting', E_ALL | E_STRICT | E_NOTICE);
ini_set('display_errors', 1);

function __autoload($classname) {
	$filename = "./classes/" . $classname . ".class.php";
	if (!file_exists($filename)) {
		$filename = "./actions/" . $classname . ".class.php";
	}
	include_once ($filename);
}
session_start();
require_once ('db.php');
require_once ('utilFunctions.php');

if (!isset($_SESSION['user']) || !($_SESSION['user'] instanceof Player)) {
	die('pas loggé');
}


$_SESSION['user'] = Player::load($_SESSION['user']->getId());
$_SESSION['user']->loadInventory();

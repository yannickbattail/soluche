<?php

function __autoload($classname) {
	$filename = "./classes/" . $classname . ".class.php";
	include_once ($filename);
}
session_start();
require_once ('db.php');
require_once ('utilFunctions.php');

$errorMessage = '';
if (!isset($_SESSION['user']) && !$_SESSION['user']) {
	header('Location: login.php');
}
$_SESSION['user'] = Player::load($_SESSION['user']->id);
$_SESSION['user']->loadInventory();

Action::haveToGoToPls($_SESSION['user']);

if ($_SESSION['user']->en_pls && (basename($_SERVER['SCRIPT_FILENAME']) != 'pls.php' /*avoid redirection loops*/)) {
	header('Location: pls.php');
}


<?php

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

if (!isset($_SESSION['user']) || !$_SESSION['user']) {
	header('Location: login.php');
}
$_SESSION['user'] = Player::load($_SESSION['user']->id);
$_SESSION['user']->loadInventory();
Dispatcher::setPage($_SESSION['user']->lieu);

if (isset($_REQUEST['page']) && $_REQUEST['page']) {
	Dispatcher::setPage($_REQUEST['page']);
}

if (isset($_REQUEST['action']) && $_REQUEST['action']) {
	Dispatcher::defineAction($_REQUEST['action'], $_SESSION['user'], $_REQUEST);
	$actionResult = Dispatcher::executeAction();
	if ($actionResult->succes == true) {
		if (isset($_SESSION['congress'])) {
			$_SESSION['congress']->addFatigue(-1);
		}
	}
	$_SESSION['user']->loadInventory(); // relaod inventory if changes has appeared
}

if (!isset($_SESSION['congress']) || !$_SESSION['congress']) {
	Dispatcher::setPage('congress');
}

Pls::haveToGoToPls($_SESSION['user']);
Pls::redirectPLS($_SESSION['user']);

$_SESSION['user']->lieu = Dispatcher::getPage();

$_SESSION['user']->save();

Dispatcher::displayPage();

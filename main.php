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

if (!isset($_SESSION['user']) || !($_SESSION['user'] instanceof Player)) {
	header('Location: login.php');
}
if (!isset($_SESSION['prevent_reexecute'])) {
	$_SESSION['prevent_reexecute'] = md5('' . time());
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
	$_SESSION['user']->loadInventory(); // reload inventory if changes has appeared
}

Pls::haveToGoToPls($_SESSION['user']);
Pls::redirectPLS($_SESSION['user']);

if (!$_SESSION['user']->getId_congress()) {
	Dispatcher::setPage('congress');
} else {
	if ($_SESSION['user']->getRemaining_time() <= 0) {
		$_SESSION['user']->getCongress()->stopCongress($_SESSION['user']);
	}
}

$_SESSION['user']->lieu = Dispatcher::getPage();

$_SESSION['user']->save();
if ($_SESSION['user']->getHistory()->getAction_name()) {
	if (($_SESSION['user']->getHistory()->getSuccess() === ActionResult::SUCCESS) || ($_SESSION['user']->getHistory()->getSuccess() === ActionResult::FAIL)) {
		$_SESSION['user']->getHistory()->save();
	}
}
Dispatcher::displayPage();

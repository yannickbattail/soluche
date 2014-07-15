<?php
class Dispatcher {

	/**
	 *
	 * @var ActionInterface
	 */
	private static $action = null;

	private static $page = 'camping';

	private static $pageTitle = 'Camping';
	
	// public static $bodyHtml = 'page vide';
	private static $errorMessage = '';

	private static $succesMessage = '';

	/**
	 *
	 * @param String $action        	
	 * @param Player $user        	
	 * @param array $params        	
	 */
	public static function defineAction($action, Player $user, array $params) {
		if ($action) {
			$filename = "./actions/" . $action . ".class.php";
			if (file_exists($filename)) {
				include_once ($filename);
			}
			$className = $action;
			self::setAction(new $className($user));
			self::$action->setParams($params);
		}
	}

	public static function executeAction() {
		if (self::$action) {
			$actionReturn = self::$action->execute();
			if ($actionReturn->succes) {
				self::addSuccessMessage($actionReturn->message);
			} else {
				self::addErrorMessage($actionReturn->message);
			}
			return $actionReturn->succes;
		}
		return null;
	}

	/**
	 *
	 * @param ActionInterface $action        	
	 */
	public static function setAction(ActionInterface $action) {
		self::$action = $action;
	}

	/**
	 *
	 * @return ActionInterface
	 */
	public static function getAction() {
		return self::$action;
	}

	public static function displayPage() {
		include_once ("./pages/layoutTop.php");
		$filename = "./pages/" . self::$page . ".php";
		include_once ($filename);
		include_once ("./pages/layoutBottom.php");
	}

	public static function setPage($page) {
		$filename = "./pages/" . $page . ".php";
		if (file_exists($filename)) {
			self::$page = $page;
			self::$pageTitle = ucfirst(str_replace('_', ' ', self::$page));
		} else {
			self::addErrorMessage(' La page ' . $page . ' n\'exite pas.');
		}
	}

	public static function getPage() {
		return self::$page;
	}

	public static function addSuccessMessage($succesMessage) {
		self::$succesMessage .= '<br />' . $succesMessage;
	}

	public static function getSuccessMessage() {
		return self::$succesMessage;
	}

	public static function addErrorMessage($errorMessage) {
		self::$errorMessage .= '<br />' . $errorMessage;
	}

	public static function getErrorMessage() {
		return self::$errorMessage;
	}
}

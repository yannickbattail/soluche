<?php
class Dispatcher {

	const MESSAGE_LEVEL_ERROR = 'errorException';

	const MESSAGE_LEVEL_INFO = 'infoMessage';

	const MESSAGE_LEVEL_SUCCES = 'successMessage';

	const MESSAGE_LEVEL_FAIL = 'errorMessage';

	private static $pageTitle = 'Camping';

	private static $messages = array();

	public static function addMessage($message, $level) {
		self::$messages[] = array('message' => $message,'level' => $level
		);
	}

	public static function getMessages() {
		return self::$messages;
	}

	private static $page = 'camping';

	public static function setPage($page) {
		$filename = "./pages/" . $page . ".php";
		if (file_exists($filename)) {
			self::$page = $page;
			self::$pageTitle = ucfirst(str_replace('_', ' ', self::$page));
		} else {
			self::addMessage(' La page ' . $page . ' n\'exite pas.', Dispatcher::MESSAGE_LEVEL_ERROR);
		}
	}

	public static function getPage() {
		return self::$page;
	}

	public static function displayPage() {
		include_once ("./pages/layoutTop.php");
		$filename = "./pages/" . self::$page . ".php";
		include_once ($filename);
		include_once ("./pages/layoutBottom.php");
	}

	/**
	 *
	 * @var ActionInterface
	 */
	private static $action = null;

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
				self::addMessage($actionReturn->message, Dispatcher::MESSAGE_LEVEL_SUCCES);
			} else {
				self::addMessage($actionReturn->message, Dispatcher::MESSAGE_LEVEL_FAIL);
			}
			$_SESSION['congress']->addHistory($actionReturn);
			return $actionReturn->succes;
		}
		return null;
	}
}

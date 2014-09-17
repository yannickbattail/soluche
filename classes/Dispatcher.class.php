<?php
class Dispatcher {

	const MESSAGE_LEVEL_ERROR = 'errorException';

	const MESSAGE_LEVEL_INFO = 'infoMessage';

	const MESSAGE_LEVEL_SUCCES = 'successMessage';

	const MESSAGE_LEVEL_FAIL = 'errorMessage';

	private static $messages = array();

	public static function addMessage($message, $level) {
		self::$messages[] = array('message' => $message, 'level' => $level);
	}

	public static function getMessages() {
		return self::$messages;
	}

	private static $page = 'camping';

	public static function setPage($page) {
		$tab = explode(':', $page);
		$filename = "./pages/" . $tab[0] . ".php";
		if (file_exists($filename)) {
			self::$page = $page;
		} else {
			self::addMessage(' La page ' . $tab[0] . ' n\'exite pas.', Dispatcher::MESSAGE_LEVEL_ERROR);
		}
	}

	public static function getPage() {
		return self::$page;
	}

	public static function displayPage() {
		include_once ("./layout.php");
	}
	
	public static function displayPageContent() {
		$tab = explode(':', self::$page);
		$filename = "./pages/" . $tab[0] . ".php";
		include_once ($filename);
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
	public static function defineAction($action, Player $player, array $params) {
		if ($action) {
			$filename = "./actions/" . $action . ".class.php";
			if (file_exists($filename)) {
				include_once ($filename);
			}
			$className = $action;
			self::setAction(new $className($player));
			self::$action->setParams($params);
		}
	}

	/**
	 *
	 * @return ActionResult NULL
	 */
	public static function executeAction() {
		if (self::$action) {
			$actionResult = self::$action->start();
			$pl = self::$action->getPlayer();
			$hstry = $pl->getHistory();
			$hstry->setId_player($pl->getId());
			$hstry->setLieu($pl->getLieu());
			$hstry->setId_congress($pl->getId_congress());
			$hstry->setAction_name(get_class(self::$action));
			$hstry->setDate_action(time());
			$hstry->setSuccess($actionResult->getSuccess());
			$hstry->setMessage($actionResult->getMessage());
			if ($actionResult->getSuccess() === ActionResult::SUCCESS) {
				self::addMessage($actionResult->getMessage(), Dispatcher::MESSAGE_LEVEL_SUCCES);
			} else if (($actionResult->getSuccess() === ActionResult::FAIL)) {
				self::addMessage($actionResult->getMessage(), Dispatcher::MESSAGE_LEVEL_FAIL);
			} else {
				self::addMessage($actionResult->getMessage(), Dispatcher::MESSAGE_LEVEL_INFO);
			}
			if (!isset($_SESSION['history'])) {
				$_SESSION['history'] = array();
			}
			$_SESSION['history'][] = $actionResult;
			return $actionResult;
		}
		return null;
	}
}

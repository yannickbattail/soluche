<?php
class AbstractAction implements ActionInterface {

	protected $paramName = null;

	protected $actionRight = null;

	protected $link_text = 'LINK_TEXT';

	protected $paramPrimaryKey = 0;

	/**
	 *
	 * @var Player
	 */
	protected $player;

	/**
	 * 
	 * @return Player
	 */
	public function getPlayer() {
		return $this->player;
	}
	
	/**
	 * 
	 * @param Player $player
	 */
	public function setPlayer(Player $player) {
		$this->player = $player;
	}
	
	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		$this->player = $player;
	}

	/**
	 *
	 * @param array $params        	
	 * @return $this
	 */
	public function setParams(array $params) {
		return $this;
	}

	/**
	 *
	 * @return ActionResult
	 */
	public function start() {
		$rights = $this->checkRights();
		if ($rights === true) {
			if ($_REQUEST['prevent_reexecute'] == $_SESSION['prevent_reexecute']) {
				$_SESSION['prevent_reexecute'] = md5('' . time());
				return $this->execute();
			} else {
				$actionResult = new ActionResult();
				$actionResult->setMessage('action déjà exécutée.');
				$actionResult->setSuccess(ActionResult::NOTHING);
				return $actionResult;
			}
		} else {
			$actionResult = new ActionResult();
			$actionResult->setMessage($rights);
			$actionResult->setSuccess(ActionResult::IMPOSSIBLE);
			return $actionResult;
		}
	}

	/**
	 *
	 * @return ActionResult
	 */
	protected function execute() {
		throw new Exception('AbstractAction example method');
		return new ActionResult();
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$url = 'main.php?action=' . urldecode(get_class($this)) . '&prevent_reexecute=' . $_SESSION['prevent_reexecute'];
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		if ($this->paramName) {
			$url .= '&' . $this->paramName . '=' . $this->paramPrimaryKey;
		}
		$htmlId = get_class($this) . '_' . $this->paramPrimaryKey;
		$rights = $this->checkRights();
		if ($rights === true) {
			return '<a href="' . $url . '" id="' . $htmlId . '" class="action" title="">' . $this->linkText . '</a>' . $this->statsDisplay();
		} else {
			return '<span  class="actionDisabled" title="' . htmlentities($rights) . '">' . $this->linkText . '</span>';
		}
	}

	const EXCEPT_TIRED = '1';

	const EXCEPT_PLS = '2';

	const EXCEPT_OUT_CONGRESS = '4';

	protected function checkRights() {
		if ($this->player->isFatigued() && !($this->actionRight & AbstractAction::EXCEPT_TIRED)) {
			return "Trop fatigué pour ça.";
		}
		if ($this->player->getEn_pls() && !($this->actionRight & AbstractAction::EXCEPT_PLS)) {
			return "En PLS.";
		}
		if (!$this->player->getId_congress() && !($this->actionRight & AbstractAction::EXCEPT_OUT_CONGRESS)) {
			return "On ne peut rien faire hors congrès";
		}
		return true;
	}

	public function statsDisplay($page = null) {
		throw new Exception('AbstractAction example method');
		return '';
	}
}

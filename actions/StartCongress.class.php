<?php
class StartCongress implements ActionInterface {

	const PARAM_NAME = 'idCongress';

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Congress
	 */
	private $congress;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		$this->player = $player;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Congress) {
			$this->congress = $params[self::PARAM_NAME];
		} else {
			$this->congress = Congress::load($params[self::PARAM_NAME]);
			if (!$this->congress) {
				throw new Exception('no such Congress: ' . $params[self::PARAM_NAME]);
			}
		}
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		return $this->congress->start($this->player);
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Aller à ce congrès';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		$url .= '&' . self::PARAM_NAME . '=' . $this->congress->getId();
		
		//if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"  class="action">' . $text . '</a>';
		//} else {
		//	return '<span  class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		//}
	}
}

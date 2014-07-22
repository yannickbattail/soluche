<?php
class StartPLS implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

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
		return $this;
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		return Pls::startToPls($this->player);
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Se mettre en PLS';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		// $url .= '&' . self::PARAM_NAME . '=' . $actionParams[self::PARAM_NAME]->getId();
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"  class="action">' . $text . '</a>';
		} else {
			return '<span class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		ob_start();
		?>
<table class="inventory">
	<tr class="odd">
		<td>PLS</td>
		<td>
			<img src="images/objets/unknown.png" class="inventoryImage" title="PLS" />
		</td>
	</tr>
	<tr class="even">
		<td>Notoriété</td>
		<td><?= plus(-1, 1); ?></td>
	</tr>
	<tr class="odd">
		<td>Verre</td>
		<td><?= plus(-1, 0); ?>/60sec</td>
	</tr>
</table>
<?php
		return ob_get_clean();
	}
}

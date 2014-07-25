<?php
class Sleep implements ActionInterface {

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
		$res = new ActionResult();
		if ($this->player->getFatigue() >= 1) {
			$_SESSION['congress']->addFatigue(-2);
			$this->player->addFatigue(-10);
			$res->message = 'Haa un bon dodo!';
			$res->succes = true;
		} else {
			$res->message = 'ON EST PAS FATIGUE! On est pas fatigué!';
			$res->succes = false;
		}
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Dodo';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		// $url .= '&' . self::PARAM_NAME . '=' . $actionParams[self::PARAM_NAME]->getId();
		$htmlId = __CLASS__;
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"id="' . $htmlId . '" class="action" title="">' . $text . '</a>' . $this->statsDisplay();
		} else {
			return '<span class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		$htmlId = __CLASS__;
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<td>Dodo</td>
			<td>
				<img src="images/sleep.png" class="inventoryImage" title="Dodo" />
			</td>
		</tr>
		<tr class="even">
			<td>fatigue</td>
			<td><?= plus(-10, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Heures</td>
			<td><?= plus(-3, 0); ?></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$("#<?= $htmlId ?>").tooltip({ 
		"content": $("#<?= $htmlId ?>_tooltip").html(), 
		"hide": { "delay": 1000, "duration": 500 }
	});
</script>
<?php
		return ob_get_clean();
	}
}

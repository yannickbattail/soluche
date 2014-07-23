<?php
class EndPLS implements ActionInterface {

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
		return Pls::endPLS($this->player);
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Finir la PLS';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		// $url .= '&' . self::PARAM_NAME . '=' . $actionParams[self::PARAM_NAME]->getId();
		$htmlId = __CLASS__;
		if (Pls::isPlsFinished($this->player)) {
			return '<a href="' . $url . '"  id="' . $htmlId . '" class="action" title="">' . $text . '</a>' . $this->statsDisplay();
		} else {
			return '<span class="actionDisabled" title="Pls non terminée">' . $text . '</span>';
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

<?php
class Vt implements ActionInterface {

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
		if ($this->player->getAlcoolemie() >= 1) {
			$this->player->addAlcoolemie(-1);
			$this->player->addNotoriete(-1);
			$this->player->addFatigue(1);
			$res->message = 'Dégueux!';
			$res->succes = true;
		} else {
			$res->message = 'alcoolemie déjà à 0.';
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
		$text = 'Faire un VT';
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
			<td>VT</td>
			<td>
				<img src="images/items/vomi.png" class="inventoryImage" title="VT" />
			</td>
		</tr>
		<tr class="even">
			<td>Notoriété</td>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Verre</td>
			<td><?= plus(-1, 0); ?></td>
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

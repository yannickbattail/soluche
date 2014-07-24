<?php
class Pins implements ActionInterface {

	const PARAM_NAME = 'idPlayer';

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Player
	 */
	private $opponent;

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
		if ($params[self::PARAM_NAME] instanceof Player) {
			$this->opponent = $params[self::PARAM_NAME];
		} else {
			$this->opponent = Player::load($params[self::PARAM_NAME]);
			if (!$this->opponent) {
				throw new Exception('no such player: ' . $params[self::PARAM_NAME]);
			}
		}
		$this->opponent->loadInventory();
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
		$this->opponent->addAlcoolemie(1);
		$this->opponent->addPoints(2);
		$this->opponent->save();
		$this->player->addPoints(1);
		$this->player->addNotoriete(1);
		$this->player->addFatigue(1);
		// $this->player->save(); // this is done at the end of the action execution.
		$res->message = 'Pin\'s';
		$res->succes = true;
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Pinser';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		$url .= '&' . self::PARAM_NAME . '=' . $this->opponent->getId();
		$htmlId = __CLASS__ . '_' . $this->opponent->getId();
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"  class="action" id="' . $htmlId . '" title="">' . $text . '</a>' . $this->statsDisplay();
		} else {
			return '<span  class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		// @TODO faire tous les champs
		$htmlId = __CLASS__ . '_' . $this->opponent->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="even">
			<th>Pinser</th>
			<th>
				<img src="images/items/pins.png" class="inventoryImage" title="pin's" />
			</th>
		</tr>
		<tr class="odd">
			<td>Points</td>
			<td><?= plus(1, 1); ?></td>
		</tr>
		<tr class="even">
			<td>Notoriété</td>
			<td><?= plus(1, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Fatigue</td>
			<td><?= plus(1, 0); ?></td>
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

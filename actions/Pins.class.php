<?php
class Pins extends AbstractAction {

	const PARAM_NAME = 'idPlayer';

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
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->linkText = 'Pinser';
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
		$this->paramPrimaryKey = $this->opponent->getId();
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
		$this->player->addRemaining_time(-1);
		// $this->player->save(); // this is done at the end of the action execution.
		$res->message = 'Pin\'s';
		$res->succes = true;
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		// @TODO faire tous les champs
		$htmlId = get_class($this) . '_' . $this->opponent->getId();
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
			<td>Crédibidulité</td>
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

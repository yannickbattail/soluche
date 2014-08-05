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
		$this->player->getHistory()->setId_opponent($this->opponent->getId());
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		$item = Item::loadByName('pins');
		if ($item) {
			$this->opponent->addAlcoolemie(1);
			$this->opponent->addPoints(2);
			$this->opponent->save();
			$this->player->addPoints(1);
			$this->player->addNotoriete(1);
			$this->player->addFatigue(1);
			$this->player->addRemaining_time(-1);
			Item::desassociate($this->player->getId(), $item->getId());
			$res->setMessage('Pin\'s');
			$res->setSuccess(ActionResult::SUCCESS);
		} else {
			$res->setMessage('a plu d\'Pin\'s');
			$res->setSuccess(ActionResult::FAIL);
		}
		if ($this->opponent->getPnj() == 0) { // si player
			$this->opponent->save();
		}
		// $this->player->save(); // this is done at the end of the action execution.
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
			<th>
				<img src="images/items/pins.png" class="inventoryImage" title="pin's" />
				<br />Pinser
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" width="32" height="32">
				<br />Succès
			</td>
			<td>
				<img src="images/emotes/face-sad.png" title="Echec" width="32" height="32">
				<br />Echec
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/badges/etoile doree belge.jpg" title="Rêves vendus" width="32" height="32">
				<br />Rêves vendus
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(0, 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/emotes/face-raspberry.png" title="Crédibidulité" width="32" height="32">
				<br />Crédibidulité
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(0, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
				<br />Fatigue
			</th>
			<td><?= plus(1, 0); ?></td>
			<td><?= plus(0, 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
				<br />¼ H
			</th>
			<td><?= plus(-1, 1)?></td>
			<td><?= plus(0, 1)?></td>
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

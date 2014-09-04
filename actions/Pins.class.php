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
		$item = $this->get1stPins();
		if ($item) {
			$this->opponent->addAlcoolemie(1);
			$this->opponent->addPoints(2);
			$this->opponent->save();
			$this->player->addPoints(0);
			$this->player->addNotoriete(1);
			$this->player->addFatigue(1);
			$this->player->addRemaining_time(-1);
			Item::desassociateItem($this->player, $item);
			Notification::notifyPlayer($this->opponent, 'Tu as reçu un pin\'s '.$item->htmlImage(32).' '.$item->getNom().' de la part de '.$this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . '.',
			 'Tu as reçu un pin\'s '.$item->getNom().' de la part de ' . $this->player->getNom() . '.', get_class($this));
			$res->setMessage('T\'as pinsé '.$this->opponent->getNom());
			$res->setSuccess(ActionResult::SUCCESS);
		} else {
			$res->setMessage('...a plu d\'Pin\'s :-( On peut en acheter au-près de l\'<a href="main.php?page=orga">orga</a>.');
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
	 * @return Item|boolean
	 */
	protected function get1stPins() {
		$sth = $GLOBALS['DB']->query('SELECT O.* FROM item O INNER JOIN inventory I ON I.id_item = O.id WHERE I.id_player = ' . $this->player->getId() . ' AND O.item_type = "pins" ORDER BY O.internal_name LIMIT 1;');
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		if ($sth && ($arr = $sth->fetch())) {
			$item = new Item();
			$item->populate($arr);
			return $item;
		} else {
			return false;
		}
	}
	
	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this) . '_' . $this->opponent->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="even">
			<th>
				<img src="images/items/pins.png" title="Pinser" alt="Pinser" />
				<br />Pinser
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès" />
			</td>
			<td>
				<img src="images/emotes/face-sad.png" title="Echec" alt="Echec" />
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus" width="24" height="24">
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(0, 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(0, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus(1, 0); ?></td>
			<td><?= plus(0, 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
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

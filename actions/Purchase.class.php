<?php
class Purchase extends AbstractAction {

	const PARAM_NAME = 'id_transaction';

	/**
	 *
	 * @var Transaction
	 */
	protected $transaction;

	/**
	 *
	 * @var Inventory
	 */
	protected $inventory;

	/**
	 *
	 * @var Item
	 */
	protected $item;

	/**
	 *
	 * @var Player
	 */
	protected $opponent;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Acheter';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if (isset($params[self::PARAM_NAME]) && $params[self::PARAM_NAME]) {
			$this->transaction = Transaction::load($params[self::PARAM_NAME]);
			$this->inventory = $this->transaction->getInventory();
		}
		if (!$this->transaction) {
			throw new Exception('no such transaction.');
		}
		$this->paramPrimaryKey = $this->transaction->getId();
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		// load other data
		$this->item = $this->inventory->getItem();
		$this->opponent = $this->inventory->getPlayer();
		$this->player->getHistory()->setId_item($this->item->getId());
		$this->player->getHistory()->setId_opponent($this->opponent->getId());
		
		$res = new ActionResult();
		if ($this->player->getMoney() < $this->transaction->getMoney()) {
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$res->setMessage('Pas assez de Dignichose pour acheter l\'item ' . $this->item->getNom() . '.');
		} else {
			$this->player->addMoney(-1 * $this->transaction->getMoney());
			$this->player->addPoints(1);
			$this->opponent->addPoints(1);
			$this->opponent->addMoney($this->transaction->getMoney());
			$this->transaction->delete();
			Item::associate($this->player->getId(), $this->item->getId());
			Item::desassociate($this->opponent->getId(), $this->item->getId());
			// if ($this->opponent->getPnj() == 0) { // si player
			$this->opponent->save();
			// }
			Notification::notifyPlayer($this->opponent, '' . $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' t\'a acheté l\'item ' . $this->item->htmlImage(32) . ' ' . $this->item->getNom() . ' pour ' . $this->transaction->getMoney() . ' Dignichoses.', '' . $this->player->getNom() . ' t\'a acheté l\'item ' . $this->item->getNom() . ' pour ' . $this->transaction->getMoney() . ' Dignichoses.', get_class($this));
			$res->setSuccess(ActionResult::SUCCESS);
			$res->setMessage('Item ' . $this->item->getNom() . ' acheté à ' . $this->opponent->getNom() . ' pour ' . $this->transaction->getMoney() . ' Dignichoses.');
		}
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this) . '_' . $this->transaction->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="odd">
			<th>Refiler</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès" />
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/Dignichose.png" title="Dignichose (la monnaie)" alt="Dignichose">
			</th>
			<td><?= plus(-1 * $this->transaction->getMoney(), 1)?></td>
		</tr>
		<th>
			<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
		</th>
		<td><?= plus(1, 1)?></td>
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

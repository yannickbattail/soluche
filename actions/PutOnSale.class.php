<?php
class PutOnSale extends AbstractAction {

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
	 * @var Inventory
	 */
	protected $price;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Mettre en vente';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		$this->price = $params['price'];
		if (isset($params['id_transaction']) && $params['id_transaction']) {
			$this->transaction = Transaction::load($params['id_transaction']);
			$this->inventory = $this->transaction->getInventory();
		} else {
			$this->inventory = Inventory::load($params['id_inventory']);
			$this->transaction = new Transaction();
			$this->transaction->defaultValues();
			$this->transaction->setId_inventory($this->inventory->getId());
		}
		if (!$this->inventory) {
			throw new Exception('no such item in transaction.');
		}
		$this->item = $this->inventory->getItem();
		$this->paramPrimaryKey = $this->inventory->getId();
		$this->player->getHistory()->setId_item($this->item->getId());
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		$res->setSuccess(ActionResult::NOTHING);
		if ($this->transaction->getId()) {
			$res->setMessage('Changement du prix de l\'item ' . $this->item->getNom() . ' à ' . $this->price . ' Dignichose.');
		} else {
			$res->setMessage('Item ' . $this->item->getNom() . ' mis en vente à ' . $this->price . ' Dignichose.');
		}
		$this->transaction->setPrice($this->price);
		$this->transaction->save();
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this) . '_' . $this->item->getId();
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
			<td><?= plus(floor(-$this->item->getPrice()*80/100), 1)?> -20% (<?= plus(-$this->item->getPrice(), 1)?>)</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
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

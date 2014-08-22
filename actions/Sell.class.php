<?php
class Sell extends AbstractAction {

	const PARAM_NAME = 'idItem';

	/**
	 *
	 * @var Item
	 */
	private $item;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Refiler';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Item) {
			$this->item = $params[self::PARAM_NAME];
		} else {
			$this->item = Item::load($params[self::PARAM_NAME]);
			if (!$this->item) {
				throw new Exception('no such item: ' . $params[self::PARAM_NAME]);
			}
		}
		$this->paramPrimaryKey = $this->item->getId();
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
		$money = floor(-$this->item->getMoney() * 80 / 100);
		if ($this->player->getMoney() < -$money) {
			$res->setSuccess(ActionResult::NOTHING);
			$res->setMessage('Pas assez de dignichose pour ça.');
			return $res;
		}
		$this->player->addMoney($money);
		Item::desassociate($this->player->getId(), $this->item->getId());
		$res->setSuccess(ActionResult::NOTHING);
		$res->setMessage('Item ' . $this->item->getNom() . ' refilé pour ' . $money . ' Dignichose.');
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
			<td><?= plus(floor(-$this->item->getMoney()*80/100), 1)?> -20% (<?= plus(-$this->item->getMoney(), 1)?>)</td>
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

<?php
class UseItem extends AbstractAction {

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
		$this->actionRight = AbstractAction::EXCEPT_TIRED;
		$this->linkText = 'Utiliser';
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
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if ($this->item->getPermanent()) {
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$res->setMessage('Cet item est permanent et ne peut etre utilisé.');
			return $res;
		}
		// @TODO verifier si l item est bien present dans inventaire du player
		$this->player->addNotoriete($this->item->getNotoriete());
		$this->player->addAlcoolemie($this->item->getAlcoolemie());
		$this->player->addAlcoolemie_optimum($this->item->getAlcoolemie_optimum());
		$this->player->addAlcoolemie_max($this->item->getAlcoolemie_max());
		$this->player->addFatigue($this->item->getFatigue());
		$this->player->addFatigue_max($this->item->getFatigue_max());
		$this->player->addSex_appeal($this->item->getSex_appeal());
		$this->player->addRemaining_time($this->item->getRemaining_time());
		Item::desassociate($this->player->getId(), $this->item->getId());
		$res->setSuccess(ActionResult::SUCCESS);
		$res->setMessage('Item ' . $this->item->getNom() . ' utilisé.');
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
			<th>Utiliser</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
			</th>
			<td><?= plus(5, 1)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus(-1, 1)?></td>
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

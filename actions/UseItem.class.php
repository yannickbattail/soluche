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
		$this->actionRight = null;
		$this->linkText = 'Utiliser';
	}

	/**
	 * (non-PHPdoc)
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
		if ($this->item->permanent) {
			$res->succes = false;
			$res->message = 'Cet item est permanent et ne peut etre utilisé.';
			return $res;
		}
		// @TODO verifier si l item est bien present dans inventaire du player
		$this->player->addNotoriete($this->item->notoriete);
		$this->player->addAlcoolemie($this->item->alcoolemie);
		$this->player->addAlcoolemie_optimum($this->item->alcoolemie_optimum);
		$this->player->addAlcoolemie_max($this->item->alcoolemie_max);
		$this->player->addFatigue($this->item->fatigue);
		$this->player->addFatigue_max($this->item->fatigue_max);
		$this->player->addSex_appeal($this->item->sex_appeal);
		$this->player->addRemaining_time(-1);
		Item::desassociate($this->player->getId(), $this->item->id);
		$res->succes = true;
		$res->message = 'Item ' . $this->item->nom . ' utilisé.';
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
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<td><?= $this->item->getNom(); ?></td>
			<td>
				<img src="<?= $this->item->getImage(); ?>" class="inventoryImage" title="<?= $this->item->getNom(); ?>" />
			</td>
		</tr>
		<tr class="even">
			<td>Permanant</td>
			<td><?= $this->item->getPermanent()?'oui':'non' ?></td>
		</tr>
		<tr class="odd">
			<td>Notoriété</td>
			<td><?= plus($this->item->getNotoriete(), 1); ?></td>
		</tr>
		<tr class="even">
			<td>Verre</td>
			<td><?= plus($this->item->getAlcoolemie(), 0); ?></td>
		</tr>
		<tr class="odd">
			<td>Verre optimum</td>
			<td><?= plus($this->item->getAlcoolemie_optimum(), 1); ?></td>
		</tr>
		<tr class="even">
			<td>Verre max</td>
			<td><?= plus($this->item->getAlcoolemie_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Fatigue</td>
			<td><?= plus($this->item->getFatigue(), 0); ?></td>
		</tr>
		<tr class="even">
			<td>Fatigue max</td>
			<td><?= plus($this->item->getFatigue_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Sexe appeal</td>
			<td><?= plus($this->item->getSex_appeal(), 1); ?></td>
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

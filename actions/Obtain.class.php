<?php
class Obtain extends AbstractAction {

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
		$this->linkText = 'Obtenir';
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
		if ($this->item->getItem_type() != 'level') {
			$res->setSuccess(ActionResult::NOTHING);
			$res->setMessage('Il ne s\'agit pas d\'un insigne de level.');
			return $res;
		}
		if ($this->player->getLevel() < $this->item->getMoney()) {
			$res->setSuccess(ActionResult::NOTHING);
			$res->setMessage('Vous n\'avez pas le level suffisant pour cet insigne.');
			return $res;
		}
		if ($this->countItemLevel($this->item->getMoney()) >= 2) {
			$res->setSuccess(ActionResult::NOTHING);
			$res->setMessage('Vous avez déjà 2 insignes pour ce level. (vas à la <a href="main.php?page=tente">tente</a> pour en enlever.)');
			return $res;
		}
		Item::associateItem($this->player, $this->item);
		$res->setSuccess(ActionResult::NOTHING);
		$res->setMessage('Insigne ' . $this->item->getNom() . ' ajouté pour le level '.$this->item->getMoney().'.');
		return $res;
	}
	
	protected function countItemLevel($level) {
		$cunt = 0;
		foreach ($this->player->getInventory() as $item) {
			if (($item->getItem_type() == 'level') && ($item->getMoney() == $level)) {
				$cunt++;
			}
		}
		return $cunt;
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
			<th>Obtenir</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
				<br />Succès
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/Dignichose.png" title="Dignichose (la monnaie)" alt="Dignichose">
			</th>
			<td><?= plus($this->item->getMoney(), 1)?></td>
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

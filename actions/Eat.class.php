<?php
class Eat extends AbstractAction {

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
		$this->linkText = 'Manger';
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
		if ($this->item->permanent) { // useless
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$res->setMessage('Cet item est permanent et ne peut etre utilisé.');
			return $res;
		}
		$this->player->addNotoriete($this->item->notoriete);
		$this->player->addAlcoolemie($this->item->alcoolemie);
		$this->player->addAlcoolemie_optimum($this->item->alcoolemie_optimum);
		$this->player->addAlcoolemie_max($this->item->alcoolemie_max);
		$this->player->addFatigue($this->item->fatigue);
		$this->player->addFatigue_max($this->item->fatigue_max);
		$this->player->addSex_appeal($this->item->sex_appeal);
		$this->player->addRemaining_time(-1);
		$res->setSuccess(ActionResult::SUCCESS);
		$res->setMessage('j\'ai bien mangé, j\'ai bien bu un(e) ' . $this->item->nom . '.');
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
	<table id="player_<?= $this->item->getId().'_'.$num ?>_tooltip">
		<tr class="odd">
			<th>Manger</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" width="32" height="32">
				<br />Succès
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/badges/etoile doree belge.jpg" title="Points" width="32" height="32">
				<br />Points
			</th>
			<td><?= plus(5, 1)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
				<br />¼ H
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

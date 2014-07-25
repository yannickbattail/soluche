<?php
class Drink implements ActionInterface {

	const PARAM_NAME = 'idItem';

	/**
	 *
	 * @var Player
	 */
	private $player;

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
		$this->player = $player;
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
			$res->succes = false;
			$res->message = 'Cet item est permanent et ne peut etre utilisé.';
			return $res;
		}
		$this->player->addNotoriete($this->item->notoriete);
		$this->player->addAlcoolemie($this->item->alcoolemie);
		$this->player->addAlcoolemie_optimum($this->item->alcoolemie_optimum);
		$this->player->addAlcoolemie_max($this->item->alcoolemie_max);
		$this->player->addFatigue($this->item->fatigue);
		$this->player->addFatigue_max($this->item->fatigue_max);
		$this->player->addSex_appeal($this->item->sex_appeal);
		$res->succes = true;
		$res->message = 'j\'ai bien mangé, j\'ai bien bu un(e) ' . $this->item->nom . '.';
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Manger/boire';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		$url .= '&' . self::PARAM_NAME . '=' . $this->item->getId();
		$htmlId = __CLASS__ . '_' . $this->item->getId();
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '" id="' . $htmlId . '" class="action" title="">' . $text . '</a>' . $this->statsDisplay();
		} else {
			return '<span class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		$htmlId = __CLASS__ . '_' . $this->item->getId();
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

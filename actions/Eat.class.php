<?php
class Eat implements ActionInterface {

	const PARAM_NAME = 'idObjet';

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Objet
	 */
	private $objet;

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
		if ($params[self::PARAM_NAME] instanceof Objet) {
			$this->objet = $params[self::PARAM_NAME];
		} else {
			$this->objet = Objet::load($params[self::PARAM_NAME]);
			if (!$this->objet) {
				throw new Exception('no such objet: ' . $params[self::PARAM_NAME]);
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
		if ($this->objet->permanent) { // useless
			$res->succes = false;
			$res->message = 'Cet objet est permanent et ne peut etre utilisé.';
			return $res;
		}
		$this->player->addNotoriete($this->objet->notoriete);
		$this->player->addAlcoolemie($this->objet->alcoolemie);
		$this->player->addAlcoolemie_optimum($this->objet->alcoolemie_optimum);
		$this->player->addAlcoolemie_max($this->objet->alcoolemie_max);
		$this->player->addFatigue($this->objet->fatigue);
		$this->player->addFatigue_max($this->objet->fatigue_max);
		$this->player->addSex_appeal($this->objet->sex_appeal);
		$res->succes = true;
		$res->message = 'j\'ai bien mangé, j\'ai bien bu un(e) ' . $this->objet->nom . '.';
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
		$url .= '&' . self::PARAM_NAME . '=' . $this->objet->getId();
		$htmlId = __CLASS__ . '_' . $this->objet->getId();
		// if (!$this->player->isFatigued()) {
		return '<a href="' . $url . '" id="' . $htmlId . '" class="action" title="">' . $text . '</a>' . $this->statsDisplay();
		// } else {
		// return '<span class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		// }
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		$htmlId = __CLASS__ . '_' . $this->objet->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<td><?= $this->objet->getNom(); ?></td>
			<td>
				<img src="<?= $this->objet->getImage(); ?>" class="inventoryImage" title="<?= $this->objet->getNom(); ?>" />
			</td>
		</tr>
		<tr class="even">
			<td>Permanant</td>
			<td><?= $this->objet->getPermanent()?'oui':'non' ?></td>
		</tr>
		<tr class="odd">
			<td>Notoriété</td>
			<td><?= plus($this->objet->getNotoriete(), 1); ?></td>
		</tr>
		<tr class="even">
			<td>Verre</td>
			<td><?= plus($this->objet->getAlcoolemie(), 0); ?></td>
		</tr>
		<tr class="odd">
			<td>Verre optimum</td>
			<td><?= plus($this->objet->getAlcoolemie_optimum(), 1); ?></td>
		</tr>
		<tr class="even">
			<td>Verre max</td>
			<td><?= plus($this->objet->getAlcoolemie_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Fatigue</td>
			<td><?= plus($this->objet->getFatigue(), 0); ?></td>
		</tr>
		<tr class="even">
			<td>Fatigue max</td>
			<td><?= plus($this->objet->getFatigue_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Sexe appeal</td>
			<td><?= plus($this->objet->getSex_appeal(), 1); ?></td>
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

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
		
		//if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"  class="action">' . $text . '</a>';
		//} else {
		//	return '<span  class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		//}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		ob_start();
		?>
<table class="inventory">
	<tr class="odd">
		<td><?= $objet->nom; ?></td>
		<td>
			<img src="<?= $objet->image; ?>" class="inventoryImage" title="<?= $objet->nom; ?>" />
		</td>
	</tr>
	<tr class="even">
		<td>Permanant</td>
		<td><?= $objet->permanent?'oui':'non' ?></td>
	</tr>
	<tr class="odd">
		<td>Notoriété</td>
		<td><?= plus($objet->notoriete, 1); ?></td>
	</tr>
	<tr class="even">
		<td>Verre</td>
		<td><?= plus($objet->alcoolemie, 0); ?></td>
	</tr>
	<tr class="odd">
		<td>Verre optimum</td>
		<td><?= plus($objet->alcoolemie_optimum, 1); ?></td>
	</tr>
	<tr class="even">
		<td>Verre max</td>
		<td><?= plus($objet->alcoolemie_max, 1); ?></td>
	</tr>
	<tr class="odd">
		<td>Fatigue</td>
		<td><?= plus($objet->fatigue, 0); ?></td>
	</tr>
	<tr class="even">
		<td>Fatigue max</td>
		<td><?= plus($objet->fatigue_max, 1); ?></td>
	</tr>
	<tr class="odd">
		<td>Sexe appeal</td>
		<td><?= plus($objet->sex_appeal, 1); ?></td>
	</tr>
</table>
<?php
		return ob_get_clean();
	}
}

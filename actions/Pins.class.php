<?php
class Pins implements ActionInterface {

	const PARAM_NAME = 'idPlayer';

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Player
	 */
	private $opponent;

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
		if ($params[self::PARAM_NAME] instanceof Player) {
			$this->opponent = $params[self::PARAM_NAME];
		} else {
			$this->opponent = Player::load($params[self::PARAM_NAME]);
			if (!$this->opponent) {
				throw new Exception('no such player: ' . $params[self::PARAM_NAME]);
			}
		}
		$this->opponent->loadInventory();
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
		$this->opponent->addAlcoolemie(1);
		$this->opponent->addPoints(2);
		$this->opponent->save();
		$this->player->addPoints(1);
		$this->player->addNotoriete(1);
		$this->player->addFatigue(1);
		// $this->player->save(); // this is done at the end of the action execution.
		$res->message = 'Pin\'s';
		$res->succes = true;
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Pinser';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		$url .= '&' . self::PARAM_NAME . '=' . $this->opponent->getId();
		
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"  class="action">' . $text . '</a>';
		} else {
			return '<span  class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		// @TODO faire tous les champs
		ob_start();
		?>
<table class="inventory">
	<tr class="odd">
		<td><?= $this->opponent->nom; ?></td>
		<td>
			<img src="<?= $this->opponent->photo; ?>" class="inventoryImage" title="<?= $this->opponent->nom; ?>" />
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

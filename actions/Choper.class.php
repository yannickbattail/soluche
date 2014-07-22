<?php
class Choper implements ActionInterface {

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
		if ($this->opponent->getSex() == $this->player->getSex()) {
			$res->message .= 'Pas de sex homo pour le momment. Ca viendra plus tard pour ajouter du piment au jeu ;-)';
			$res->succes = false;
			return $res;
		}
		/*
		 * $sex_appealDiff = 1 / abs($this->player->getCalculatedSex_appeal() - $this->opponent->getCalculatedSex_appeal()); $alcoolUser = 0.5 * $this->player->getCalculatedAlcoolemie() / $this->player->getCalculatedAlcoolemie_max(); $alcoolOpponent = 0.5 * $this->opponent->getCalculatedAlcoolemie() / $this->opponent->getCalculatedAlcoolemie_max(); $alcool = $alcoolUser + $alcoolOpponent; $notorieteDiff = $this->player->getCalculatedNotoriete() - $this->opponent->getCalculatedNotoriete();
		 */
		$coefPlayer = $this->player->getCalculatedSex_appeal() + $this->player->getCalculatedAlcoolemie() + $this->player->getCalculatedNotoriete();
		Dispatcher::addMessage("JOUEUR => sex appeal: " . $this->player->getCalculatedSex_appeal() . " + Verre: " . $this->player->getCalculatedAlcoolemie() . " + Notoriete: " . $this->player->getCalculatedNotoriete() . " = " . $coefPlayer, Dispatcher::MESSAGE_LEVEL_INFO);
		$coefOpponent = $this->opponent->getCalculatedSex_appeal() + $this->opponent->getCalculatedAlcoolemie() + $this->opponent->getCalculatedNotoriete();
		Dispatcher::addMessage("OPPOSANT => sex appeal: " . $this->opponent->getCalculatedSex_appeal() . " + Verre: " . $this->opponent->getCalculatedAlcoolemie() . " + Notoriete: " . $this->opponent->getCalculatedNotoriete() . " = " . $coefOpponent, Dispatcher::MESSAGE_LEVEL_INFO);
		if ($coefPlayer > $coefOpponent) {
			$this->player->addNotoriete(2);
			$this->player->addPoints(5);
			$this->player->addFatigue(2);
			$this->opponent->addNotoriete(2);
			$this->opponent->addPoints(5);
			$this->opponent->addFatigue(2);
			$res->message .= 'T\'as choppé ' . $this->opponent->getNom();
			$res->succes = true;
		} else {
			$this->player->addFatigue(1);
			$res->message .= 'T\'as pas réussi à chopper ' . $this->opponent->getNom();
			$res->succes = false;
		}
		$this->opponent->save();
		// $this->player->save(); // this is done at the end of the action execution.
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Essayer de choper';
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

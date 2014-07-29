<?php
class Duel extends AbstractAction {

	const PARAM_NAME = 'idPlayer';

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
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->linkText = 'Défier';
	}

	/**
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
		$this->paramPrimaryKey = $this->opponent->getId();
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
		$secUser = $this->player->getCalculatedAlcoolemie_max() - $this->player->getCalculatedAlcoolemie();
		$secOpponent = $this->opponent->getCalculatedAlcoolemie_max() - $this->opponent->getCalculatedAlcoolemie();
		$sec = 0;
		$res->message = ' Duel: ';
		// $res->message .= ' $secUser: ' . $secUser . ' $secOpponent: ' . $secOpponent; // debug
		if ($secUser > $secOpponent) {
			$sec = $secOpponent + 1;
			// $this->opponent->notoriete -= 1;
			$this->player->addNotoriete(2);
			$this->player->addPoints(5);
			$res->message .= ' ' . $this->player->nom . ' a gagné après s\'être affligé ' . $sec . ' secs.';
		} else if ($secUser < $secOpponent) {
			$sec = $secUser + 1;
			$this->opponent->addNotoriete(1);
			$this->opponent->addPoints(5);
			$this->player->addNotoriete(1);
			$res->message .= ' ' . $this->opponent->nom . ' a gagné après s\'être affligé ' . $sec . ' secs.';
		} else { // $secUser == $secOpponent
			$this->player->addNotoriete(-1);
			// $this->opponent->notoriete -= 1;
			$sec = $secOpponent + 1;
			$res->message .= ' Personne n\'a gagné après s\'être affligé ' . $sec . ' secs.';
		}
		$this->opponent->addAlcoolemie($sec);
		$this->player->addAlcoolemie($sec);
		$this->player->addFatigue(1);
		$this->opponent->save();
		// $this->player->save(); // this is done at the end of the action execution.
		$res->succes = true;
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this) . '_' . $this->opponent->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<td><?= $this->opponent->getNom(); ?></td>
			<td>
				<img src="<?= $this->opponent->getPhoto(); ?>" class="inventoryImage" title="<?= $this->opponent->getNom(); ?>" />
			</td>
		</tr>
		<tr class="even">
			<td>Points</td>
			<td><?= $this->opponent->getPoints() ?></td>
		</tr>
		<tr class="odd">
			<td>Crédibidulité</td>
			<td><?= plus($this->opponent->getNotoriete(), 1); ?></td>
		</tr>
		<tr class="even">
			<td>Verre</td>
			<td><?= plus($this->opponent->getAlcoolemie(), 0); ?></td>
		</tr>
		<tr class="odd">
			<td>Verre optimum</td>
			<td><?= plus($this->opponent->getAlcoolemie_optimum(), 1); ?></td>
		</tr>
		<tr class="even">
			<td>Verre max</td>
			<td><?= plus($this->opponent->getAlcoolemie_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Fatigue</td>
			<td><?= plus($this->opponent->getFatigue(), 0); ?></td>
		</tr>
		<tr class="even">
			<td>Fatigue max</td>
			<td><?= plus($this->opponent->getFatigue_max(), 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Sexe appeal</td>
			<td><?= plus($this->opponent->getSex_appeal(), 1); ?></td>
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

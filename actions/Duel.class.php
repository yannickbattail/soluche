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
		$this->player->getHistory()->setId_opponent($this->opponent->getId());
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
		// $res->message .= ' $secUser: ' . $secUser . ' $secOpponent: ' . $secOpponent; // debug
		if ($secUser > $secOpponent) {
			$sec = $secOpponent + 1;
			// $this->opponent->notoriete -= 1;
			$this->player->addNotoriete(0);
			$this->player->addPoints(5);
			$this->player->addMoney(10);
			Notification::notifyPlayer($this->opponent, $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' t\'as défié et a gagné après ' . $sec . ' secs.', $this->player->getNom() . ' t\'as défié et a gagné après ' . $sec . ' secs.', get_class($this));
			$res->setMessage('Défi: ' . $this->player->getNom() . ' a gagné après s\'être affligé ' . $sec . ' secs.');
			$res->setSuccess(ActionResult::SUCCESS);
		} else if ($secUser < $secOpponent) {
			$sec = $secUser + 1;
			$this->opponent->addNotoriete(0);
			$this->opponent->addPoints(5);
			$this->player->addNotoriete(0);
			Notification::notifyPlayer($this->opponent, $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' t\'as défié et a PERDU après ' . $sec . ' secs.', $this->player->getNom() . ' t\'as défié et a PERDU après ' . $sec . ' secs.', get_class($this));
			$res->setMessage('Défi: ' . $this->opponent->getNom() . ' a gagné après s\'être affligé ' . $sec . ' secs.');
			$res->setSuccess(ActionResult::FAIL);
		} else { // $secUser == $secOpponent
			$this->player->addNotoriete(0);
			// $this->opponent->notoriete -= 1;
			$sec = $secOpponent + 1;
			Notification::notifyPlayer($this->opponent, $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' t\'as défié et Personne n\'a gagné après ' . $sec . ' secs.', $this->player->getNom() . ' t\'as défié et Personne n\'a gagné après ' . $sec . ' secs.', get_class($this));
			$res->setMessage('Duel: Personne n\'a gagné après s\'être affligé ' . $sec . ' secs.');
			$res->setSuccess(ActionResult::FAIL);
		}
		$this->opponent->addAlcoolemie($sec);
		$this->player->addAlcoolemie($sec);
		$this->player->addFatigue(2);
		$this->player->addRemaining_time(-2);
		if ($this->opponent->getPnj() == 0) { // si player
			$this->opponent->save();
		}
		// $this->player->save(); // this is done at the end of the action execution.
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this) . '_' . $this->opponent->getId();
		$secUser = $this->player->getCalculatedAlcoolemie_max() - $this->player->getCalculatedAlcoolemie();
		$secOpponent = $this->opponent->getCalculatedAlcoolemie_max() - $this->opponent->getCalculatedAlcoolemie();
		$sec = min($secUser, $secOpponent);
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="odd">
			<th>Défier</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" title="Succès">
			</td>
			<td>
				<img src="images/emotes/face-plain.png" title="bof" title="bof">
			</td>
			<td>
				<img src="images/emotes/face-sad.png" title="Echec" title="Echec">
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
			</th>
			<td><?= plus(5, 1)?></td>
			<td><?= plus(5, 1)?></td>
			<td><?= plus(0, 1)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?= plus(2, 1)?></td>
			<td><?= plus(1, 1)?></td>
			<td><?= plus(-1, 1)?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope rouge.png" title="Verres" alt="Verres">
			</th>
			<td><?= plus($sec, 0)?></td>
			<td><?= plus($sec, 0)?></td>
			<td><?= plus($sec, 0)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus(2, 0)?></td>
			<td><?= plus(2, 0)?></td>
			<td><?= plus(2, 0)?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus(-2, 1)?></td>
			<td><?= plus(-2, 1)?></td>
			<td><?= plus(-2, 1)?></td>
		</tr>
		<tr class="even">
			<th colspan="4">Le nombre mini de verres pour que 1 des 2 finisse en PLS</th>
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

<?php
class Chopper extends AbstractAction {

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
		$this->linkText = 'Essayer de chopper';
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
		// if ($this->opponent->getSex() == $this->player->getSex()) {
		// $res->setMessage('Pas de sex homo pour le momment. Ca viendra plus tard pour ajouter du piment au jeu ;-)');
		// $res->setSuccess(ActionResult::IMPOSSIBLE);
		// return $res;
		// }
		/*
		 * $sex_appealDiff = 1 / abs($this->player->getCalculatedSex_appeal() - $this->opponent->getCalculatedSex_appeal()); $alcoolUser = 0.5 * $this->player->getCalculatedAlcoolemie() / $this->player->getCalculatedAlcoolemie_max(); $alcoolOpponent = 0.5 * $this->opponent->getCalculatedAlcoolemie() / $this->opponent->getCalculatedAlcoolemie_max(); $alcool = $alcoolUser + $alcoolOpponent; $notorieteDiff = $this->player->getCalculatedNotoriete() - $this->opponent->getCalculatedNotoriete();
		 */
		$coefPlayer = $this->player->getCalculatedSex_appeal() + $this->player->getCalculatedAlcoolemie() + $this->player->getCalculatedNotoriete();
		Dispatcher::addMessage("JOUEUR => sex appeal: " . $this->player->getCalculatedSex_appeal() . " + Verre: " . $this->player->getCalculatedAlcoolemie() . " + Notoriete: " . $this->player->getCalculatedNotoriete() . " = " . $coefPlayer, Dispatcher::MESSAGE_LEVEL_INFO);
		$coefOpponent = $this->opponent->getCalculatedSex_appeal() + $this->opponent->getCalculatedAlcoolemie() + $this->opponent->getCalculatedNotoriete();
		Dispatcher::addMessage("OPPOSANT => sex appeal: " . $this->opponent->getCalculatedSex_appeal() . " + Verre: " . $this->opponent->getCalculatedAlcoolemie() . " + Notoriete: " . $this->opponent->getCalculatedNotoriete() . " = " . $coefOpponent, Dispatcher::MESSAGE_LEVEL_INFO);
		if ($coefPlayer > $coefOpponent) {
			if ($this->player->getCalculatedAlcoolemie() > $this->player->getCalculatedAlcoolemie_optimum()) {
				$this->player->addPoints(2);
				$this->player->addNotoriete(0);
				$this->player->addFatigue(2);
				$this->player->addRemaining_time(-4);
				$this->player->addMoney(10);
				$this->opponent->addNotoriete(0);
				$this->opponent->addPoints(3);
				// $this->opponent->addFatigue(2);
				if (rand(1, 5) <= 1) {
					Item::associateItem($this->player, Item::loadByName('lime'));
				}
				if ($this->player->getSex()) {
					$res->setMessage('T\'as choppé ' . $this->opponent->getNom() . ' mais t\'es trop bourré! Tu bande mou mec...');
				} else {
					$res->setMessage('T\'as choppé ' . $this->opponent->getNom() . ' mais t\'es trop bourrée! Ho la belle étoile de mer.');
				}
				$res->setSuccess(ActionResult::FAIL);
			} else {
				$this->player->addPoints(5);
				$this->player->addNotoriete(0);
				$this->player->addFatigue(2);
				$this->player->addRemaining_time(-4);
				$this->player->addMoney(10);
				$this->opponent->addNotoriete(0);
				$this->opponent->addPoints(5);
				// $this->opponent->addFatigue(2);
				$res->setMessage('T\'as choppé ' . $this->opponent->getNom() . '.');
				$res->setSuccess(ActionResult::SUCCESS);
			}
			if (rand(1, 50) <= 1) {
				Item::associateItem($this->player, Item::loadByName('betterave'));
			}
			if (rand(1, 10) <= 1) {
				Item::associateItem($this->player, Item::loadByName('carotte'));
			}
			if (rand(1, 10) <= 1) {
				Item::associateItem($this->player, Item::loadByName('chou_fleur'));
			}
			if (rand(1, 10) <= 1) {
				Item::associateItem($this->player, Item::loadByName('poireau'));
			}
			if (rand(1, 10) <= 1) {
				Item::associateItem($this->player, Item::loadByName('navet'));
			}
			if (rand(1, 10) <= 1) {
				Item::associateItem($this->player, Item::loadByName('tomate'));
			}
			$itemCondom = Item::loadByName('condom');
			if (Item::isAssociated($this->player->getId(), $itemCondom->getId())) {
				Item::desassociate($this->player->getId(), $itemCondom->getId());
			} else {
				$res->setMessage($res->getMessage() . ' Plus de capotte, tu t\'es récuppéré un MST.');
				$itemCrabe = Item::loadByName('crabe');
				Item::associateItem($this->player, $itemCrabe);
			}
		} else {
			$this->player->addFatigue(1);
			$this->player->addRemaining_time(-1);
			$res->setMessage('T\'as pas réussi à chopper ' . $this->opponent->getNom());
			$res->setSuccess(ActionResult::FAIL);
		}
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
		ob_start();
		$num = 0;
		?>
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="odd">
			<th>Chopper</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
			</td>
			<td>
				<img src="images/emotes/face-plain.png" title="bof" alt="bof">
			</td>
			<td>
				<img src="images/emotes/face-sad.png" title="Echec" alt="Echec">
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
			</th>
			<td><?= plus(5, 1)?></td>
			<td><?= plus(2, 1)?></td>
			<td><?= plus(0, 1)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?= plus(2, 1)?></td>
			<td><?= plus(-1, 1)?></td>
			<td><?= plus(0, 1)?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus(2, 0)?></td>
			<td><?= plus(2, 0)?></td>
			<td><?= plus(1, 0)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus(-4, 1)?></td>
			<td><?= plus(-4, 1)?></td>
			<td><?= plus(-1, 1)?></td>
		</tr>
		<tr class="even">
			<td colspan="4">Pense aux capotes ;-)</td>
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

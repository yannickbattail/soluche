<?php
class AcceptInvite extends AbstractAction {

	const PARAM_NAME = 'id_invitation';

	/**
	 *
	 * @var Invitation
	 */
	private $invitation;

	/**
	 *
	 * @var Player
	 */
	private $opponent;

	/**
	 *
	 * @var Congress
	 */
	private $congress;

	/**
	 *
	 * @var string
	 */
	private $location;

	/**
	 *
	 * @var Game
	 */
	private $game;

	/**
	 *
	 * @var string
	 */
	private $message;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->linkText = 'Accepter l\'invitation';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Player) {
			$this->invitation = $params[self::PARAM_NAME];
		} else {
			$this->invitation = Invitation::load($params[self::PARAM_NAME]);
			// if (!$this->invitation) {
			// throw new Exception('no such invitation: ' . $params[self::PARAM_NAME]);
			// }
		}
		if ($this->invitation) {
			$this->opponent = Player::load($this->invitation->getHost());
			$this->opponent->loadInventory();
			if ($this->invitation->getId_congress()) {
				$this->congress = Congress::load($this->invitation->getId_congress());
			}
			$this->location = $this->invitation->getLocation();
			if ($this->invitation->getId_game()) {
				$this->game = Game::load($this->invitation->getId_game());
			}
			$this->message = $this->invitation->getMessage();
			$this->paramPrimaryKey = $this->invitation->getId();
			$this->player->getHistory()->setId_opponent($this->opponent->getId());
		}
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if (!$this->invitation) {
			$res->setMessage('L\'invitation est trop vieille ou n\'existe plus.');
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			return $res;
		}
		if ((time() - $this->invitation->getInvitation_date()) > (3600 * Invitation::TIME_LIMIT /* in hours */)) {
			$res->setMessage('L\'invitation est trop vieille.');
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$this->invitation->delete();
			return $res;
		}
		$this->invitation->delete();
		$this->player->addPoints(1);
		$this->opponent->addPoints(1);
		$this->opponent->save();
		if (rand(1, 50) <= 1) {
			Item::associateItem($this->player, Item::loadByName('panda'));
		}
		if (rand(1, 50) <= 1) {
			Item::associateItem($this->player, Item::loadByName('bambou'));
		}
		Notification::notifyPlayer($this->opponent, $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' est tombé dans ton traquenard.', $this->player->getNom() . ' est tombé dans ton traquenard.', get_class($this));
		$res->setMessage('Tu t\'es fait traquenardé.');
		$res->setSuccess(ActionResult::SUCCESS);
		return $res;
	}

	/**
	 *
	 * @return ActionResult
	 */
	public function start() {
		// overload to disable prevent_reexecute system
		$rights = $this->checkRights();
		if ($rights === true) {
			// disable prevent_reexecute system
			// if ($_REQUEST['prevent_reexecute'] == $_SESSION['prevent_reexecute']) {
			$_SESSION['prevent_reexecute'] = md5('' . time());
			return $this->execute();
			// } else {
			// $actionResult = new ActionResult();
			// $actionResult->setMessage('action déjà exécutée.');
			// $actionResult->setSuccess(ActionResult::NOTHING);
			// return $actionResult;
			// }
		} else {
			$actionResult = new ActionResult();
			$actionResult->setMessage($rights);
			$actionResult->setSuccess(ActionResult::IMPOSSIBLE);
			return $actionResult;
		}
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

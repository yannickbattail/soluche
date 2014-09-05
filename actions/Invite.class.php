<?php
class Invite extends AbstractAction {

	const PARAM_NAME = 'id_guest';

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
		$this->linkText = 'traquenarder';
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
		if (isset($params['id_congress']) && $params['id_congress']) {
			$this->congress = Congress::load($params['id_congress']);
		}
		if (isset($params['location']) && $params['location']) {
			$this->location = $params['location'];
		}
		if (isset($params['id_game']) && $params['id_game']) {
			$this->game = Game::load($params['id_game']);
		}
		if (isset($params['message']) && $params['message']) {
			$this->message = $params['message'];
		}
		$this->paramPrimaryKey = $this->opponent->getId();
		$this->player->getHistory()->setId_opponent($this->opponent->getId());
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		if (!$this->congress && !$this->location && !$this->game) {
			$res->setMessage('Un congrès, un lieu ou une partie doit être spécifié pour tarquenarder quelqu\'un.');
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			return $res;
		}
		$invitation = new Invitation();
		$invitation->defaultValues();
		$invitation->setHost($this->player->getId());
		$invitation->setGuest($this->opponent->getId());
		$invitation->setId_congress($this->congress?$this->congress->getId():null);
		$invitation->setLocation($this->location);
		$invitation->setId_game($this->game?$this->game->getId():null);
		$invitation->setMessage($this->message);
		$invitation->save();
		$msg = '';
		if ($this->location) {
			if ($this->location == 'cuisine') {
				$msg = 'à la cuisine';
			} else if ($this->location == 'danse') {
				$msg = 'sur la piste de danse';
			} else {
				$msg = 'au ' . $this->location;
			}
		} else if ($this->congress) {
			$msg = ' au congrès ' . $this->congress->getNom();
		} else if ($this->game) {
			$msg = ' pour jouer à la partie ' . $this->game->getNom();
		}
		$urlPrefix = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/soluche/main.php?id_invitation=' . $invitation->getId() . '&action=';
		$actionshtml = '<a href="' . $urlPrefix . 'AcceptInvite" class="action">Let\'s go</a> <a href="' . $urlPrefix . 'DenyInvite" class="action">Nope</a>';
		$actions = "\r\nLet's go: " . $urlPrefix . "AcceptInvite\r\nNope: " . $urlPrefix . "AcceptInvite";
		$invTime = 'Les invitations sont valables ' . Invitation::TIME_LIMIT . 'heures.';
		Notification::notifyPlayer($this->opponent, $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' essaye de te traquenarder ' . $msg . '. <br /><i>' . $invitation->getMessage() . '</i><br />' . $actionshtml . '<br />' . $invTime, $this->player->getNom() . ' essaye de te traquenarder ' . $msg . '. ' . "\r\n" . $invitation->getMessage() . "\r\n" . $actions . "\r\n" . $invTime, get_class($this));
		$res->setMessage('Traquenard mis en place...');
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

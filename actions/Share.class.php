<?php
class Share extends AbstractAction {

	const PARAM_NAME = 'id_item';

	/**
	 *
	 * @var Item
	 */
	private $item;

	/**
	 *
	 * @var array
	 */
	private $opponents = array();

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Partager';
	}

	/**
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
		if (isset($params['ids_player']) && $params['ids_player']) {
			foreach ($params['ids_player'] as $id_player) {
				$this->opponents[$id_player] = Player::load($id_player);
			}
		}
		$this->paramPrimaryKey = $this->item->getId();
		$this->player->getHistory()->setId_item($this->item->getId());
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
		if ($this->item->getPermanent()) {
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$res->setMessage('Cet item est permanent et ne peut etre utilisé.');
			return $res;
		}
		if (count($this->opponents) < 4) {
			$res->setSuccess(ActionResult::IMPOSSIBLE);
			$res->setMessage('On ne partage pas avec moins de 4 personnes.');
			return $res;
		}
		foreach ($this->opponents as $ip_player => $opponent) {
			$this->applyItem($opponent);
		}
		$this->applyItem($this->player);
		$this->player->addPoints(4);
		Item::desassociate($this->player->getId(), $this->item->getId());
		$res->setSuccess(ActionResult::SUCCESS);
		$res->setMessage('Vous avez partagé des valeurs ' . $this->item->htmlImage(32) . ' ' . $this->item->getNom() . ' avec des faluchards du congrès.');
		return $res;
	}

	protected function applyItem(Player $player) {
		if (!$player->getPnj()) {
			$player->loadInventory();
			$player->addPoints(1);
			// $player->addNotoriete($this->item->getNotoriete());
			$player->addAlcoolemie($this->item->getAlcoolemie());
			// $player->addAlcoolemie_optimum($this->item->getAlcoolemie_optimum());
			// $player->addAlcoolemie_max($this->item->getAlcoolemie_max());
			$player->addFatigue($this->item->getFatigue());
			// $player->addFatigue_max($this->item->getFatigue_max());
			// $player->addSex_appeal($this->item->getSex_appeal());
			$player->addRemaining_time($this->item->getRemaining_time());
			$player->save();
			if ($player->getId() != $this->player->getId()) { // pas de notif a soit meme
				Notification::notifyPlayer($player, $this->player->htmlPhoto(32) . ' ' . $this->player->getNom() . ' a partagé des valeurs ' . $this->item->htmlImage(32) . ' ' . $this->item->getNom() . ' avec vous.');
			}
		}
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$htmlId = get_class($this) . '_form_' . $this->item->getId();
		$rights = $this->checkRights();
		if ($rights !== true) {
			return '<span  class="actionDisabled" title="' . htmlentities($rights) . '">' . $this->linkText . '</span>';
		}
		ob_start();
		?>
<span class="action" onclick="$('#<?=$htmlId?>').show();$(this).hide();"><?= $this->linkText ?></span>
<div id="<?= $htmlId ?>" style="display: none;">
	<form action="main.php" method="post" onsubmit="if($(this.elements['ids_player[]']).val().length < 4) {alert('On ne partage pas avec moins de 4 personnes.');return false;}">
		<input type="hidden" name="action" value="<?= get_class($this) ?>" />
		<input type="hidden" name="prevent_reexecute" value="<?= $_SESSION['prevent_reexecute'] ?>" />
		<input type="hidden" name="<?= $this->paramName ?>" value="<?= $this->paramPrimaryKey ?>" />
		<label title="Faluchards avec qui partager les valeurs:">Faluchards avec qui partager les valeurs: <select name="ids_player[]" multiple="multiple" size="8">
				<?php
		$sql = 'SELECT * FROM player WHERE id != ' . $_SESSION['user']->getId() . ' AND id_congress = ' . $_SESSION['user']->getId_congress() . ' AND pnj < 2 ORDER BY nom;';
		$sth = $GLOBALS['DB']->query($sql);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		while ($sth && ($arr = $sth->fetch())) {
			$player = new Player();
			$player->populate($arr);
			?>
					<option value="<?= $player->getId() ?>"><?= $player->getNom() ?></option>
					<?php
		}
		?>
				</select>
		</label>
		<input type="submit" name="<?= get_class($this) ?>" value="<?= $this->linkText ?>" class="action" />
	</form>
</div>
<?php
		return ob_get_clean();
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this) . '_' . $this->item->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="odd">
			<th>Utiliser</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
			</td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
			</th>
			<td><?= plus(5, 1)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus(-1, 1)?></td>
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

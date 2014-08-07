<?php
class Sing extends AbstractAction {

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = null;
		$this->linkText = 'Chanter';
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::setParams()
	 */
	public function setParams(array $params) {
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
		$sql = 'SELECT count(*) AS counter FROM player WHERE id != ' . $this->player->getId() . ' AND id_congress = ' . $this->player->getId_congress() . ' AND lieu = "' . $this->player->getLieu() . '" ;';
		$stmt = $GLOBALS['DB']->query($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$count = $stmt->fetch();
		if ($count['counter'] >= 4) {
			if ($this->player->getCalculatedAlcoolemie() > $this->player->getCalculatedAlcoolemie_optimum()) {
				$this->player->addNotoriete(-1);
				$this->player->addAlcoolemie(1);
				$this->player->addFatigue(1);
				$this->player->addRemaining_time(-1);
				$res->setMessage('Trop bourré! tu chantes comme une casserole!');
				$res->setSuccess(ActionResult::FAIL);
			} else {
				$notoriete = 1;
				$itemCondom = Item::loadByName('cle de sol');
				if (Item::isAssociated($this->player->getId(), $itemCondom->getId())) {
					$notoriete = 2;
				}
				$this->player->addPoints(1);
				$this->player->addNotoriete($notoriete);
				$this->player->addAlcoolemie(1);
				$this->player->addFatigue(1);
				$this->player->addRemaining_time(-1);
				$res->setMessage('A chaque chanson faut y mettre son cannon! ♬');
				$res->setSuccess(ActionResult::SUCCESS);
			}
		} else {
			$res->setMessage('Seulement ' . $count['counter'] . ' personnes ici. On chante pas tout seul.');
			$res->setSuccess(ActionResult::IMPOSSIBLE);
		}
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this);
		ob_start();
		?>

<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="even">
			<th>
				<img src="images/items/pins.png" class="inventoryImage" title="Pinser" alt="Pinser" />
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" title="Succès">
			</td>
			<td>
				<img src="images/emotes/face-sad.png" title="Echec" title="Echec">
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/reves.png" title="Rêves vendus" alt="Rêves vendus">
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(0, 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?= plus(1, 1); ?> si cle de sol<?= plus(2, 1); ?></td>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/chope rouge.png" title="Verres" alt="Verres">
			</th>
			<td><?= plus(1, 0)?></td>
			<td><?= plus(1, 0)?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus(1, 0); ?></td>
			<td><?= plus(1, 0); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus(-1, 1)?></td>
			<td><?= plus(-1, 1)?></td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	$("#<?= $htmlId ?>_0").tooltip({ 
		"content": $("#<?= $htmlId ?>_tooltip").html(), 
		"hide": { "delay": 1000, "duration": 500 }
	});
</script>
<?php
		return ob_get_clean();
	}
}

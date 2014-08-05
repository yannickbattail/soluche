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
				$this->player->addPoints(1);
				$this->player->addNotoriete(1);
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
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="even">
			<th>
				<img src="images/items/pins.png" class="inventoryImage" title="pin's" />
				<br />Pinser
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" width="32" height="32">
				<br />Succès
			</td>
			<td>
				<img src="images/emotes/face-sad.png" title="Echec" width="32" height="32">
				<br />Echec
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/badges/etoile doree belge.jpg" title="Rêves vendus" width="32" height="32">
				<br />Rêves vendus
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(0, 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/emotes/face-raspberry.png" title="Crédibidulité" width="32" height="32">
				<br />Crédibidulité
			</th>
			<td><?= plus(1, 1); ?></td>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/badges/chope.jpg" title="Verres" width="32" height="32">
				<br />Verres
			</th>
			<td><?= plus(1, 0)?></td>
			<td><?= plus(1, 0)?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
				<br />Fatigue
			</th>
			<td><?= plus(1, 0); ?></td>
			<td><?= plus(1, 0); ?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
				<br />¼ H
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

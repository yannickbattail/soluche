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
	 *
	 * @see ActionInterface::setParams()
	 */
	public function setParams(array $params) {
		return $this;
	}

	/**
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
		if ($count['counter'] >= $this->rule['config']['numberPlayer']) {
			if ($this->player->hasItem('paillardier')) {
				if ($this->player->getCalculatedAlcoolemie() > $this->player->getCalculatedAlcoolemie_optimum()) {
					$this->player->addNotoriete(0);
					$this->player->addAlcoolemie(1);
					$this->player->addFatigue(1);
					$this->player->addRemaining_time(-1);
					$res->setMessage('Trop bourré! tu chantes comme une casserole!');
					$res->setSuccess(ActionResult::FAIL);
				} else if($this->player->hasItem('cle_de_sol')) {
					$this->player->addPoints(1);
					$this->player->addNotoriete(0);
					$this->player->addAlcoolemie(1);
					$this->player->addFatigue(1);
					$this->player->addRemaining_time(-1);
					$res->setMessage('A chaque chanson faut y mettre son cannon! ♬');
					$res->setSuccess(ActionResult::SUCCESS);
				} else {
					$this->player->addPoints(1);
					$this->player->addNotoriete(0);
					$this->player->addAlcoolemie(1);
					$this->player->addFatigue(1);
					$this->player->addRemaining_time(-1);
					$this->player->addMoney(5);
					$res->setMessage('A chaque chanson faut y mettre son cannon! ♬');
					$res->setSuccess(ActionResult::SUCCESS);
				}
			} else {
				$res->setMessage('Pour chanter il faut un paillardier. On peut l\'acheter au-près de l\'<a href="main.php?page=orga">orga</a>.');
				$res->setSuccess(ActionResult::IMPOSSIBLE);
			}
		} else {
			$res->setMessage('Seulement ' . $count['counter'] . ' personnes ici. On chante pas tout seul. (Il faut au moins ' . $this->rule['config']['numberPlayer'] . ' personnes)');
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
				<img src="images/badges/cle de sol.png" class="inventoryImage" title="Chanter" alt="Chanter" />
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

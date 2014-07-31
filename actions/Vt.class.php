<?php
class Vt extends AbstractAction {

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = null;
		$this->linkText = 'Faire un VT';
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
		if ($this->player->getAlcoolemie() >= 1) {
			$this->player->addNotoriete(-1);
			$this->player->addAlcoolemie(-1);
			$this->player->addFatigue(1);
			$this->player->addRemaining_time(-1);
			$res->setMessage('Dégueux!');
			$res->setSuccess(ActionResult::SUCCESS);
		} else {
			$res->setMessage('alcoolemie déjà à 0.');
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
				<img src="images/items/vomi.png" class="inventoryImage" title="pin's" />
				<br />VI
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" width="32" height="32">
				<br />Succès
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/emotes/face-raspberry.png" title="Crédibidulité" width="32" height="32">
				<br />Crédibidulité
			</th>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/badges/chope.jpg" title="Verres" width="32" height="32">
				<br />Verres
			</th>
			<td><?= plus(-1, 0)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
				<br />Fatigue
			</th>
			<td><?= plus(1, 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
				<br />¼ H
			</th>
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

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
			$this->player->addNotoriete(0);
			$this->player->addAlcoolemie(-1);
			$this->player->addFatigue(1);
			$this->player->addRemaining_time(-1);
			if (rand(1, 5) <= 1) {
				Item::associateItem($this->player, Item::loadByName('parapluie_ouvert'));
			}
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
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="even">
			<th>
				<img src="images/items/vomi.png" title="Vomi technique" alt="Vomi technique" />
				<br />VT
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/notoriété.png" title="Crédibidulité" alt="Crédibidulité">
			</th>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/chope rouge.png" title="Verres" alt="Verres">
			</th>
			<td><?= plus(-1, 0)?></td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus(1, 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
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

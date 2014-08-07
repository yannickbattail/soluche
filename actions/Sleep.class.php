<?php
class Sleep extends AbstractAction {

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = null;
		$this->actionRight = AbstractAction::EXCEPT_TIRED;
		$this->linkText = 'Dodo';
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
		if ($this->player->getFatigue() >= 2) {
			$this->player->addRemaining_time(-2);
			$this->player->addFatigue(-5);
			$res->setMessage('Haa un bon dodo! Je fais pas une PLS d\'abord! Je médite allongé.');
			$res->setSuccess(ActionResult::SUCCESS);
		} else {
			$res->setMessage('ON EST PAS FATIGUE! On est pas fatigué!');
			$res->setSuccess(ActionResult::NOTHING);
		}
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		$htmlId = get_class($this).'_0';
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" class="hiddenTooltip">
	<table class="inventory playerTooltip">
		<tr class="odd">
			<th>
				<img src="images/util/tent-sleep-icon.png" title="Dodo" alt="Dodo" />
				<br />Dodo
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/sleep.png" title="Fatigue" alt="Fatigue">
			</th>
			<td><?= plus(-5, 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" title="¼ d'heure" alt="¼ d'heure">
			</th>
			<td><?= plus(-2, 1)?></td>
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

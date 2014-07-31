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
			$res->setMessage('Haa un bon dodo! Je fais pas une PLS je médite allongé.');
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
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<th>
				<img src="images/sleep.png" class="inventoryImage" title="Dodo" />
				<br />Dodo
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" width="32" height="32">
				<br />Succès
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/emotes/face-uncertain.png" title="Fatigue" width="32" height="32">
				<br />Fatigue
			</th>
			<td><?= plus(-5, 0); ?></td>
		</tr>
		<tr class="even">
			<th>
				<img src="images/util/time.png" alt="¼ d'heure" width="32" height="32">
				<br />¼ H
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

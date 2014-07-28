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
		if ($this->player->getFatigue() >= 1) {
			$this->player->addRemaining_time(-3);
			$this->player->addFatigue(-10);
			$res->message = 'Haa un bon dodo!';
			$res->succes = true;
		} else {
			$res->message = 'ON EST PAS FATIGUE! On est pas fatigué!';
			$res->succes = false;
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
		<tr class="odd">
			<td>Dodo</td>
			<td>
				<img src="images/sleep.png" class="inventoryImage" title="Dodo" />
			</td>
		</tr>
		<tr class="even">
			<td>fatigue</td>
			<td><?= plus(-10, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Heures</td>
			<td><?= plus(-3, 0); ?></td>
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

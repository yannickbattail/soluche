<?php
class StartPLS extends AbstractAction {

	const PARAM_NAME = '';

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->linkText = 'Se mettre en PLS';
	}

	/**
	 * (non-PHPdoc)
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
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
		return Pls::startToPls($this->player);
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
			<td>PLS</td>
			<td>
				<img src="images/items/unknown.png" class="inventoryImage" title="PLS" />
			</td>
		</tr>
		<tr class="even">
			<td>Crédibidulité</td>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Verre</td>
			<td><?= plus(-1, 0); ?>/60sec</td>
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

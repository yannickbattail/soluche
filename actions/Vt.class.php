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
			$this->player->addAlcoolemie(-1);
			$this->player->addNotoriete(-1);
			$this->player->addFatigue(1);
			$this->player->addRemaining_time(-1);
			$res->message = 'Dégueux!';
			$res->succes = true;
		} else {
			$res->message = 'alcoolemie déjà à 0.';
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
			<td>VT</td>
			<td>
				<img src="images/items/vomi.png" class="inventoryImage" title="VT" />
			</td>
		</tr>
		<tr class="even">
			<td>Crédibidulité</td>
			<td><?= plus(-1, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Verre</td>
			<td><?= plus(-1, 0); ?></td>
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

<?php
class SendGlobalMessage extends AbstractAction {

	const PARAM_NAME = 'message';

	protected $message = '';

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = AbstractAction::EXCEPT_OUT_CONGRESS | AbstractAction::EXCEPT_PLS | AbstractAction::EXCEPT_TIRED;
		$this->linkText = 'message global';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 */
	public function setParams(array $params) {
		$this->message = $params[self::PARAM_NAME];
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		$this->player->addMoney(-1);
		Chat::sendGlobalMessage(htmlentities($this->message));
		$res->setMessage('Message envoyé.');
		$res->setSuccess(ActionResult::NOTHING);
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
				<img src="images/items/message global.png" title="message global" alt="message global" />
				<br />message global
			</th>
			<td>
				<img src="images/emotes/face-smile.png" title="Succès" alt="Succès">
			</td>
		</tr>
		<tr class="odd">
			<th>
				<img src="images/util/Dignichose.png" title="Dignichose (la monnaie)" alt="Dignichose">
			</th>
			<td><?= plus(-1, 1); ?></td>
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

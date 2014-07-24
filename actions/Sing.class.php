<?php
class Sing implements ActionInterface {

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		$this->player = $player;
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
		$sql = 'SELECT count(*) AS counter FROM player WHERE id != ' . $this->player->getId() . ' AND id_congress = ' . $_SESSION['congress']->getId() . ' AND lieu = "' . $this->player->getLieu() . '" ;';
		$stmt = $GLOBALS['DB']->query($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$count = $stmt->fetch();
		if ($count['counter'] >= 4) {
			if ($this->player->getCalculatedAlcoolemie() > $this->player->getCalculatedAlcoolemie_optimum()) {
				$this->player->addNotoriete(-1);
				$this->player->addFatigue(1);
				$res->message = 'Trop bourré! tu chantes comme une casserole!';
				$res->succes = false;
			} else {
				$this->player->addPoints(1);
				$this->player->addNotoriete(1);
				$this->player->addFatigue(1);
				$res->message = 'A chaque chanson faut y mettre son cannon! ♬';
				$res->succes = true;
			}
		} else {
			$res->message = 'Seulement ' . $count['counter'] . ' personnes ici. On chante pas tout seul.';
			$res->succes = false;
		}
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Chanter';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		// $url .= '&' . self::PARAM_NAME . '=' . $actionParams[self::PARAM_NAME]->getId();
		$htmlId = __CLASS__;
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '"id="' . $htmlId . '" class="action" title="">' . $text . '</a>' . $this->statsDisplay();
		} else {
			return '<span class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		$htmlId = __CLASS__;
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="inventory">
		<tr class="odd">
			<td>Chanson &#9836;</td>
			<td>
				<img src="images/badges/cle de sol.jpg" class="inventoryImage" title="VT" />
			</td>
		</tr>
		<tr class="even">
			<td>Notoriété</td>
			<td><?= plus(1, 1); ?></td>
		</tr>
		<tr class="odd">
			<td>Points</td>
			<td><?= plus(1, 1); ?></td>
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

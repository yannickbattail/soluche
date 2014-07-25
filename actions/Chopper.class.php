<?php
class Chopper implements ActionInterface {

	const PARAM_NAME = 'idPlayer';

	/**
	 *
	 * @var Player
	 */
	private $player;

	/**
	 *
	 * @var Player
	 */
	private $opponent;

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
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if ($params[self::PARAM_NAME] instanceof Player) {
			$this->opponent = $params[self::PARAM_NAME];
		} else {
			$this->opponent = Player::load($params[self::PARAM_NAME]);
			if (!$this->opponent) {
				throw new Exception('no such player: ' . $params[self::PARAM_NAME]);
			}
		}
		$this->opponent->loadInventory();
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
		if ($this->opponent->getSex() == $this->player->getSex()) {
			$res->message .= 'Pas de sex homo pour le momment. Ca viendra plus tard pour ajouter du piment au jeu ;-)';
			$res->succes = false;
			return $res;
		}
		/*
		 * $sex_appealDiff = 1 / abs($this->player->getCalculatedSex_appeal() - $this->opponent->getCalculatedSex_appeal()); $alcoolUser = 0.5 * $this->player->getCalculatedAlcoolemie() / $this->player->getCalculatedAlcoolemie_max(); $alcoolOpponent = 0.5 * $this->opponent->getCalculatedAlcoolemie() / $this->opponent->getCalculatedAlcoolemie_max(); $alcool = $alcoolUser + $alcoolOpponent; $notorieteDiff = $this->player->getCalculatedNotoriete() - $this->opponent->getCalculatedNotoriete();
		 */
		$coefPlayer = $this->player->getCalculatedSex_appeal() + $this->player->getCalculatedAlcoolemie() + $this->player->getCalculatedNotoriete();
		Dispatcher::addMessage("JOUEUR => sex appeal: " . $this->player->getCalculatedSex_appeal() . " + Verre: " . $this->player->getCalculatedAlcoolemie() . " + Notoriete: " . $this->player->getCalculatedNotoriete() . " = " . $coefPlayer, Dispatcher::MESSAGE_LEVEL_INFO);
		$coefOpponent = $this->opponent->getCalculatedSex_appeal() + $this->opponent->getCalculatedAlcoolemie() + $this->opponent->getCalculatedNotoriete();
		Dispatcher::addMessage("OPPOSANT => sex appeal: " . $this->opponent->getCalculatedSex_appeal() . " + Verre: " . $this->opponent->getCalculatedAlcoolemie() . " + Notoriete: " . $this->opponent->getCalculatedNotoriete() . " = " . $coefOpponent, Dispatcher::MESSAGE_LEVEL_INFO);
		if ($coefPlayer > $coefOpponent) {
			$this->player->addNotoriete(2);
			$this->player->addPoints(5);
			$this->player->addFatigue(2);
			$this->opponent->addNotoriete(2);
			$this->opponent->addPoints(5);
			$this->opponent->addFatigue(2);
			$res->message .= 'T\'as choppé ' . $this->opponent->getNom();
			$res->succes = true;
		} else {
			$this->player->addFatigue(1);
			$res->message .= 'T\'as pas réussi à chopper ' . $this->opponent->getNom();
			$res->succes = false;
		}
		$this->opponent->save();
		// $this->player->save(); // this is done at the end of the action execution.
		return $res;
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$text = 'Essayer de chopper';
		$url = 'main.php?action=' . urldecode(__CLASS__);
		if ($page) {
			$url .= '&page=' . urldecode($page);
		}
		$url .= '&' . self::PARAM_NAME . '=' . $this->opponent->getId();
		$htmlId = __CLASS__ . '_' . $this->opponent->getId();
		if (!$this->player->isFatigued()) {
			return '<a href="' . $url . '" id="' . $htmlId . '" class="action" title="">' . $text . '</a>' . $this->statsDisplay();
		} else {
			return '<span  class="actionDisabled" title="Trop fatigué pour ça.">' . $text . '</span>';
		}
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay() {
		$htmlId = __CLASS__ . '_' . $this->opponent->getId();
		ob_start();
		?>
<div id="<?= $htmlId ?>_tooltip" style="display: none;">
	<table class="playerTooltip" id="player_<?= $this->opponent->getId().'_'.$num ?>_tooltip" style="display: none;">
		<tr class="odd">
			<th>Nom</th>
			<td><?= $this->opponent->getNom(); ?> <?php echo $this->opponent->getSex()?'<span style="color:blue">&#9794;</span>':'<span style="color:pink">&#9792;</span>'; ?></td>
		</tr>
		<tr class="even">
			<th>Points</th>
			<td><?=$this->opponent->getPoints(); ?></td>
		</tr>
		<tr class="odd">
			<th>Notoriété</th>
			<td><?=$this->opponent->getNotoriete(); ?></td>
		</tr>
		<tr class="even">
			<th>Verre</th>
			<td><?= lifeBarMiddle($this->opponent->getAlcoolemie_max(), $this->opponent->getAlcoolemie_optimum(), $this->opponent->getAlcoolemie()); ?> <?=$this->opponent->getAlcoolemie().'/'.$this->opponent->getAlcoolemie_max().' optimum à '.$this->opponent->getAlcoolemie_optimum(); ?></td>
		</tr>
		<tr class="odd">
			<th>Fatigue</th>
			<td><?=lifeBar($this->opponent->getFatigue_max(), $this->opponent->getFatigue()).$this->opponent->getFatigue().'/'.$this->opponent->getFatigue_max(); ?></td>
		</tr>
		<!--
	<tr class="odd">
		<th>sex_appeal</th>
		<td><?=$this->opponent->getSex_appeal(); ?></td>
	</tr>
	-->
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

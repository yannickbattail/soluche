<?php
class CreateGame extends AbstractAction {

	const PARAM_NAME = '';

	/**
	 *
	 * @var Game
	 */
	protected $game;

	/**
	 *
	 * @var Game
	 */
	protected $game_type;

	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Lancer une partie';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if (isset($params['game_type'])) {
			$this->game_type = $params['game_type'];
		}
		// $this->paramPrimaryKey = $this->game->getId();
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		if ($this->player->hasItem('de_a_jouer')) {
			$this->game = new Game();
			$this->game->defaultValues();
			$this->game->setGame_type($this->game_type);
			$game_data = array('participants' => array(), 'tour' => 0, 'started' => false);
			$this->game->setGame_data($game_data);
			// $this->game->setNom($nom);
			$this->game->participate($this->player);
			$res = new ActionResult();
			$res->setSuccess(ActionResult::NOTHING);
			$res->setMessage('Partie lancée.');
			return $res;
		} else {
			$res = new ActionResult();
			$res->setSuccess(ActionResult::NOTHING);
			$res->setMessage('Pour chanter il faut un dé pour créer. On peut l\'acheter au-près de l\'<a href="main.php?page=orga">orga</a>.');
			return $res;
		}
	}

	/**
	 *
	 * @param array $actionParams        	
	 * @param string $page        	
	 * @return string
	 */
	public function link($page = null) {
		$htmlId = get_class($this) . '_form';
		$rights = $this->checkRights();
		if ($rights !== true) {
			return '<span  class="actionDisabled" title="' . htmlentities($rights) . '">' . $this->linkText . '</span>';
		}
		ob_start();
		?>
<div id="<?= $htmlId ?>">
	<form action="main.php" method="post">
		<input type="submit" name="<?= get_class($this) ?>" value="<?= $this->linkText ?>" class="action" />
		<input type="hidden" name="action" value="<?= get_class($this) ?>" />
		<input type="hidden" name="prevent_reexecute" value="<?= $_SESSION['prevent_reexecute'] ?>" />
		<label title="Faluchards avec qui partager les valeurs:"><select name="game_type">
				<option value="bizkit">bizkit</option>
			</select> </label>
	</form>
</div>
<?php
		return ob_get_clean();
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		return '';
	}
}

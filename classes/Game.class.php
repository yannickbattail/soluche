<?php
class Game extends AbstractDbObject {

	const TABLE_NAME = 'game';

	public static $fieldList = array('id' => PDO::PARAM_INT, 'nom' => PDO::PARAM_STR, 'game_type' => PDO::PARAM_STR, 'date_start' => PDO::PARAM_INT, 'game_data' => PDO::PARAM_STR);

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $nom = '';

	public function getNom() {
		if (!$this->nom) {
			return $this->game_type . '-' . $this->id;
		}
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	protected $game_type = '';

	public function getGame_type() {
		return $this->game_type;
	}

	public function setGame_type($game_type) {
		if ($game_type != 'bizkit') {
			throw new Exception('no such game type: ' . $game_type);
		}
		$this->game_type = $game_type;
	}

	protected $date_start = '';

	public function getDate_start() {
		return $this->date_start;
	}

	public function setDate_start($date_start) {
		$this->date_start = $date_start;
	}

	protected $game_data = '';

	/**
	 *
	 * @return array
	 */
	public function getGame_data() {
		return json_decode($this->game_data, true);
	}

	/**
	 *
	 * @param array $game_data        	
	 */
	public function setGame_data(array $game_data) {
		$this->game_data = json_encode($game_data);
	}

	public function defaultValues() {
		$this->game_type = 'bizkit';
		$this->nom = '';
		$this->date_start = time();
		$this->game_data = '{}';
	}

	public function participate(Player $player) {
		Dispatcher::setPage('game');
		$gameBizkit = new GameBizkit();
		$gameBizkit->populate($this->getGame_data());
		$gameBizkit->loadParticipants();
		$gameBizkit->addParticipant($player);
		$this->setGame_data($gameBizkit->export());
		$this->save();
		$_SESSION['game'] = $this->getId();
	}
}

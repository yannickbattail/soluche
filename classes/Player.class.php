<?php
class Player extends AbstractDbObject {

	const TABLE_NAME = 'player';

	protected static $fieldList = array('id' => PDO::PARAM_INT, 'nom' => PDO::PARAM_STR, 'pass' => PDO::PARAM_STR, 'lieu' => PDO::PARAM_STR, 'points' => PDO::PARAM_INT, 'notoriete' => PDO::PARAM_INT, 'alcoolemie' => PDO::PARAM_INT, 'alcoolemie_optimum' => PDO::PARAM_INT, 
			'alcoolemie_max' => PDO::PARAM_INT, 'fatigue' => PDO::PARAM_INT, 'fatigue_max' => PDO::PARAM_INT, 'sex_appeal' => PDO::PARAM_INT, 'en_pls' => PDO::PARAM_INT, 'debut_de_pls' => PDO::PARAM_INT, 'sex' => PDO::PARAM_INT, 'photo' => PDO::PARAM_STR, 'pnj' => PDO::PARAM_INT, 
			'id_congress' => PDO::PARAM_INT, 'remaining_time' => PDO::PARAM_INT, 'money' => PDO::PARAM_INT);

	const PNJ_PLAYER = 0;

	const PNJ_BOT = 1;

	const PNJ_ORGA = 2;

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $nom = '';

	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	protected $pass = '';

	public function getPass() {
		return $this->pass;
	}

	public function setPass($pass) {
		$this->pass = $pass;
	}

	protected $lieu = '';

	public function getLieu() {
		return $this->lieu;
	}

	public function setLieu($lieu) {
		$this->getHistory()->setLieu($lieu);
		$this->lieu = $lieu;
	}

	protected $points = 0;

	public function getPoints() {
		return $this->points;
	}

	public function setPoints($points) {
		$this->getHistory()->setPoints($points - $this->points);
		$this->points = $points;
	}

	public function addPoints($points) {
		if ($points <= 0) {
			throw RuleException("on ne peut pas enlever des points.");
		}
		$this->setPoints($this->getPoints() + $points);
	}

	protected $notoriete = 0;

	public function getCalculatedNotoriete() {
		return $this->calculated['notoriete'];
	}

	public function getNotoriete() {
		return $this->notoriete;
	}

	public function setNotoriete($notoriete) {
		if ($notoriete < 0) {
			$notoriete = 0;
		}
		$this->getHistory()->setNotoriete($notoriete - $this->notoriete);
		$this->notoriete = $notoriete;
	}

	public function addNotoriete($notoriete) {
		$this->setNotoriete($this->getNotoriete() + $notoriete);
	}

	protected $alcoolemie = 0;

	public function getCalculatedAlcoolemie() {
		return $this->calculated['alcoolemie'];
	}

	public function getAlcoolemie() {
		return $this->alcoolemie;
	}

	public function setAlcoolemie($alcoolemie) {
		if ($alcoolemie < 0) {
			$alcoolemie = 0;
		}
		$this->getHistory()->setAlcoolemie($alcoolemie - $this->alcoolemie);
		$this->alcoolemie = $alcoolemie;
		if (Pls::haveToGoToPls($this)) {
			Pls::startToPls($this);
		}
	}

	public function addAlcoolemie($alcoolemie) {
		$this->setAlcoolemie($this->getAlcoolemie() + $alcoolemie);
	}

	protected $alcoolemie_optimum = 0;

	public function getCalculatedAlcoolemie_optimum() {
		return $this->calculated['alcoolemie_optimum'];
	}

	public function getAlcoolemie_optimum() {
		return $this->alcoolemie_optimum;
	}

	public function setAlcoolemie_optimum($alcoolemie_optimum) {
		if ($alcoolemie_optimum < 1) {
			$alcoolemie_optimum = 1;
		} else if ($alcoolemie_optimum >= $this->alcoolemie_max) {
			$alcoolemie_optimum = $this->alcoolemie_max - 1;
		}
		$this->getHistory()->setAlcoolemie_optimum($alcoolemie_optimum - $this->alcoolemie_optimum);
		$this->alcoolemie_optimum = $alcoolemie_optimum;
	}

	public function addAlcoolemie_optimum($alcoolemie_optimum) {
		$this->setAlcoolemie_optimum($this->getAlcoolemie_optimum() + $alcoolemie_optimum);
	}

	protected $alcoolemie_max = 0;

	public function getCalculatedAlcoolemie_max() {
		return $this->calculated['alcoolemie_max'];
	}

	public function getAlcoolemie_max() {
		return $this->alcoolemie_max;
	}

	public function setAlcoolemie_max($alcoolemie_max) {
		if ($alcoolemie_max <= $this->alcoolemie_optimum + 1) {
			$alcoolemie_max = $this->alcoolemie_optimum - 1;
		}
		
		$this->getHistory()->setAlcoolemie_max($alcoolemie_max - $this->alcoolemie_max);
		$this->alcoolemie_max = $alcoolemie_max;
	}

	public function addAlcoolemie_max($alcoolemie_max) {
		$this->setAlcoolemie_max($this->getAlcoolemie_max() + $alcoolemie_max);
	}

	protected $fatigue = 0;

	public function getCalculatedFatigue() {
		return $this->calculated['fatigue'];
	}

	public function getFatigue() {
		return $this->fatigue;
	}

	public function setFatigue($fatigue) {
		if ($fatigue < 0) {
			$fatigue = 0;
		} else if (isset($this->calculated['fatigue_max']) && ($fatigue >= $this->calculated['fatigue_max'])) {
			$fatigue = $this->calculated['fatigue_max'];
		}
		$this->getHistory()->setFatigue($fatigue - $this->fatigue);
		$this->fatigue = $fatigue;
	}

	public function addFatigue($fatigue) {
		$this->setFatigue($this->getFatigue() + $fatigue);
	}

	protected $fatigue_max = 0;

	public function getCalculatedFatigue_max() {
		return $this->calculated['fatigue_max'];
	}

	public function getFatigue_max() {
		return $this->fatigue_max;
	}

	public function setFatigue_max($fatigue_max) {
		if ($fatigue_max <= 2) {
			$fatigue_max = 2;
		}
		$this->getHistory()->setFatigue_max($fatigue_max - $this->fatigue_max);
		$this->fatigue_max = $fatigue_max;
	}

	public function addFatigue_max($fatigue_max) {
		$this->setFatigue_max($this->getFatigue_max() + $fatigue_max);
	}

	protected $sex_appeal = 0;

	public function getCalculatedSex_appeal() {
		return $this->calculated['sex_appeal'];
	}

	public function getSex_appeal() {
		return $this->sex_appeal;
	}

	public function setSex_appeal($sex_appeal) {
		if ($sex_appeal <= 1) {
			$sex_appeal = 2;
		}
		$this->getHistory()->setSex_appeal($sex_appeal - $this->sex_appeal);
		$this->sex_appeal = $sex_appeal;
	}

	public function addSex_appeal($sex_appeal) {
		$this->setSex_appeal($this->getSex_appeal() + $sex_appeal);
	}

	protected $en_pls = 0;

	public function getEn_pls() {
		return $this->en_pls;
	}

	public function setEn_pls($en_pls) {
		if ($en_pls) {
			$this->en_pls = 1;
		} else {
			$this->en_pls = 0;
		}
		$this->getHistory()->setEn_pls($this->en_pls);
	}

	protected $debut_de_pls = 0;

	public function getDebut_de_pls() {
		return $this->debut_de_pls;
	}

	public function setDebut_de_pls($debut_de_pls) {
		$this->debut_de_pls = $debut_de_pls;
		$this->getHistory()->setDebut_de_pls($debut_de_pls);
	}

	/**
	 * si quelqu'un me demande quelle valeur est homme/femme, bien qu'il regarde dans son slip
	 *
	 * @var int
	 */
	protected $sex = 0;

	public function getSex() {
		return $this->sex;
	}

	public function setSex($sex) {
		$sex = (int) $sex;
		if (($sex === 0) || ($sex === 1)) {
			$this->sex = $sex;
		} else {
			throw new RuleException('sex doit etre 0 ou 1');
		}
	}

	protected $photo = '';

	public function getPhoto() {
		return $this->photo;
	}

	public function setPhoto($photo) {
		$this->photo = $photo;
	}

	/**
	 *
	 * @var int
	 */
	protected $pnj = 0;

	public function getPnj() {
		return $this->pnj;
	}

	public function setPnj($pnj) {
		$this->pnj = $pnj;
	}

	/**
	 *
	 * @var int
	 */
	protected $id_congress = NULL;

	public function getId_congress() {
		return $this->id_congress;
	}

	public function setId_congress($id_congress) {
		$this->id_congress = $id_congress;
		$this->getHistory()->setId_congress($this->id_congress);
		if (!$id_congress) {
			$this->congress = null;
		} else {
			if ($this->congress && ($this->congress->getId() == $id_congress)) {
				// no need to load congress
			} else {
				$this->congress = Congress::load($id_congress);
			}
		}
	}

	/**
	 *
	 * @var Congress
	 */
	protected $congress = null;

	/**
	 *
	 * @return Congress
	 */
	public function getCongress() {
		if ($this->congress === null) {
			if ($this->id_congress) {
				$this->congress = Congress::load($this->id_congress);
			}
		}
		return $this->congress;
	}

	public function setCongress(Congress $congress) {
		$this->congress = $congress;
		$this->id_congress = $congress->getId();
	}

	protected $remaining_time = 0;

	public function getRemaining_time() {
		return $this->remaining_time;
	}

	public function setRemaining_time($remaining_time) {
		if ($remaining_time < 0) {
			$remaining_time = 0;
		}
		$this->getHistory()->setRemaining_time($remaining_time - $this->remaining_time);
		$this->remaining_time = $remaining_time;
	}

	public function addRemaining_time($remaining_time) {
		$this->setRemaining_time($this->getRemaining_time() + $remaining_time);
	}

	protected $money = 0;

	public function getMoney() {
		return $this->money;
	}

	public function setMoney($money) {
		if ($money < 0) {
			$money = 0;
		}
		$this->getHistory()->setMoney($money - $this->money);
		$this->money = $money;
	}

	public function addMoney($money) {
		$this->setMoney($this->getMoney() + $money);
	}

	protected $inventory = array();

	/**
	 *
	 * @return array<Item>
	 */
	public function getInventory() {
		return $this->inventory;
	}

	public function setInventory(array $inventory) {
		$this->inventory = $inventory;
	}

	/**
	 *
	 * @var History
	 */
	protected $history = null;

	/**
	 *
	 * @return History
	 */
	public function getHistory() {
		return $this->history;
	}

	/**
	 *
	 * @param History $history        	
	 */
	public function setHistory(History $history) {
		$this->history = $history;
	}

	/**
	 *
	 * @return boolean
	 */
	public function isFatigued() {
		if ($this->getCalculatedFatigue() >= $this->getCalculatedFatigue_max()) {
			return true;
		}
		return false;
	}

	protected $calculated = array();

	public function __construct() {
		$this->history = new History();
	}

	public function defaultValues() {
		$this->lieu = 'camping';
		$this->points = 0;
		$this->notoriete = 0;
		$this->alcoolemie = 0;
		$this->alcoolemie_optimum = 7;
		$this->alcoolemie_max = 10;
		$this->fatigue = 0;
		$this->fatigue_max = 10;
		$this->sex_appeal = 5;
		$this->en_pls = 0;
		$this->debut_de_pls = 0;
		$this->sex = 0;
		$this->photo = 'images/tete_faluche_noir_rose.jpg';
		$this->pnj = 0;
		$this->id_congress = null;
		$this->remaining_time = 0;
		$this->money = 0;
	}

	/**
	 *
	 * @param int $id        	
	 * @return Player
	 */
	public static function load($id) {
		$sth = $GLOBALS['DB']->query('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id=' . intval($id));
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$obj = new static();
			if ($arr['pnj'] > 0) { // special case for player pnj
				$obj = new Bot();
			}
			$obj->populate($arr);
			return $obj;
		}
	}

	/**
	 *
	 * @param String $login        	
	 * @param String $pass        	
	 * @return Player
	 */
	public static function login($login, $pass) {
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE nom=:nom AND pass=:pass;');
		$sth->bindValue(':nom', $login, PDO::PARAM_STR);
		$sth->bindValue(':pass', $pass, PDO::PARAM_STR);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return null;
		}
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$obj = new self();
			if ($arr['pnj'] > 0) {
				$obj = new Bot();
			}
			$obj->populate($arr);
			return $obj;
		}
		return $sth->fetch();
	}

	/**
	 *
	 * @param String $login        	
	 * @return Player
	 */
	public static function loginExists($nom) {
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE nom=:nom');
		$sth->bindValue(':nom', $nom, PDO::PARAM_STR);
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return false;
		}
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$obj = new self();
			if ($arr['pnj'] > 0) {
				$obj = new Bot();
			}
			$obj->populate($arr);
			return $obj;
		}
		return $sth->fetch();
	}

	/**
	 *
	 * @param String $login        	
	 * @param String $pass        	
	 * @return Player
	 */
	public static function loadOrga($lieu, $id_congress) {
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id_congress=:id_congress AND lieu=:lieu AND pnj=2;');
		$sth->bindValue(':id_congress', $id_congress, PDO::PARAM_INT);
		$sth->bindValue(':lieu', $lieu, PDO::PARAM_STR);
		if ($sth->execute() === false) {
			// var_dump($sth->errorInfo());
			return null;
		}
		$arr = $sth->fetch();
		if (!$arr) {
			return $arr;
		} else {
			$obj = new self();
			if ($arr['pnj'] > 0) {
				$obj = new Bot();
			}
			$obj->populate($arr);
			return $obj;
		}
		return $sth->fetch();
	}

	public function loadInventory() {
		$this->calculated['notoriete'] = $this->notoriete;
		$this->calculated['alcoolemie'] = $this->alcoolemie;
		$this->calculated['alcoolemie_optimum'] = $this->alcoolemie_optimum;
		$this->calculated['alcoolemie_max'] = $this->alcoolemie_max;
		$this->calculated['fatigue'] = $this->fatigue;
		$this->calculated['fatigue_max'] = $this->fatigue_max;
		$this->calculated['sex_appeal'] = $this->sex_appeal;
		$this->inventory = array();
		
		$sth = $GLOBALS['DB']->query('SELECT O.* FROM item O INNER JOIN inventory I ON I.id_item = O.id WHERE I.id_player = ' . $this->id . ' ORDER BY O.id;');
		$sth->setFetchMode(PDO::FETCH_ASSOC);
		while ($sth && ($arr = $sth->fetch())) {
			$item = new Item();
			$item->populate($arr);
			$this->inventory[] = $item;
			if ($item->getPermanent()) {
				$this->calculated['notoriete'] += $item->getNotoriete();
				$this->calculated['alcoolemie'] += $item->getAlcoolemie();
				$this->calculated['alcoolemie_optimum'] += $item->getAlcoolemie_optimum();
				$this->calculated['alcoolemie_max'] += $item->getAlcoolemie_max();
				$this->calculated['fatigue'] += $item->getFatigue();
				$this->calculated['fatigue_max'] += $item->getFatigue_max();
				$this->calculated['sex_appeal'] += $item->getSex_appeal();
			}
		}
		return $this;
	}
}
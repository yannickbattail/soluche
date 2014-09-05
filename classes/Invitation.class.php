<?php
class Invitation extends AbstractDbObject {

	const TABLE_NAME = 'invitation';

	const TIME_LIMIT = 48; // heures
	public static $fieldList = array('id' => PDO::PARAM_INT, 'invitation_date' => PDO::PARAM_INT, 'host' => PDO::PARAM_INT, 'guest' => PDO::PARAM_INT, 'id_congress' => PDO::PARAM_INT, 'location' => PDO::PARAM_STR, 'id_game' => PDO::PARAM_INT, 'message' => PDO::PARAM_STR);

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	protected $invitation_date = 0;

	public function getInvitation_date() {
		return $this->invitation_date;
	}

	public function setInvitation_date($invitation_date) {
		$this->invitation_date = $invitation_date;
	}

	protected $host = 0;

	public function getHost() {
		return $this->host;
	}

	public function setHost($host) {
		$this->host = $host;
	}

	protected $guest = 0;

	public function getGuest() {
		return $this->guest;
	}

	public function setGuest($guest) {
		$this->guest = $guest;
	}

	protected $id_congress = 0;

	public function getId_congress() {
		return $this->id_congress;
	}

	public function setId_congress($id_congress) {
		$this->id_congress = $id_congress;
	}

	protected $location = '';

	public function getLocation() {
		return $this->location;
	}

	public function setLocation($location) {
		$this->location = $location;
	}

	protected $id_game = 0;

	public function getId_game() {
		return $this->id_game;
	}

	public function setId_game($id_game) {
		$this->id_game = $id_game;
	}

	/**
	 *
	 * @var String
	 */
	protected $message = '';

	public function getMessage() {
		return $this->message;
	}

	public function setMessage($message) {
		$this->message = $message;
	}

	public function defaultValues() {
		$this->invitation_date = time();
		$this->host = null;
		$this->guest = null;
		$this->id_congress = null;
		$this->location = null;
		$this->id_game = null;
		$this->message = '';
	}
}

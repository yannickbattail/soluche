<?php
class Notification extends AbstractDbObject {

	const TABLE_NAME = 'notification';

	protected static $fieldList = array('id' => PDO::PARAM_INT, 'is_new' => PDO::PARAM_INT, 'time_sent' => PDO::PARAM_INT, 'id_player' => PDO::PARAM_INT, 'message' => PDO::PARAM_STR);

	protected $id = 0;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	/**
	 *
	 * @var bool
	 */
	protected $is_new = 1;

	public function getIs_new() {
		return $this->is_new;
	}

	public function setIs_new($is_new) {
		$this->is_new = $is_new;
	}

	/**
	 *
	 * @var int
	 */
	protected $time_sent = 0;

	public function getTime_sent() {
		return $this->time_sent;
	}

	public function setTime_sent($time_sent) {
		$this->time_sent = $time_sent;
	}

	/**
	 *
	 * @var int
	 */
	protected $id_player = 0;

	public function getId_player() {
		return $this->id_player;
	}

	public function setId_player($id_player) {
		$this->id_player = $id_player;
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
		$this->is_new = 1;
		$this->time_sent = time();
		$this->sender = $_SESSION['user'];
		$this->recipient = null;
		$this->message = '';
	}

	public static function notifyPlayer(Player $dest, $message) {
		$notification = new Notification();
		$notification->defaultValues();
		$notification->setIs_new(1);
		$notification->setId_player($dest->getId());
		$notification->setMessage($message);
		$notification->save();
	}

	public static function notify($message) {
		Self::notifyPlayer($_SESSION['user'], $message);
	}
}
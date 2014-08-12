<?php
class Chat extends AbstractDbObject {

	const TABLE_NAME = 'chat';

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
	protected $sender = 0;

	public function getSender() {
		return $this->sender;
	}

	public function setSender($sender) {
		$this->sender = $sender;
	}

	protected $recipient = NULL;

	public function getRecipient() {
		return $this->recipient;
	}

	public function setRecipient($recipient) {
		$this->recipient = $recipient;
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

	/**
	 *
	 * @param String $id        	
	 * @return History
	 */
	public static function load($id) {
		$sth = $GLOBALS['DB']->prepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE id = :id;');
		$sth->bindValue(':id', $id, PDO::PARAM_STR);
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
			$obj->populate($arr);
			return $obj;
		}
	}

	public function save() {
		if (!$this->id) {
			$this->create();
		} else {
			$this->update();
		}
	}

	public function create() {
		$sth = $GLOBALS['DB']->prepare('INSERT INTO ' . self::TABLE_NAME . ' ' . '(is_new, time_sent, sender, recipient, message)' . ' VALUES (:is_new, :time_sent, :sender, :recipient, :message);');
		// $sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':is_new', $this->is_new, PDO::PARAM_INT);
		$sth->bindValue(':time_sent', $this->time_sent, PDO::PARAM_INT);
		$sth->bindValue(':sender', $this->sender, PDO::PARAM_INT);
		$sth->bindValue(':recipient', $this->recipient, PDO::PARAM_INT);
		$sth->bindValue(':message', $this->message, PDO::PARAM_STR);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
		$this->setId($GLOBALS['DB']->lastInsertId());
	}

	public function defaultValues() {
		$this->is_new = 1;
		$this->time_sent = time();
		$this->sender = $_SESSION['user'];
		$this->recipient = null;
		$this->message = '';
	}

	public function update() {
		$sth = $GLOBALS['DB']->prepare('UPDATE ' . self::TABLE_NAME . ' SET is_new=:is_new, time_sent=:time_sent, sender=:sender, recipient=:recipient, message=:message WHERE id=:id;');
		$sth->bindValue(':id', $this->id, PDO::PARAM_INT);
		$sth->bindValue(':is_new', $this->is_new, PDO::PARAM_INT);
		$sth->bindValue(':time_sent', $this->time_sent, PDO::PARAM_INT);
		$sth->bindValue(':sender', $this->sender, PDO::PARAM_INT);
		$sth->bindValue(':recipient', $this->recipient, PDO::PARAM_INT);
		$sth->bindValue(':message', $this->message, PDO::PARAM_STR);
		if ($sth->execute() === false) {
			throw new Exception(print_r($sth->errorInfo(), true));
		}
	}

	public function delete() {
		$GLOBALS['DB']->query('DELETE FROM ' . self::TABLE_NAME . ' WHERE id=' . $this->id . ';')->fetch(PDO::FETCH_ASSOC);
	}

	public static function sendMessage(Player $dest, $message) {
		$chat = new Chat();
		$chat->defaultValues();
		$chat->is_new = 1;
		$chat->setSender($_SESSION['user']->getId());
		$chat->setRecipient($dest->getId());
		$chat->setMessage($message);
		$chat->save();
	}

	public static function sendGlobalMessage($message) {
		$chat = new Chat();
		$chat->defaultValues();
		$chat->is_new = 1;
		$chat->setSender($_SESSION['user']->getId());
		$chat->setRecipient(null);
		$chat->setMessage($message);
		$chat->save();
	}
}
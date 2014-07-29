<?php
class ActionResult {

	const SUCCESS = 1;

	const FAIL = 0;

	const NOTHING = null;

	const IMPOSSIBLE = -1;

	public function __construct($success = null, $message = null) {
		$this->setSuccess($success);
		if ($message !== null) {
			$this->setMessage($message);
		}
	}

	/**
	 *
	 * @var int
	 */
	protected $success = self::NOTHING;

	public function getSuccess() {
		return $this->success;
	}

	public function setSuccess($success) {
		if (($success === self::SUCCESS) || ($success === self::FAIL) || ($success === self::IMPOSSIBLE) || ($success === self::NOTHING)) {
			$this->success = $success;
		} else {
			throw new Exception('$success must be one of self::SUCCESS FAIL IMPOSSIBLE or NOTHING');
		}
	}

	/**
	 *
	 * @var int
	 */
	protected $message = '';

	public function getMessage() {
		return $this->message;
	}

	public function setMessage($message) {
		$this->message = $message;
	}
}

<?php
class AbortSale extends AbstractAction {

	const PARAM_NAME = 'id_transaction';

	/**
	 *
	 * @var Transaction
	 */
	protected $transaction;
	
	/**
	 *
	 * @param Player $player        	
	 */
	public function __construct(Player $player) {
		parent::__construct($player);
		// configuration
		$this->paramName = self::PARAM_NAME;
		$this->actionRight = null;
		$this->linkText = 'Annuler la vente';
	}

	/**
	 *
	 * @see ActionInterface::setParams()
	 * @param array $params        	
	 */
	public function setParams(array $params) {
		if (isset($params['id_transaction']) && $params['id_transaction']) {
			$this->transaction = Transaction::load($params['id_transaction']);
		}
		if (!$this->transaction) {
			throw new Exception('no such item in transaction.');
		}
		$this->paramPrimaryKey = $this->transaction->getId();
		return $this;
	}

	/**
	 *
	 * @see ActionInterface::execute()
	 * @return ActionResult
	 */
	public function execute() {
		$res = new ActionResult();
		$this->transaction->delete();
		$res->setSuccess(ActionResult::NOTHING);
		$res->setMessage('Vente annulée.');
		return $res;
	}

	/**
	 *
	 * @return string
	 */
	public function statsDisplay($page = null) {
		return '';
	}
}

<?php
class Rule {

	/**
	 *
	 * @var Player
	 */
	protected $player;

	/**
	 *
	 * @var Player
	 */
	protected $opponent;

	/**
	 *
	 * @var Item
	 */
	protected $item;

	/**
	 *
	 * @var array
	 */
	protected $calcul = array();

	/**
	 *
	 * @param string $calculName        	
	 * @param int $calculValue        	
	 */
	public function addCalcul($calculName, $calculValue) {
		$this->calcul[$calculName] = $calculValue;
	}

	public function applyRule(array $rule) {
		foreach ($rule as $key => $value) {
			$this->applyLine($key, $value);
		}
	}
	
	protected function applyLine($key, $value) {
		$curPlayer = $this->player;
		if (strpos('opponent_', $key) === 0) {
			$curPlayer = $this->opponent;
			$key = str_replace('opponent_', '', $key);
		}
		if ($key == 'addItem'){
			$itm = $this->lineItem($value);
			Item::associate($curPlayer->getId(), $itm->getId());
		} else if ($key == 'delItem'){
			Item::desassociate($curPlayer->getId(), $itm->getId());
		} else {
			$method = 'add'.ucfirst($key);
			$curPlayer->$method($this->lineValue($key, $value));
		}
	}
	
	protected function lineValue($key, $value) {
		if (strpos('calcul', $value) === 0) {
			$value = str_replace('opponent_', '', $value);
			return $this->calcul[$value];
		} else if ($value == 'item') {
			$method = 'get'.ucfirst($key);
			return $this->item->$method();
		} else {
			return $value;
		}
	}
	
	/**
	 * 
	 * @param string $value
	 * @return Item
	 */
	protected function lineItem($value) {
		if ($value == 'item') {
			return $this->item;
		} else {
			$item = Item::loadByName($value);
			if (!$item) {
				throw new RuleException('no such Item '.$value.' in rule.');
			}
			return $item;
		}
	}
}

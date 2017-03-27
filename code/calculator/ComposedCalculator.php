<?php

namespace EventRegistration\Calculator;

/**
 * A calculator composed from other calculators.
 */
class ComposedCalculator extends AbstractCalculator {

	protected $calculators = array();

	function __construct(array $calculators) {
		$this->calculators = $calculators;
	}

	public function calculate($value) {
		$total = 0;
		foreach($this->calculators as $calculator) {
			$total += $calculator->calculate($value);
		}
		return $value + $total;
	}

}

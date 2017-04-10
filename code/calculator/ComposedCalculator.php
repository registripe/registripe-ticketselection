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

	/**
	 * Pass a single value through multiple calculators to get a total.
	 *
	 * @param number $value
	 * @return void
	 */
	public function calculate($value) {
		$total = 0;
		foreach($this->calculators as $calculator) {
			$total = $calculator->calculate($total);
		}
		return $value + $total;
	}

}

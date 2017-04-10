<?php

namespace EventRegistration\Calculator;

/**
 * Peforms calculations and totals selections
 */
class SelectionsCalculator extends AbstractCalculator{

	protected $selections;

	public function __construct(\DataList $selections) {
		$this->selections = $selections;
	}

	/**
	 * Calculate cost of each selection, and add up.
	 *
	 * @param number $value
	 * @return number
	 */
	public function calculate($value) {
		$total = 0;
		// each attendee
		foreach($this->selections as $selection) {
			$calculators = $this->calculatorsFor($selection);
			$calculator = new ComposedCalculator($calculators);
			$total += $calculator->calculate(0);
		}
		return $value + $total;
	}

}

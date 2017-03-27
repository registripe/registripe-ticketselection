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

	public function calculate($value) {
		$total = 0;
		// each attendee
		foreach($this->selections as $selection) {
			$calculator = $this->calculatorsFor($selection);
			$cost = $calculator->calculate(0);
			// add selection costs to total
			$total += $cost;
		}
		return $value + $total;
	}

}

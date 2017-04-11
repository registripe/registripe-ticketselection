<?php

namespace EventRegistration\Calculator;

class RegistrationCalculator extends AbstractCalculator {

	public function __construct(\EventRegistration $registration) {
		$this->calculators = array(
			new SelectionsCalculator($registration->TicketSelections())
		);
	}

	public function calculate($value = 0) {
		$composed = new ComposedCalculator($this->calculators);
		return $composed->calculate($value);
	}

}

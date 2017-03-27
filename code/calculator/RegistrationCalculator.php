<?php

namespace EventRegistration\Calculator;

class RegistrationCalculator extends AbstractCalculator {

	public function __construct(\EventRegistration $registration) {
		$this->calculators = array(
			new SelectionsCalculator($registration->TicketSelections()),
			// new RegistrationCalculator($registration)
		);
	}

	public function calculate($value) {
		$composed = new ComposedCalculator($this->calculators);
		return $composed->calculate($value);
	}

}

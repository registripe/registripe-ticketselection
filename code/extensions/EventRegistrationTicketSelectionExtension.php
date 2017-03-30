<?php

class EventRegistrationTicketSelectionExtension extends DataExtension {

	private static $has_many = array(
		'TicketSelections' => 'TicketSelection'
	);

	private static $casting = array(
		"Cost" => "Currency"
	);

	public function getCost() {
		return $this->calculateCost();
	}

	public function calculateCost() {
		$calculator = new \EventRegistration\Calculator\RegistrationCalculator($this->owner);
		return $calculator->calculate(0);
	}

}

<?php

namespace EventRegistration\Calculator;

class SelectionCostCalculator extends SelectionCalculator{

	public function calculate($value) {
		$cost = 0;
		$ticket = $this->selection->Ticket();
		if($ticket && $ticket->hasPrice()){
			$cost += $ticket->Price;
		}
		if($this->persist) {
			$this->selection->Cost = $cost;
			$this->selection->write();
			if ($attendee = $this->selection->Attendee()) {
				$attendee->Cost = $cost;
				$attendee->write();
			}
		}
		return $value + $cost;
	}

}

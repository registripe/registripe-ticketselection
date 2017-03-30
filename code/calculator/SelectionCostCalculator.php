<?php

namespace EventRegistration\Calculator;

class SelectionCostCalculator extends AbstractCalculator{

	protected $selection;

	protected $persist = true;

	public function __construct(\TicketSelection $selection) {
		$this->selection = $selection;
	}

	public function setPersist($persist) {
		$this->persist = $persist;
	}

	public function calculate($value) {
		$cost = 0;
		$ticket = $this->selection->Ticket();
		if($ticket && $ticket->hasPrice()){
			$cost += $ticket->Price;
		}
		if($this->persist) {
			$this->selection->Cost = $cost;
			$this->selection->write();
		}
		return $value + $cost;
	}

}

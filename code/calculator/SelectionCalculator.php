<?php

namespace EventRegistration\Calculator;

abstract class SelectionCalculator extends AbstractCalculator {

	protected $selection;

	protected $persist = true;

	public function __construct(\TicketSelection $selection) {
		$this->selection = $selection;
	}	

}
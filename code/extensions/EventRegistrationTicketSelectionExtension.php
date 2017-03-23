<?php

class EventRegistrationTicketSelectionExtension extends DataExtension {

	private static $has_many = array(
		'TicketSelections' => 'TicketSelection'
	);

	/**
	 * Creates a ticket selection data object.
	 */
	public function createSelection($ticket) {
		$selection = TicketSelection::create();
		$selection->RegistrationID = $this->owner->ID;
		$selection->TicketID = $ticket->ID;
		$selection->write();
		$this->owner->TicketSelections()->add($selection);
		return $selection;
	}

}

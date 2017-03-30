<?php

class EventTicketTicketSelectionExtension extends DataExtension {

	private static $has_many = array(
		'TicketSelections' => 'TicketSelection'
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->removeByName("TicketSelections");
	}

	/**
	 * Creates a ticket selection data object for this ticket.
	 */
	public function createSelection() {
		$class = $this->owner->stat('selection_type');
		$selection = $class::create();
		$selection->TicketID = $this->owner->ID;
		return $selection;
	}

}
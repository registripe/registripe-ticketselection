<?php

class EventTicketTicketSelectionExtension extends DataExtension {

	private static $has_many = array(
		'TicketSelections' => 'TicketSelection'
	);

}
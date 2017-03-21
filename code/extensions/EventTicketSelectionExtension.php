<?php

class EventTicketSelectionExtension extends DataExtension {

	private static $has_many = array(
		'TicketSelections' => 'TicketSelection'
	);

}
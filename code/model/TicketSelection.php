<?php

class TicketSelection extends DataObject {

	private static $db = array(
		"Cost" => "Currency"
	);

	private static $has_one = array(
		"Registration" => "EventRegistration",
		"Ticket" => "EventTicket"
	);

}

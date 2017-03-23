<?php

class TicketSelection extends DataObject {

	private static $has_one = array(
		"Registration" => "EventRegistration",
		"Ticket" => "EventTicket",
		"Attendee" => "EventAttendee"
	);

}

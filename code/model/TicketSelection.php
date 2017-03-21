<?php

class TicketSelection extends DataObject {

	private static $has_one = array(
		"Attendee" => "EventAttendee",
		"Registration" => "EventRegistration"
	);

}

<?php

class EventAttendeeControllerTicketSelectionExtension extends Extension {

	function onBeforeDelete($attendee, $registration) {
		$selection = $registration->TicketSelections()
			->innerJoin('AttendeeTicketSelection', "\"AttendeeTicketSelection\".\"ID\" = \"TicketSelection\".\"ID\"")
			->filter("AttendeeID", $attendee->ID)->first();
		if ($selection) {
			$selection->delete();
			$selection->destroy();
		}
	}

}

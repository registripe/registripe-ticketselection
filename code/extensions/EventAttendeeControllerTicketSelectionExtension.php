<?php

class EventAttendeeControllerTicketSelectionExtension extends Extension {

	function onBeforeDelete($attendee, $registration) {
		$selection = $registration->TicketSelections()->filter("AttendeeID", $attendee->ID)->first();
		if ($selection) {
			$selection->delete();
			$selection->destroy();
		}
	}

}

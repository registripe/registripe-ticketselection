<?php

class AttendeeTicketSelection extends TicketSelection {

	private static $has_one = array(
		"Attendee" => "EventAttendee"
	);

	/**
	 * If ticket selection is deleted, and registration hasn't been submitted,
	 * then also delete attendee.
	 */
	protected function onBeforeDelete() {
		$attendee = $this->Attendee();
		$registration = $this->Registration();
		if($attendee->exists() && !$registration->isSubmitted()){
			$attendee->delete();
			$attendee->destroy();
		}
		parent::onBeforeDelete();
	}

}
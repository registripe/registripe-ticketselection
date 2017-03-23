<?php

class TicketSelectionController extends Page_Controller {

	protected $registration;
	protected $selection;

	public static $allowed_actions = array(
		'index',
		'attendee',
		'AttendeeForm'
	);

	public function __construct($record, EventRegistration $registration, TicketSelection $selection){
		parent::__construct($record);
		$this->registration = $registration;
		$this->selection = $selection;

		$this->pager = ListPager::create($this->registration->TicketSelections(), $selection);
	}

	public function index($request) {
		return $this->attendee($request);
	}

	public function attendee() {
		$form = $this->AttendeeForm();
		$attendee = $this->selection->Attendee();

		// TODO: don't overwrite session-loaded data

		if ($attendee) {
			$form->loadDataFrom($attendee);
		}
		$form->loadDataFrom($this->selection);
		return array(
			"Form" => $form
		);
	}

	public function AttendeeForm() {
		$form = new EventAttendeeForm($this, "AttendeeForm");
		$form->Actions()->push(FormAction::create("save", "Next"));
		$form->Fields()->unshift(
			LiteralField::create("pager", $this->pager->renderWith("TicketPageIndicator"))
		);
		// $form->addCancelLink($this->BackURL);
		$this->extend("updateAttendeeForm", $form, $this->registration);
		return $form;
	}

	public function save($data, $form) {
		$attendee = $this->selection->Attendee();
		if (!$attendee) {
			$attendee = $this->createAttendee();
		}

		$form->saveInto($attendee);
		$attendee->write();

		$this->selection->AttendeeID = $attendee->ID;
		$this->selection->write();

		$this->registration->Attendees()->add($attendee);
		
		return $this->redirect($this->nextLink());
	}

	public function nextLink() {
		$next = $this->pager->next();
		if (!$next) {
			return $this->NextURL;
		}
		return $this->Parent()->Link() . "register/selection/" . $next->ID;
	}

	/**
	 * Helper for creating new attendee on registration.
	 */
	protected function createAttendee() {
		$attendee = EventAttendee::create();
		$attendee->RegistrationID = $this->registration->ID;
		$attendee->SelectionID = $this->selection->ID;
		return $attendee;
	}

}
<?php

class TicketSelectionController extends Page_Controller {

	protected $registration;
	protected $selection;

	public static $allowed_actions = array(
		'index',
		'attendee',
		'AttendeeForm',
		'delete'
	);

	public function __construct($record, EventRegistration $registration, TicketSelection $selection){
		parent::__construct($record);
		$this->registration = $registration;
		$this->selection = $selection;
	}

	/**
	 * Choose appropriate action, based on selection's action
	 */
	public function index($request) {
		$action = $this->selection->stat("select_controller_action");
		return $this->$action($request);
	}

	public function attendee() {
		// TODO: attach entire attendee controller instead.
		$form = $this->AttendeeForm();
		$attendee = $this->selection->Attendee();
		// load form data from attendee, if not already loaded from session
		if (!$form->hasSessionData()) {
			if ($attendee->isInDB()) {
				$form->loadDataFrom($attendee);
			} else {
				$this->populatePreviousData($form);
			}
		}
		// we need TicketID from selection, as it is a required field
		$form->loadDataFrom($this->selection);
		return array(
			"Form" => $form
		);
	}

	// poplate given form with specfific data from last attednee
	protected function populatePreviousData(Form $form) {
		$prepops = EventAttendee::config()->prepopulated_fields;
		if (!$prepops) {
			return;
		}
		$latestattendee = $this->registration->Attendees()
			->sort("LastEdited", "DESC")->first();
		if($latestattendee){
			$form->loadDataFrom($latestattendee, Form::MERGE_DEFAULT, $prepops);	
		}
	}

	public function AttendeeForm() {
		$form = new EventAttendeeForm($this, "AttendeeForm");
		$form->Actions()->push(FormAction::create("save", "Next"));
		$form->addCancelLink($this->BackURL, "Back");
		$this->extend("updateAttendeeForm", $form, $this->registration, $this->selection);
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
		return $this->redirect($this->NextURL);
	}

	/**
	 * Delete this selection and return to previous page.
	 *
	 * @param HTTPRequest $request
	 * @return HTTPResponse
	 */
	public function delete($request) {
		$this->extend("onBeforeDelete", $this->selection, $this->registration);
		$this->selection->delete();
		$this->selection->destroy();
		return $this->redirectBack();
	}

	/**
	 * Helper for creating new attendee on registration.
	 * 
	 * @return EventAttendee
	 */
	protected function createAttendee() {
		$attendee = EventAttendee::create();
		$attendee->RegistrationID = $this->registration->ID;
		$attendee->SelectionID = $this->selection->ID;
		return $attendee;
	}

}
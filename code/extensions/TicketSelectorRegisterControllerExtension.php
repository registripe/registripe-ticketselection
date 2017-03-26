<?php

class TicketSelectorRegisterControllerExtension extends Extension {

	private static $allowed_actions = array(
		'choose',
		'selectTicket',
		'selection'
	);

	private static $url_handlers = array(
		'selection/$ID' => 'selection',
	);

	public function choose() {
		return array(
			"Form" => $this->owner->renderWith("TicketCountSelections")
		);
	}

	public function selectTicket($request) {
		// TODO: CSRF security
		$reg = $this->owner->getCurrentRegistration();
		$event = $reg->Event();
		$tickets = $event->getAvailableTickets();
		$selections = $reg->TicketSelections();

		$ticket = $tickets->byID($request->param('ID'));
		if (!$ticket || !$ticket->exists()) {
			return $this->owner->redirectBack();
		}		
		if($request->postVar("action_add") !== null) {
			$selection = $ticket->createSelection($ticket)->write();
			$selections->add($selection);
		}
		if($request->postVar("action_subtract") !== null) {
			$selections->sort("ID", "DESC")
				->find("TicketID", $ticket->ID)->delete();
		}
		return $this->owner->redirectBack();
	}

	public function SelectedCount($ticketID) {
		$reg = $this->owner->getCurrentRegistration();
		if (!$reg) {
			return 0;
		}
		return $reg->TicketSelections()
			->filter("TicketID", $ticketID)
			->count();
	}

	public function FirstSelectionLink() {
		$reg = $this->owner->getCurrentRegistration();
		$selection = $reg->TicketSelections()->first();
		if (!$selection) {
			return null;
		}
		return $this->owner->Link('selection/'.$selection->ID);
	}

	public function selection($request) {
		$registration = $this->owner->getCurrentRegistration();
		$id = $request->param('ID');
		if(!$registration || !is_numeric($id)) {
			return $this->owner->index($request);
		}
		$selection = $registration->TicketSelections()->byID($id);
		if(!$selection) {
			return $this->owner->index($request);
		}

		// show edit or add form, based on whether selection has an attendee
		$nexturl = $this->owner->Link('review');
		$backurl = $this->owner->canReview() ?	$nexturl : $this->owner->Link();

		$record = new Page(array(
			'ID' => -1,
			'Title' => $selection->Ticket()->Title,
			'ParentID' => $this->owner->ID,
			'URLSegment' => 'register/selection/' . $selection->ID,
			'BackURL' => $backurl,
			'NextURL' => $nexturl
		));
		$controller = new TicketSelectionController($record, $registration, $selection);
		// $this->owner->extend("updateTicketSelectionController", $controller, $record, $registration);

		return $controller;
	}

}

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

	public function getShowPrices() {
		return true;
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
			$selection = $ticket->createSelection($ticket);
			$id = $selection->write();
			$selections->add($selection);
			if ($selection->stat("redirect_on_add")) {
				$link = $this->owner->Link($this->selectionSegment($selection));
				return $this->owner->redirect($link);
			}
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
		return $this->owner->Link($this->selectionSegment($selection));
	}

	public function selection($request) {
		$registration = $this->owner->getCurrentRegistration();
		$id = $request->param('ID');
		if(!$registration || !is_numeric($id)) {
			return $this->owner->index($request);
		}
		$selections = $registration->TicketSelections();
		$selection = $selections->byID($id);
		if(!$selection) {
			return $this->owner->index($request);
		}

		$pager = ListPager::create($selections, $selection);
		$backurl = ($prev = $pager->prev()) ? $this->owner->Link($this->selectionSegment($prev)) : $this->owner->Link();
		$nexturl = ($next = $pager->next()) ? $this->owner->Link($this->selectionSegment($next)) : $this->owner->Link('review');
		$record = new Page(array(
			'ID' => -1,
			'Title' => $selection->Ticket()->Title,
			'ParentID' => $this->owner->ID,
			'URLSegment' => Controller::join_links('register', 'selection', $selection->ID),
			'BackURL' => $backurl,
			'NextURL' => $nexturl,
			'Content' => $pager->renderWith("TicketPageIndicator")
		));

		$controller = new TicketSelectionController($record, $registration, $selection);
		$this->owner->extend("updateTicketSelectionController", $controller, $record, $registration);
		return $controller;
	}

	protected function selectionSegment($selection) {
		return Controller::join_links('selection', $selection->ID);
	}

}

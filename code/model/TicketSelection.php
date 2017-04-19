<?php

class TicketSelection extends DataObject {

	private static $db = array(
		"Cost" => "Currency"
	);

	private static $has_one = array(
		"Registration" => "EventRegistration",
		"Ticket" => "EventTicket"
	);

	private static $row_template = "TicketSelection_row";

	public function RenderRow($baselink = "") {
		return $this->renderWith($this->stat("row_template"), array(
			"BaseLink" => $baselink
		));
	}

}

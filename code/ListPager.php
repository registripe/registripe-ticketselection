<?php

class ListPager extends ViewableData {

	public function __construct(DataList $list, DataObject $current) {
		$this->list = $list;
		$this->current = $current;
	}

	public function previous() {
		
	}

	public function next() {
		return $this->getNextListItem($this->list, $this->current);
	}

	/**
	 * Current position within selections
	 */
	public function Pos() {
		return $this->listPos($this->list, $this->current) + 1;
	}

	public function Length() {
		return $this->list->count();
	}

	/**
	 * Get the attendee after current one being saved
	 */
	private function getNextListItem(DataList $list, DataObject $item) {
		$pos = $this->listPos($list, $item);
		$it = $list->getIterator();
		$it->seek($pos);
		$it->next();
		return $it->current();
	}

	private function listPos(DataList $list, DataObject $item) {
		return array_search($item->ID, $list->column());
	}

}

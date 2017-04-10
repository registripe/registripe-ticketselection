<?php

namespace EventRegistration\Calculator;

abstract class AbstractCalculator{

	/**
	 * Float in - modifications - float out.
	 * @return double
	 */
	abstract function calculate($value);

	/**
	 * Get components for a given dataobject.
	 * @return array
	 */
	protected function calculatorsFor(\DataObject $obj) {
		// allow overriding default calculators array
		$names = $obj->stat("calculators");
		$names = $names ? $names : $obj->stat("default_calculators");
		return $this->initCalculators($names, $obj);
	}

	/**
	 * Creates instances of components from component name strings
	 * @param array names
	 * @return array
	 */
	protected function initCalculators(array $names, \DataObject $dataobject) {
		$injector = \Injector::inst();
		$calculators = array();
		foreach($names as $name) {
			$calculator = $injector->create($this->nameToClass($name), $dataobject);
			$calculators[$name] = $calculator;
		}
		return $calculators;
	}
	
	/**
	 * Get calculator full class name from short name
	 */
	protected function nameToClass($name) {
		return sprintf("EventRegistration\Calculator\%sCalculator", $name);
	}

}

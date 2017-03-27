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
	 */
	protected function calculatorsFor(\DataObject $dataobject) {
		$names = $dataobject->stat("calculators");
		return $this->initCalculators($names, $dataobject);
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
			array_push($calculators, $calculator);
		}
		return new ComposedCalculator($calculators);
	}
	
	/**
	 * Get calculator full class name from short name
	 */
	protected function nameToClass($name) {
		return sprintf("EventRegistration\Calculator\%sCalculator", $name);
	}

}

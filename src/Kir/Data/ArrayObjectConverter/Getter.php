<?php
namespace Kir\Data\ArrayObjectConverter;

class Getter {
	/**
	 * @var object
	 */
	private $obj=null;

	/**
	 * @var Filters
	 */
	private $filters=null;

	/**
	 * @param object $obj
	 * @param Filters $filters
	 */
	public function __construct($obj, Filters $filters) {
		$this->obj = $obj;
		$this->filters = $filters;
	}

	/**
	 * @return object
	 */
	public function get() {
		$result = array();
		$factory = new PropertyFactory($this->obj);
		$properties = $factory->getAll();
		foreach($properties as $property) {
			$result = $this->handleProperty($property, $result);
		}
		return $result;
	}

	/**
	 * @param Property $property
	 * @param array $result
	 * @return array
	 */
	private function handleProperty(Property $property, array $result) {
		if($property->annotations()->has('aoc-data-key')) {
			$annotation = $property->annotations()->getFirst('aoc-data-key');
			$annotationValue = $annotation->getValue();
			$value = $property->getValue();
			$value = $this->applyFilters($property, $value);
			$result[$annotationValue] = $value;
		}
		return $result;
	}

	/**
	 * @param Property $property
	 * @param mixed $value
	 * @throws Exception
	 * @return mixed
	 */
	private function applyFilters(Property $property, $value) {
		$getterFilters = $property->annotations()->get('aoc-getter-filter');
		foreach($getterFilters as $getterFilter) {
			$filterName = $getterFilter->getValue();
			if(!$this->filters->has($filterName)) {
				throw new Exception("Getter-filter missing: {$filterName}");
			}
			$value = $this->filters->filter($filterName, $value, $getterFilter->options());
		}
		return $value;
	}
}
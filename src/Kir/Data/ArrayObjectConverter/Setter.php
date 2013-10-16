<?php
namespace Kir\Data\ArrayObjectConverter;

class Setter {
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
	 * @param array $data
	 * @return $this
	 */
	public function set(array $data) {
		$factory = new PropertyFactory($this->obj);
		$properties = $factory->getAll();
		foreach($data as $name => $value) {
			$this->findProperty($properties, $name, $value);
		}
		return $this;
	}

	/**
	 * @param Property[] $properties
	 * @param string $name
	 * @param string $value
	 */
	private function findProperty(array $properties, $name, $value) {
		foreach($properties as $property) {
			$this->handleProperty($property, $name, $value);
		}
	}

	/**
	 * @param Property $property
	 * @param string $name
	 * @param string $value
	 */
	private function handleProperty(Property $property, $name, $value) {
		if($property->annotations()->has('aoc-data-key')) {
			$dataKey = $property->annotations()->getFirst('aoc-data-key')->getValue();
			if($dataKey == $name) {
				$value = $this->applyFilters($property, $value);
				$property->setValue($value);
			}
			return;
		}
	}

	/**
	 * @param Property $property
	 * @param mixed $value
	 * @throws Exception
	 * @return mixed
	 */
	private function applyFilters(Property $property, $value) {
		$setterFilters = $property->annotations()->get('aoc-setter-filter');
		foreach($setterFilters as $setterFilter) {
			$filterName = $setterFilter->getValue();
			if(!$this->filters->has($filterName)) {
				throw new Exception("Setter-filter missing: {$filterName}");
			}
			$value = $this->filters->filter($filterName, $value, $setterFilter->options());
		}
		return $value;
	}
}
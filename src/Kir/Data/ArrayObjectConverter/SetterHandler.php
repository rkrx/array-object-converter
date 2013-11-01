<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;

class SetterHandler {
	/**
	 * @var object
	 */
	private $obj=null;

	/**
	 * @var Filters
	 */
	private $filters=null;

	/**
	 * @var DefinitionProvider
	 */
	private $definitionProvider=null;

	/**
	 * @var PropertyReader
	 */
	private $writer=null;

	/**
	 * @param object $obj
	 * @param DefinitionProvider $definitionProvider
	 * @param Filters $filters
	 */
	public function __construct($obj, DefinitionProvider $definitionProvider, Filters $filters) {
		$this->obj = $obj;
		$this->filters = $filters;
		$this->definitionProvider = $definitionProvider;
		$this->writer = new PropertyWriter();
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function set(array $data) {
		foreach($data as $key => $value) {
			$this->findProperty($key, $value);
		}
		return $this;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	private function findProperty($key, $value) {
		$properties = $this->definitionProvider->getProperties();
		foreach($properties as $property) {
			// Suche performanter gestalten
			$this->handleProperty($property, $key, $value);
		}
	}

	/**
	 * @param Property $property
	 * @param $name
	 * @param $value
	 */
	private function handleProperty(Property $property, $name, $value) {
		if($property->annotations()->has('array-key')) {
			$dataKey = $property->annotations()->getFirst('array-key')->getValue();
			if($dataKey == $name) {
				$value = $this->applyFilters($property, $value);
				$this->writer->setValue($this->obj, $property, $value);
			}
		}
	}

	/**
	 * @param DefinitionProvider\Property $property
	 * @param mixed $value
	 * @throws Exception
	 * @return mixed
	 */
	private function applyFilters(Property $property, $value) {
		if(!$property->annotations()->has('setter-filter')) {
			return $value;
		}
		$setterFilters = $property->annotations()->getAll('setter-filter');
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
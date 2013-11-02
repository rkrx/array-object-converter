<?php
namespace Kir\Data\ArrayObjectConverter\Handlers\BuildIn;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Filtering\Filters;
use Kir\Data\ArrayObjectConverter\Handlers\SetterHandler;
use Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleSetterHandler\PropertyWriter;
use Kir\Data\ArrayObjectConverter\Reflection\ReflectionObject;

class SimpleSetterHandler implements SetterHandler {
	/**
	 * @var ReflectionObject
	 */
	private $object = null;

	/**
	 * @var \Kir\Data\ArrayObjectConverter\Filtering\Filters
	 */
	private $filters = null;

	/**
	 * @var DefinitionProvider
	 */
	private $definitionProvider = null;

	/**
	 * @var \Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleGetterHandler\PropertyReader
	 */
	private $writer = null;

	/**
	 * @param object $object
	 * @param DefinitionProvider $definitionProvider
	 * @param \Kir\Data\ArrayObjectConverter\Filtering\Filters $filters
	 */
	public function __construct($object, DefinitionProvider $definitionProvider, Filters $filters) {
		$this->object = new ReflectionObject($object);
		$this->filters = $filters;
		$this->definitionProvider = $definitionProvider;
		$this->writer = new PropertyWriter();
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setArray(array $data) {
		foreach ($data as $key => $value) {
			$this->findProperty($key, $value);
		}
		return $this;
	}

	/**
	 * @return \Kir\Data\ArrayObjectConverter\Filtering\Filters
	 */
	public function filters() {
		return $this->filters;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	private function findProperty($key, $value) {
		$properties = $this->definitionProvider->getProperties();
		foreach ($properties as $property) {
			// TODO Suche performanter gestalten
			$this->handleProperty($property, $key, $value);
		}
	}

	/**
	 * @param Property $property
	 * @param $name
	 * @param $value
	 */
	private function handleProperty(Property $property, $name, $value) {
		if ($property->annotations()->has('array-key')) {
			$dataKey = $property->annotations()->getFirst('array-key')->getValue();
			if ($dataKey == $name) {
				$value = $this->applyFilters($property, $value);
				$this->writer->setValue($this->object, $property, $value);
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
		if (!$property->annotations()->has('setter-filter')) {
			return $value;
		}
		$setterFilters = $property->annotations()->getAll('setter-filter');
		foreach ($setterFilters as $setterFilter) {
			$filterName = $setterFilter->getValue();
			if (!$this->filters->has($filterName)) {
				throw new Exception("Setter-filter missing: {$filterName}");
			}
			$value = $this->filters->filter($filterName, $value, $setterFilter->options());
		}
		return $value;
	}
}
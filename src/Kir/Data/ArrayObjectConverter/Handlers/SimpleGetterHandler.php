<?php
namespace Kir\Data\ArrayObjectConverter\Handlers;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Filters;
use Kir\Data\ArrayObjectConverter\GetterHandler;
use Kir\Data\ArrayObjectConverter\Handlers\SimpleGetterHandler\PropertyReader;

class SimpleGetterHandler implements GetterHandler {
	/**
	 * @var object
	 */
	private $object = null;

	/**
	 * @var Filters
	 */
	private $filters = null;

	/**
	 * @var DefinitionProvider
	 */
	private $definitionProvider = null;

	/**
	 * @var \Kir\Data\ArrayObjectConverter\Handlers\SimpleGetterHandler\PropertyReader
	 */
	private $reader = null;

	/**
	 * @param object $object
	 * @param DefinitionProvider $definitionProvider
	 * @param Filters $filters
	 */
	public function __construct($object, DefinitionProvider $definitionProvider, Filters $filters) {
		$this->object = $object;
		$this->filters = $filters;
		$this->definitionProvider = $definitionProvider;
		$this->reader = new PropertyReader();
	}

	/**
	 * @return array
	 */
	public function getArray() {
		$result = array();
		$properties = $this->definitionProvider->getProperties();
		foreach ($properties as $property) {
			$result = $this->handleProperty($property, $result);
		}
		return $result;
	}

	/**
	 * @return Filters
	 */
	public function filters() {
		return $this->filters;
	}

	/**
	 * @param Property $property
	 * @param array $result
	 * @return array
	 */
	private function handleProperty(Property $property, array $result) {
		if ($property->annotations()->has('array-key')) {
			$annotation = $property->annotations()->getFirst('array-key');
			$value = $this->reader->getValue($this->object, $property);
			$value = $this->applyFilters($property, $value);
			$annotationValue = $annotation->getValue();
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
		if (!$property->annotations()->has('getter-filter')) {
			return $value;
		}
		$getterFilters = $property->annotations()->getAll('getter-filter');
		foreach ($getterFilters as $getterFilter) {
			$filterName = $getterFilter->getValue();
			if (!$this->filters->has($filterName)) {
				throw new Exception("Getter-filter missing: {$filterName}");
			}
			$value = $this->filters->filter($filterName, $value, $getterFilter->options());
		}
		return $value;
	}
}
<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor;

use Kir\Data\ArrayObjectConverter\Accessor\SetterHandler;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleSetterHandler\Writer;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Specification\Property;
use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;

class SimpleSetterHandler extends SimpleHandler implements SetterHandler {
	/**
	 * @var 
	 */
	private $writer=null;
	
	/**
	 * @param object $object
	 * @param Specification $specification
	 * @param SpecificationProviders $specificationProviders
	 */
	public function __construct($object, Specification $specification, SpecificationProviders $specificationProviders) {
		parent::__construct($object, $specification, $specificationProviders);
		$this->writer = new Writer();
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
	 * @param string $key
	 * @param string $value
	 */
	private function findProperty($key, $value) {
		$properties = $this->getSpecification()->getProperties();
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
				$this->writer->setValue($this->getObject(), $property, $value);
			}
		}
	}

	/**
	 * @param Property $property
	 * @param mixed $value
	 * @throws \Kir\Data\ArrayObjectConverter\Exception
	 * @return mixed
	 */
	private function applyFilters(Property $property, $value) {
		if (!$property->annotations()->has('setter-filter')) {
			return $value;
		}
		$setterFilters = $property->annotations()->get('setter-filter');
		foreach ($setterFilters as $setterFilter) {
			$filterName = $setterFilter->getValue();
			if (!$this->filters()->has($filterName)) {
				throw new Exception("Setter-filter missing: {$filterName}");
			}
			$value = $this->filters()->filter($filterName, $value, $setterFilter->parameters());
		}
		return $value;
	}
}
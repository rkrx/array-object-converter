<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor;

use Kir\Data\ArrayObjectConverter\Accessor\SetterHandler;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleGetterHandler\Reader;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleSetterHandler\Writer;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\Specification\Property;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler\Property AS FilterProperty;

class SimpleSetterHandler extends SimpleHandler implements SetterHandler {
	/**
	 * @var Writer
	 */
	private $writer=null;
	
	/**
	 * @var Reader
	 */
	private $reader=null;

	/**
	 * @param object $object
	 * @param Specification $specification
	 * @param SpecificationProviders $specificationProviders
	 */
	public function __construct($object, Specification $specification, SpecificationProviders $specificationProviders) {
		parent::__construct($object, $specification, $specificationProviders);
		$this->writer = new Writer();
		$this->reader = new Reader();
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
	 * @param $newValue
	 */
	private function handleProperty(Property $property, $name, $newValue) {
		if ($property->annotations()->has('array-key')) {
			$this->setPropertyValue($property, $name, $newValue);
		}
	}

	/**
	 * @param Property $property
	 * @param mixed $newValue
	 * @param mixed $oldValue
	 * @throws \Kir\Data\ArrayObjectConverter\Exception
	 * @return mixed
	 */
	private function applyFilters(Property $property, $oldValue, $newValue) {
		$annotations = $property->annotations();
		if (!($annotations->has('setter-filter') || $annotations->has('filter'))) {
			return $newValue;
		}
		$setterFilters = $annotations->get('setter-filter') + $annotations->get('filter');
		foreach ($setterFilters as $setterFilter) {
			$filterName = $setterFilter->getValue();
			if (!$this->filters()->has($filterName)) {
				throw new Exception("Setter-filter missing: {$filterName}");
			}
			$filterProperty = new FilterProperty($oldValue, $newValue, $setterFilter->parameters());
			$newValue = $this->filters()->filter($filterName, $filterProperty);
		}
		return $newValue;
	}

	/**
	 * @param Property $property
	 * @param $name
	 * @param $newValue
	 */
	private function setPropertyValue(Property $property, $name, $newValue) {
		$dataKey = $property->annotations()->getFirst('array-key')->getValue();
		if($dataKey == $name) {
			$oldValue = $this->reader->getValue($this->getObject(), $property);
			$newValue = $this->applyFilters($property, $oldValue, $newValue);
			if(!$property->annotations()->has('readonly')) {
				$this->writer->setValue($this->getObject(), $property, $newValue);
			}
		}
	}
}
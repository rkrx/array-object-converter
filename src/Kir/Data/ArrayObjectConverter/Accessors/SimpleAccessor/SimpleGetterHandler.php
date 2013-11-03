<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor;

use Kir\Data\ArrayObjectConverter\Accessor\GetterHandler;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleGetterHandler\Reader;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Specification\Property;
use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;

class SimpleGetterHandler extends SimpleHandler implements GetterHandler {
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
		$this->reader = new Reader();
	}
	
	/**
	 * @return array
	 */
	public function getArray() {
		$result = array();
		$properties = $this->getSpecification()->getProperties();
		foreach ($properties as $property) {
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
		if ($property->annotations()->has('array-key')) {
			$value = $this->getValue($property);
			$result = $this->setValue($property, $result, $value);
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
		$getterFilters = $property->annotations()->get('getter-filter');
		foreach ($getterFilters as $getterFilter) {
			$filterName = $getterFilter->getValue();
			if (!$this->filters()->has($filterName)) {
				throw new Exception("Getter-filter missing: {$filterName}");
			}
			$value = $this->filters()->filter($filterName, $value, $getterFilter->parameters());
		}
		return $value;
	}

	/**
	 * @param Property $property
	 * @return mixed
	 */
	private function getValue(Property $property) {
		$value = $this->reader->getValue($this->getObject(), $property);
		$value = $this->applyFilters($property, $value);
		return $value;
	}

	/**
	 * @param Property $property
	 * @param array $result
	 * @param $value
	 * @return array
	 */
	private function setValue(Property $property, array $result, $value) {
		$annotation = $property->annotations()->getFirst('array-key');
		$annotationValue = $annotation->getValue();
		$result[$annotationValue] = $value;
		return $result;
	}
}
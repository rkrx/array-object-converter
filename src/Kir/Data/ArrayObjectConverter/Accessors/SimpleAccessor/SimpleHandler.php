<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;
use Kir\Data\ArrayObjectConverter\Filtering\Filters;
use Kir\Data\ArrayObjectConverter\Accessor\Handler;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler\SimpleFilters;
use Kir\Data\ArrayObjectConverter\Specification\Property;
use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;

abstract class SimpleHandler implements Handler {
	/**
	 * @var object
	 */
	private $object=null;

	/**
	 * @var Specification
	 */
	private $specification=null;

	/**
	 * @var SpecificationProviders
	 */
	private $specificationProviders=null;

	/**
	 * @var \Kir\Data\ArrayObjectConverter\Filtering\Filters
	 */
	private $filters=null;

	/**
	 * @param object $object
	 * @param Specification $specification
	 * @param SpecificationProviders $specificationProviders
	 */
	public function __construct($object, Specification $specification, SpecificationProviders $specificationProviders) {
		$this->object = new ReflObject($object);
		$this->specification = $specification;
		$this->specificationProviders = $specificationProviders;
		$this->filters = new SimpleFilters();
	}

	/**
	 * @return ReflObject
	 */
	final protected function getObject() {
		return $this->object;
	}

	/**
	 * @return Specification
	 */
	final protected function getSpecification() {
		return $this->specification;
	}

	/**
	 * @return SpecificationProviders
	 */
	final protected function getSpecificationProviders() {
		return $this->specificationProviders;
	}

	/**
	 * @return Filters
	 */
	public function filters() {
		return $this->filters;
	}
} 
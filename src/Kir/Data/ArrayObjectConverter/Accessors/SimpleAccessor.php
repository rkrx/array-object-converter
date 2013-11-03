<?php
namespace Kir\Data\ArrayObjectConverter\Accessors;

use Kir\Data\ArrayObjectConverter\Accessor\GetterHandler;
use Kir\Data\ArrayObjectConverter\Accessor\SetterHandler;
use Kir\Data\ArrayObjectConverter\Accessor;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleGetterHandler;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleSetterHandler;
use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;

class SimpleAccessor implements Accessor {
	/**
	 * @var GetterHandler
	 */
	private $getter=null;

	/**
	 * @var SetterHandler
	 */
	private $setter=null;
	
	/**
	 */
	public function __construct($object, Specification $specification, SpecificationProviders $specificationProviders) {
		$this->getter = new SimpleGetterHandler($object, $specification, $specificationProviders);
		$this->setter = new SimpleSetterHandler($object, $specification, $specificationProviders);
	}

	/**
	 * @return SetterHandler
	 */
	public function setter() {
		return $this->setter;
	}

	/**
	 * @return GetterHandler
	 */
	public function getter() {
		return $this->getter;
	}
} 
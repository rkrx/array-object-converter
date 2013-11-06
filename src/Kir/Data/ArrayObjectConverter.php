<?php
namespace Kir\Data;

use Kir\Data\ArrayObjectConverter\Accessor;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\SpecificationProvider;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider;

class ArrayObjectConverter {
	/**
	 * @var object
	 */
	private $object;

	/**
	 * @var Accessor
	 */
	private $accessor=null;

	/**
	 * @param object $object
	 * @param SpecificationProvider $specificationProvider
	 * @param SpecificationProviders $specificationProviders
	 * @param Accessor $accessor
	 * @throws ArrayObjectConverter\Exception
	 */
	public function __construct($object, SpecificationProvider $specificationProvider=null, SpecificationProviders $specificationProviders=null, Accessor $accessor=null) {
		if(!is_object($object)) {
			throw new Exception("Cant work with a non-object");
		}
		$this->object = $object;
		if($specificationProviders === null) {
			$specificationProviders = new SpecificationProviders\ArraySpecificationProviders();
			$specificationProviders->setProvider(new PhpDocSpecificationProvider($object));
		}
		if($specificationProvider === null) {
			$specificationProvider = $specificationProviders->getProvider();
		}
		$specification = $specificationProvider->fromObject($object);
		if($accessor === null) {
			$accessor = new SimpleAccessor($object, $specification, $specificationProviders);
		}
		$this->accessor = $accessor;
	}

	/**
	 * @return array
	 */
	public function getArray() {
		return $this->accessor->getter()->getArray();
	}

	/**
	 * @param array $array
	 * @return object
	 */
	public function setArray(array $array) {
		$this->accessor->setter()->setArray($array);
		return $this->object;
	}

	/**
	 * @return Accessor
	 */
	public function getAccessor() {
		return $this->accessor;
	}
}
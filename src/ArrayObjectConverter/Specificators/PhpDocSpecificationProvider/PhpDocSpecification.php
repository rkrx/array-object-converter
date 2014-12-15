<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider;

use Kir\Data\ArrayObjectConverter\Specification;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocMethod;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty;

class PhpDocSpecification implements Specification {
	/**
	 * @var Specification\Property[]
	 */
	private $properties=null;
	
	/**
	 * @var Specification\Method[]
	 */
	private $methods=null;
	
	/**
	 * @param object $object
	 */
	public function __construct($object) {
		$refObject = new \ReflectionObject($object);
		$this->initProperties($refObject);
		$this->initMethods($refObject);
	}
	
	/**
	 * @return Specification\Property[]
	 */
	public function getProperties() {
		return array_values($this->properties);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasProperty($name) {
		return array_key_exists($name, $this->properties);
	}

	/**
	 * @param string $name
	 * @return Specification\Property
	 */
	public function getProperty($name) {
		return $this->properties[$name];
	}

	/**
	 * @return Specification\Method[]
	 */
	public function getMethods() {
		return array_values($this->methods);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasMethod($name) {
		return array_key_exists($name, $this->methods);
	}

	/**
	 * @param string $name
	 * @return Specification\Method
	 */
	public function getMethod($name) {
		return $this->methods[$name];
	}

	/**
	 * @param \ReflectionObject $refObject
	 */
	public function initProperties($refObject) {
		$properties = $refObject->getProperties();
		foreach ($properties as $property) {
			$this->properties[$property->getName()] = new PhpDocProperty($property);
		}
	}

	/**
	 * @param \ReflectionObject $refObject
	 */
	public function initMethods($refObject) {
		$methods = $refObject->getMethods();
		foreach ($methods as $method) {
			$this->methods[$method->getName()] = new PhpDocMethod($method);
		}
	}
} 
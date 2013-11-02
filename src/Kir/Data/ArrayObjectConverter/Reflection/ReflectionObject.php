<?php
namespace Kir\Data\ArrayObjectConverter\Reflection;

class ReflectionObject {
	/**
	 * @var object
	 */
	private $object = null;

	/**
	 * @var \ReflectionObject
	 */
	private $refObject = null;

	/**
	 * @var ReflectionProperty[]
	 */
	private $properties = [];

	/**
	 * @var bool
	 */
	private $hasAllProperties = false;

	/**
	 * @var ReflectionMethod[]
	 */
	private $methods = [];

	/**
	 * @param object $object
	 */
	public function __construct($object) {
		$this->object = $object;
		$this->refObject = new \ReflectionObject($object);
	}

	/**
	 * @return object
	 */
	public function getObject() {
		return $this->object;
	}

	/**
	 * @return ReflectionProperty[]
	 */
	public function getProperties() {
		if(!$this->hasAllProperties) {
			foreach($this->refObject->getProperties() as $property) {
				$name = $property->getName();
				$this->properties[$name] = $this->getProperty($name);
			}
		}
		$this->hasAllProperties = true;
		return array_values($this->properties);
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasProperty($name) {
		return $this->refObject->hasProperty($name);
	}

	/**
	 * @param $name
	 * @return ReflectionProperty
	 */
	public function getProperty($name) {
		if(!array_key_exists($name, $this->properties)) {
			$property = $this->refObject->getProperty($name);
			$this->properties[$name] = new ReflectionProperty($this, $property);
		}
		return $this->properties[$name];
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasMethod($name) {
		return $this->refObject->hasMethod($name);
	}

	/**
	 * @param $name
	 * @return ReflectionMethod
	 */
	public function getMethod($name) {
		if(!array_key_exists($name, $this->properties)) {
			$method = $this->refObject->getMethod($name);
			$this->methods[$name] = new ReflectionMethod($this, $method);
		}
		return $this->methods[$name];
	}
} 
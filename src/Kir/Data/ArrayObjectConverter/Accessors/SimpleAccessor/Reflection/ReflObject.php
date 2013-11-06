<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject\ReflMethod;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject\ReflProperty;

class ReflObject {
	/**
	 * @var object
	 */
	private $object = null;

	/**
	 * @var \ReflectionObject
	 */
	private $refObject = null;

	/**
	 * @var ReflProperty[]
	 */
	private $properties = [];

	/**
	 * @var bool
	 */
	private $hasAllProperties = false;

	/**
	 * @var ReflMethod[]
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
	 * @return string
	 */
	public function getName() {
		return $this->refObject->getName();
	}

	/**
	 * @return ReflProperty[]
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
	 * @return ReflProperty
	 */
	public function getProperty($name) {
		if(!array_key_exists($name, $this->properties)) {
			$property = $this->refObject->getProperty($name);
			$this->properties[$name] = new ReflProperty($this, $property);
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
	 * @return ReflMethod
	 */
	public function getMethod($name) {
		if(!array_key_exists($name, $this->properties)) {
			$method = $this->refObject->getMethod($name);
			$this->methods[$name] = new ReflMethod($this, $method);
		}
		return $this->methods[$name];
	}
} 
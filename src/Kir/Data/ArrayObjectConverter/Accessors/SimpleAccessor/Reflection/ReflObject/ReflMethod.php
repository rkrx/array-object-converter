<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;

class ReflMethod {
	/**
	 * @var ReflObject
	 */
	private $object=null;

	/**
	 * @var \ReflectionMethod
	 */
	private $method=null;

	/**
	 * @param ReflObject $object
	 * @param \ReflectionMethod $method
	 */
	public function __construct(ReflObject $object, \ReflectionMethod $method) {
		$this->object = $object;
		$this->method = $method;
	}

	/**
	 * @return ReflObject
	 */
	public function getObject() {
		return $this->object;
	}

	/**
	 * @return bool
	 */
	public function hasParameters() {
		return count($this->method->getParameters()) > 0;
	}

	/**
	 * @return \ReflectionParameter[]
	 */
	public function getParameters() {
		return $this->method->getParameters();
	}

	/**
	 * @return mixed
	 */
	public function invoke() {
		return $this->method->invoke($this->object->getObject());
	}

	/**
	 * @param array $args
	 * @return mixed
	 */
	public function invokeArgs(array $args = []) {
		return $this->method->invokeArgs($this->object->getObject(), $args);
	}
} 
<?php
namespace Kir\Data\ArrayObjectConverter\Reflection;

class ReflectionMethod {
	/**
	 * @var ReflectionObject
	 */
	private $object=null;

	/**
	 * @var \ReflectionMethod
	 */
	private $method=null;

	/**
	 * @param ReflectionObject $object
	 * @param \ReflectionMethod $method
	 */
	public function __construct(ReflectionObject $object, \ReflectionMethod $method) {
		$this->object = $object;
		$this->method = $method;
	}

	/**
	 * @return ReflectionObject
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
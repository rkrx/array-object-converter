<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification;

use Kir\Data\ArrayObjectConverter\Specification\Method;

class PhpDocMethod implements Method {
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var array
	 */
	private $parameters=[];

	/**
	 * @param \ReflectionMethod $method
	 */
	public function __construct(\ReflectionMethod $method) {
		$this->name = $method->getName();
		$this->parameters = $method->getParameters();
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function hasArguments() {
		return count($this->parameters) > 0;
	}

	/**
	 * @return Method\Argument[]
	 */
	public function getArguments() {
		return $this->parameters;
	}
} 
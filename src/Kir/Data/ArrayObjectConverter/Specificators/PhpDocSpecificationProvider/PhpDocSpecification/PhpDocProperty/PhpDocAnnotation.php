<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocAnnotation\PhpDocParameters;

class PhpDocAnnotation implements Annotation {
	/**
	 * @param string
	 */
	private $name = null;

	/**
	 * @param string
	 */
	private $value = null;

	/**
	 * @param Parameters
	 */
	private $parameters = null;

	/**
	 * @param string $name
	 * @param string $value
	 * @param Annotation\Parameter[] $params
	 */
	public function __construct($name, $value, array $params) {
		$this->name = $name;
		$this->value = $value;
		$this->parameters = new PhpDocParameters($params);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return bool|int|float|string|null
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return Parameters
	 */
	public function parameters() {
		return $this->parameters;
	}
} 
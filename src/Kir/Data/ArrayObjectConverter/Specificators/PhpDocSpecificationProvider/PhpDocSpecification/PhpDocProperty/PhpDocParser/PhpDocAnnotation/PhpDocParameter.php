<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser\PhpDocAnnotation;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameter;

class PhpDocParameter implements Parameter {
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name, $value) {
		$this->name = $name;
		$this->value = $value;
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
} 
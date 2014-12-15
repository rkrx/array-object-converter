<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocAnnotation\PhpDocParameters;

class ParserAnnotation {
	/**
	 * @var string
	 */
	private $key = '';

	/**
	 * @var array
	 */
	private $value = [];

	/**
	 * @var Parameters
	 */
	private $options = null;

	/**
	 * @param string $key
	 * @param array $value
	 */
	public function __construct($key, array $value) {
		$this->key = $key;
		$this->value = array_key_exists('value', $value) ? $value['value'] : null;
		$options = array_key_exists('options', $value) ? (array)$value['options'] : [];
		$this->options = new PhpDocParameters($options);
	}

	/**
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return Parameters
	 */
	public function options() {
		return $this->options;
	}
} 
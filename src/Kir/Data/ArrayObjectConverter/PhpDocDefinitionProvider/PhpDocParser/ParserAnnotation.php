<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation;

class ParserAnnotation implements Annotation {
	/**
	 * @var string
	 */
	private $key = '';

	/**
	 * @var array
	 */
	private $value = [];

	/**
	 * @var Annotation\Options
	 */
	private $options = null;

	/**
	 * @param string $key
	 * @param array $value
	 */
	public function __construct($key, array $value) {
		$this->key = $key;
		$this->value = array_key_exists('value', $value) ? $value['value'] : null;
		$options = array_key_exists('options', $value) ? (array) $value['options'] : [];
		$this->options = new ParserAnnotation\Options($options);
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
	 * @return Annotation\Options
	 */
	public function options() {
		return $this->options;
	}
} 
<?php
namespace Kir\Data\ArrayObjectConverter;

class Annotation {
	/**
	 * @var string
	 */
	private $key=null;

	/**
	 * @var string
	 */
	private $value=null;

	/**
	 * @var array
	 */
	private $options=array();

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function __construct($key, $value) {
		$this->key = $key;
		$this->value = $value['value'];
		$this->options = new Annotation\Options();
		foreach($value['options'] as $optionName => $optionValue) {
			$this->options->add($optionName, $optionValue);
		}
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
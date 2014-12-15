<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler;

use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property AS IProperty;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

class Property implements IProperty {
	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * @var mixed
	 */
	private $prevValue;

	/**
	 * @var Parameters
	 */
	private $parameters;

	/**
	 * @param mixed $prevValue
	 * @param mixed $value
	 * @param Parameters $parameters
	 */
	public function __construct($prevValue, $value, $parameters) {
		$this->prevValue = $prevValue;
		$this->value = $value;
		$this->parameters = $parameters;
	}

	/**
	 * @return mixed
	 */
	public function getPrevValue() {
		return $this->prevValue;
	}

	/**
	 * @return mixed
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
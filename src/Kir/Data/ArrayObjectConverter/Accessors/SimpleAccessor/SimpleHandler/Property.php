<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler;

use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property AS IProperty;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

class Property implements IProperty {
	/**
	 * @var mixed
	 */
	private $newValue;

	/**
	 * @var mixed
	 */
	private $oldValue;

	/**
	 * @var Parameters
	 */
	private $parameters;

	/**
	 * @param mixed $oldValue
	 * @param mixed $newValue
	 * @param Parameters $parameters
	 */
	public function __construct($oldValue, $newValue, $parameters) {
		$this->oldValue = $oldValue;
		$this->newValue = $newValue;
		$this->parameters = $parameters;
	}

	/**
	 * @return mixed
	 */
	public function getOldValue() {
		return $this->oldValue;
	}

	/**
	 * @return mixed
	 */
	public function getNewValue() {
		return $this->newValue;
	}

	/**
	 * @return Parameters
	 */
	public function parameters() {
		return $this->parameters;
	}
}
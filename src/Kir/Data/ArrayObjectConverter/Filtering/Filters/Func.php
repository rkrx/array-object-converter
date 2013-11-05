<?php
namespace Kir\Data\ArrayObjectConverter\Filtering\Filters;

use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property;
use Kir\Data\ArrayObjectConverter\Filtering\Filter;

class Func implements Filter {
	/**
	 * @var callable
	 */
	private $callable = null;

	/**
	 * @param callable $callable
	 */
	public function __construct(callable $callable) {
		$this->callable = $callable;
	}

	/**
	 * @param Property $property
	 * @return mixed
	 */
	public function filter(Property $property) {
		$callable = $this->callable;
		return $callable($property);
	}
} 
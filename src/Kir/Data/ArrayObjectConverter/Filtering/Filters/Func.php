<?php
namespace Kir\Data\ArrayObjectConverter\Filtering\Filters;

use Kir\Data\ArrayObjectConverter\Filtering\Filter;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

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
	 * @param mixed $input
	 * @param Parameters $parameters
	 * @return mixed
	 */
	public function filter($input, Parameters $parameters) {
		$callable = $this->callable;
		return $callable($input, $parameters);
	}
} 
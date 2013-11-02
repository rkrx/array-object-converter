<?php
namespace Kir\Data\ArrayObjectConverter\Filtering\Filter;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation\Options;
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
	 * @param mixed $input
	 * @param Options $options
	 * @return mixed
	 */
	public function filter($input, Options $options) {
		$callable = $this->callable;
		return $callable($input, $options);
	}
} 
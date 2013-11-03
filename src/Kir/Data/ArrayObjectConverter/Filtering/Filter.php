<?php
namespace Kir\Data\ArrayObjectConverter\Filtering;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

interface Filter {
	/**
	 * @param mixed $input
	 * @param Parameters $parameters
	 * @return mixed
	 */
	public function filter($input, Parameters $parameters);
} 
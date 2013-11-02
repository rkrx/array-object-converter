<?php
namespace Kir\Data\ArrayObjectConverter\Filtering;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation\Options;

interface Filter {
	/**
	 * @param mixed $input
	 * @param Options $options
	 * @return mixed
	 */
	public function filter($input, Options $options);
} 
<?php
namespace Kir\Data\ArrayObjectConverter\Filtering;

use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property;

interface Filter {
	/**
	 * @param Property $property
	 * @return mixed
	 */
	public function filter(Property $property);
} 
<?php
namespace Kir\Data\ArrayObjectConverter\Accessor;

use Kir\Data\ArrayObjectConverter\Filtering\Filters;

interface Handler {
	/**
	 * @return Filters
	 */
	public function filters();
} 
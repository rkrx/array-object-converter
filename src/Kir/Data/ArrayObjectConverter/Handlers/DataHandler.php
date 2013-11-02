<?php
namespace Kir\Data\ArrayObjectConverter\Handlers;

use Kir\Data\ArrayObjectConverter\Filtering\Filters;

interface DataHandler {
	/**
	 * @return \Kir\Data\ArrayObjectConverter\Filtering\Filters
	 */
	public function filters();
} 
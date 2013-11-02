<?php
namespace Kir\Data\ArrayObjectConverter;

interface GetterHandler {
	/**
	 * @return array
	 */
	public function getArray();

	/**
	 * @return Filters
	 */
	public function filters();
} 
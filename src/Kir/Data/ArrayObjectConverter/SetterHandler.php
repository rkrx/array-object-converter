<?php
namespace Kir\Data\ArrayObjectConverter;

/**
 */
interface SetterHandler {
	/**
	 * @param array $array
	 * @return $this
	 */
	public function setArray(array $array);

	/**
	 * @return Filters
	 */
	public function filters();
} 
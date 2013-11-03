<?php
namespace Kir\Data\ArrayObjectConverter\Accessor;

interface SetterHandler extends Handler {
	/**
	 * @param array $array
	 * @return object
	 */
	public function setArray(array $array);
} 
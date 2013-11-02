<?php
namespace Kir\Data\ArrayObjectConverter\Handlers;

/**
 */
interface SetterHandler extends DataHandler {
	/**
	 * @param array $array
	 * @return $this
	 */
	public function setArray(array $array);
} 
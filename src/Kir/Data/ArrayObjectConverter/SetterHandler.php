<?php
namespace Kir\Data\ArrayObjectConverter;

/**
 */
interface SetterHandler extends DataHandler {
	/**
	 * @param array $array
	 * @return $this
	 */
	public function setArray(array $array);
} 
<?php
namespace Kir\Data\ArrayObjectConverter\Accessor;

interface GetterHandler extends Handler {
	/**
	 * @return array
	 */
	public function getArray();
} 
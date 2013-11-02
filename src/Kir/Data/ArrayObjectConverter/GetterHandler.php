<?php
namespace Kir\Data\ArrayObjectConverter;

interface GetterHandler extends DataHandler {
	/**
	 * @return array
	 */
	public function getArray();
} 
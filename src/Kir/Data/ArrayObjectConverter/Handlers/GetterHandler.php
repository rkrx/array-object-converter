<?php
namespace Kir\Data\ArrayObjectConverter\Handlers;

interface GetterHandler extends DataHandler {
	/**
	 * @return array
	 */
	public function getArray();
} 
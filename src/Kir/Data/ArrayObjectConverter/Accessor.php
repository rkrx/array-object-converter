<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\Accessor\GetterHandler;
use Kir\Data\ArrayObjectConverter\Accessor\SetterHandler;

interface Accessor {
	/**
	 * @return SetterHandler
	 */
	public function setter();

	/**
	 * @return GetterHandler
	 */
	public function getter();
} 
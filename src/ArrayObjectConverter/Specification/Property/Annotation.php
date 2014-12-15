<?php
namespace Kir\Data\ArrayObjectConverter\Specification\Property;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

interface Annotation {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return bool|int|float|string|null
	 */
	public function getValue();

	/**
	 * @return Parameters
	 */
	public function parameters();
} 
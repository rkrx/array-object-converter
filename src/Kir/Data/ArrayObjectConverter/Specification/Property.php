<?php
namespace Kir\Data\ArrayObjectConverter\Specification;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotations;

/**
 */
interface Property {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getType();

	/**
	 * @return Annotations
	 */
	public function annotations();
} 
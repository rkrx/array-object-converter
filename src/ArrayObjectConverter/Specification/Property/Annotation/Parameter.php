<?php
namespace Kir\Data\ArrayObjectConverter\Specification\Property\Annotation;

interface Parameter {
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return bool|int|float|string|null
	 */
	public function getValue();
} 
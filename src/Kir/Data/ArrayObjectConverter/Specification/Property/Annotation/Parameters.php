<?php
namespace Kir\Data\ArrayObjectConverter\Specification\Property\Annotation;

interface Parameters {
	/**
	 * @return Parameter[]
	 */
	public function getAll();

	/**
	 * @param string $name
	 * @return Parameter
	 */
	public function get($name);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name);
} 
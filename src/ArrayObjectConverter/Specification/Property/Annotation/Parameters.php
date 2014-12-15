<?php
namespace Kir\Data\ArrayObjectConverter\Specification\Property\Annotation;

interface Parameters {
	/**
	 * @return Parameter[]
	 */
	public function getAll();

	/**
	 * @param string $name
	 * @throws NoSuchParameterException
	 * @return Parameter
	 */
	public function get($name);

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name);

	/**
	 * @param string $name
	 * @param bool|int|float|string|null $default
	 * @return bool|int|float|string|null
	 */
	public function getValue($name, $default=null);
} 
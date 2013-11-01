<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation;

/**
 */
interface Options {
	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name);

	/**
	 * @return array
	 */
	public function getAll();

	/**
	 * @param string $name
	 * @param string $value
	 * @return $this
	 */
	public function add($name, $value);

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($name, $default = null);
}
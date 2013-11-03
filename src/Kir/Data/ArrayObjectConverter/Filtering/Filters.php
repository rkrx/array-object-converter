<?php
namespace Kir\Data\ArrayObjectConverter\Filtering;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation\Parameters;

interface Filters {
	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name);

	/**
	 * @return Filter[]
	 */
	public function getAll();

	/**
	 * @param string $name
	 * @param mixed $value
	 * @param Parameters $parameters
	 * @return mixed
	 */
	public function filter($name, $value, Parameters $parameters);

	/**
	 * @param string $name
	 * @param Filter $filter
	 * @return $this
	 */
	public function add($name, Filter $filter);

	/**
	 * @return $this
	 */
	public function clear();
}
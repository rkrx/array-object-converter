<?php
namespace Kir\Data\ArrayObjectConverter\Filtering;

use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property;
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
	 * @param Property $property
	 * @return mixed
	 */
	public function filter($name, Property $property);

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

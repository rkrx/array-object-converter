<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler;

use Kir\Data\ArrayObjectConverter\Accessor\Handler\Property;
use Kir\Data\ArrayObjectConverter\Filtering\Filter;
use Kir\Data\ArrayObjectConverter\Filtering\Filters;

class SimpleFilters implements Filters {
	/**
	 * @var Filter[]
	 */
	private $filters = array();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return array_key_exists($name, $this->filters);
	}

	/**
	 * @param string $name
	 * @param Filter $filter
	 * @return $this
	 */
	public function add($name, Filter $filter) {
		$this->filters[$name] = $filter;
		return $this;
	}

	/**
	 * @return Filter[]
	 */
	public function getAll() {
		return $this->filters;
	}

	/**
	 * @return $this
	 */
	public function clear() {
		$this->filters = array();
		return $this;
	}

	/**
	 * @param string $name
	 * @param Property $property
	 * @return mixed
	 */
	public function filter($name, Property $property) {
		$filter = $this->filters[$name];
		return $filter->filter($property);
	}
}

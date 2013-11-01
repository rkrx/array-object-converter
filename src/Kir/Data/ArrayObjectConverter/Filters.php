<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation\Options;

class Filters {
	/**
	 * @var Filter[]
	 */
	private $filters=array();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return array_key_exists($name, $this->filters);
	}

	/**
	 * @param string $name
	 * @param Filter $func
	 * @return $this
	 */
	public function add($name, Filter $func) {
		$this->filters[$name] = $func;
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
	 * @param mixed $value
	 * @param Options $options
	 * @return mixed
	 */
	public function filter($name, $value, Options $options) {
		$filter = $this->filters[$name];
		return $filter->filter($value, $options);
	}
}
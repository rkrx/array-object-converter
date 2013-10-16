<?php
namespace Kir\Data\ArrayObjectConverter;

class Filters {
	/**
	 * @var callable[]
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
	 * @param callable $func
	 * @return $this
	 */
	public function add($name, callable $func) {
		$this->filters[$name] = $func;
		return $this;
	}

	/**
	 * @return callable[]
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
	 * @param Annotation\Options $options
	 * @return mixed
	 */
	public function filter($name, $value, Annotation\Options $options) {
		$callable = $this->filters[$name];
		return $callable($value, $options);
	}
}
<?php
namespace Kir\Data\ArrayObjectConverter\Annotation;

class Options {
	/**
	 * @var array
	 */
	private $options=array();

	/**
	 * @param string $name
	 * @param string $value
	 * @return $this
	 */
	public function add($name, $value) {
		$this->options[$name] = $value;
		return $this;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return array_key_exists($name, $this->options);
	}

	/**
	 * @return array
	 */
	public function getAll() {
		return $this->options;
	}

	/**
	 * @param string $name
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($name, $default=null) {
		if($this->has($name)) {
			return $this->options[$name];
		}
		return $default;
	}
}
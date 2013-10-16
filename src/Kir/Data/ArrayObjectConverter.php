<?php
namespace Kir\Data;

class ArrayObjectConverter {
	/**
	 * @var object
	 */
	private $object;

	/**
	 * @var ArrayObjectConverter\Filters
	 */
	private $setterFilters = array();

	/**
	 * @var ArrayObjectConverter\Filters
	 */
	private $getterFilters = array();

	/**
	 * @param object $object
	 */
	public function __construct($object) {
		$this->object = $object;
		$this->setterFilters = new ArrayObjectConverter\Filters();
		$this->getterFilters = new ArrayObjectConverter\Filters();
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setArray(array $data) {
		$setter = new ArrayObjectConverter\Setter($this->object, $this->setterFilters);
		$setter->set($data);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getArray() {
		$getter = new ArrayObjectConverter\Getter($this->object, $this->getterFilters);
		return $getter->get();
	}

	/**
	 * @return ArrayObjectConverter\Filters
	 */
	public function setterFilters() {
		return $this->setterFilters;
	}

	/**
	 * @return ArrayObjectConverter\Filters
	 */
	public function getterFilters() {
		return $this->getterFilters;
	}
}
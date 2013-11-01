<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

class TestObj2 {
	/**
	 * @var int
	 * @aoc-array-key data
	 */
	private $property = 123;

	/**
	 * @param int $property
	 * @return $this
	 */
	public function setProperty($property) {
		$this->property = $property;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getProperty() {
		return $this->property;
	}
} 
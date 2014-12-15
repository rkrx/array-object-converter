<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

class Subject4 {
	/**
	 * @var string
	 * @aoc-array-key data
	 * @aoc-getter-filter uppercase
	 * @aoc-setter-filter lowercase
	 */
	private $property = "this is a test";

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
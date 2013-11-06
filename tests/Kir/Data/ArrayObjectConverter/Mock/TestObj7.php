<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

class TestObj7 {
	/**
	 * @var TestObj6\SubObj
	 * @aoc-array-key active
	 * @aoc-get-by object
	 * @aoc-set-by object
	 */
	public $active = null;

	/**
	 * @return bool
	 */
	public function isActive() {
		return $this->active;
	}

	/**
	 * @param bool $value
	 */
	public function setIsActive($value) {
		$this->active = $value;
	}
}
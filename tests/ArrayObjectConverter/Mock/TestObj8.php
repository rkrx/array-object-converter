<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

class TestObj8 {
	/**
	 * @var bool
	 * @aoc-array-key active
	 * @aoc-force-access
	 */
	private $active = null;

	/**
	 * @param bool $active
	 * @return $this
	 */
	public function setActiveX($active) {
		$this->active = $active;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getActiveX() {
		return $this->active;
	}
}
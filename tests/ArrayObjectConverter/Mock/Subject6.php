<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

use Kir\Data\ArrayObjectConverter\Mock\TestObj6\SubObj;

class Subject6 {
	/**
	 * @var TestObj6\SubObj
	 * @aoc-array-key sub
	 * @aoc-filter object
	 */
	public $subObj = null;

	/**
	 */
	public function __construct() {
		$this->subObj = new SubObj();
	}
}
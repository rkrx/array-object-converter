<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

use Kir\Data\ArrayObjectConverter\Mock\TestObj6\SubObj;

class TestObj6 {
	/**
	 * @var TestObj6\SubObj
	 * @aoc-array-key sub
	 * @aoc-object-handler
	 */
	public $subObj = null;

	/**
	 */
	public function __construct() {
		$this->subObj = new SubObj();
	}
}
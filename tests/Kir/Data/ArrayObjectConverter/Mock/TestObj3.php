<?php
namespace Kir\Data\ArrayObjectConverter\Mock;

class TestObj3 {
	/**
	 * @var string
	 * @aoc-array-key data
	 * @aoc-getter-filter uppercase
	 * @aoc-setter-filter lowercase
	 */
	public $property = "";
} 
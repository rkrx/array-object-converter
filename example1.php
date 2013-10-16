<?php
require_once '_inc/autoloader.php';

class Entity {
	/**
	 * @var int
	 * @aoc-data-key id
	 */
	public $id = 123;

	/**
	 * @var int
	 * @aoc-data-key name
	 */
	public $name = 'Hello World';
}

$entity = new Entity();
$converter = new \Kir\Data\ArrayObjectConverter($entity);
$data = $converter->getArray();
print_r($data);